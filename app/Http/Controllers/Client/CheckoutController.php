<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Ward;
use App\Models\Order;
use App\Models\Discount;
use App\Models\District;
use App\Models\Province;
use App\Enums\OrderStatus;
use App\Models\OrderDetail;
use App\Models\ShippingFee;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Models\OrderDiscount;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // API lấy Districts theo Province
    public function getDistricts($province_id)
    {
        $districts = District::where('province_id', $province_id)->get();
        return response()->json($districts);
    }

    // API lấy Wards theo District
    public function getWards($district_id)
    {
        $wards = Ward::where('district_id', $district_id)->get();
        return response()->json($wards);
    }
    public function getShippingFee($district_id)
    {
        $shipping =ShippingFee::where('district_id', $district_id)->first();

        // Nếu không có phí cụ thể cho district thì mặc định 30k
        $fee = $shipping ? ($shipping->is_free ? 0 : $shipping->fee) : 30000;

        return response()->json(['fee' => $fee]);
    }

    public function index(Request $request)
    {
        $provinces = Province::all(); // Load sẵn Province

        $cartIds = $request->input('cart_id');      // Mảng cart_id gửi lên
        $quantities = $request->input('quantity');  // Mảng quantity tương ứng

        if (is_array($cartIds) && is_array($quantities) && count($cartIds) === count($quantities)) {
            foreach ($cartIds as $index => $cartId) {
                $quantity = (int) $quantities[$index];
                if ($quantity >= 1) {
                    Cart::where('id', $cartId)->update(['quantity' => $quantity]);
                }
            }
        }

        $cartItems = [];
        foreach ($cartIds as $cartId) {
            $cartItem = Cart::with([
                'product.images',
                'variant.variantAttributes.attributeValue',
                'variant.product',
                'variant.images'
            ])->where('id', $cartId)->first();

            if ($cartItem) {
                $cartItems[] = $cartItem;
            }
        }
        $totalCart = 0;
        foreach($cartItems as $cartItem){
            $totalPrice = $cartItem->variant->price * $cartItem->quantity;
            $totalCart += $totalPrice;
        }

        $user = auth()->user();
        $userAddresses = $user ? $user->addresses : collect();
        $userAddress = $userAddresses->first(); // Lấy địa chỉ đầu tiên nếu có

        // ✅ Load districts và wards nếu userAddress có
        $districts = $userAddress ? District::where('province_id', $userAddress->province_id)->get() : collect();
        $wards = $userAddress ? Ward::where('district_id', $userAddress->district_id)->get() : collect();

        $today = Carbon::now();

        $vouchers = Discount::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('quantity', '>', 0)
            ->get();

        // Kiểm tra xem voucher là kiểu 'percent' (giảm giá phần trăm) hay 'fixed' (giảm giá cố định)
        $vouchers = $vouchers->map(function ($voucher) use ($totalCart) {
            $voucher->computed_value = 0;

            if ($voucher->type === 'percent') {
                $voucher->display_type   = 'Giảm giá theo %';
                $voucher->computed_value = floor(($totalCart * $voucher->value) / 100);
            } elseif ($voucher->type === 'fixed') {
                $voucher->display_type   = 'Giảm giá cố định';
                $voucher->computed_value = $voucher->value;
            } else {
                $voucher->display_type   = 'Không xác định';
                $voucher->computed_value = 0;
            }

            return $voucher;
        });

        return view('client.page.checkout.index', compact('cartItems', 'provinces', 'user', 'userAddresses', 'userAddress', 'districts', 'wards','totalCart','vouchers'));
    }

    public function saveAddress(Request $request)
    {
        $request->validate([
            'address_detail' => 'required|string|max:255',
            'province_id' => 'required|integer|exists:provinces,id',
            'district_id' => 'required|integer|exists:districts,id',
            'ward_id' => 'required|integer|exists:wards,id',
        ]);

        $user = auth()->user();

        // Tìm hoặc tạo địa chỉ mới cho user
        $address = UserAddress::updateOrCreate(
            ['user_id' => $user->id], // Điều kiện tìm kiếm
            [
                'address_detail' => $request->address_detail,
                'province_id' => $request->province_id,
                'district_id' => $request->district_id,
                'ward_id' => $request->ward_id,
            ]
        );

        return response()->json([
            'message' => 'Lưu địa chỉ thành công!',
            'address' => $address
        ]);
    }

    public function placeOrder(Request $request)
    {
        $user = auth()->user();

        // Lấy địa chỉ mặc định của user nếu có
        $defaultAddress = $user->addresses->first();
        $provinceId = $defaultAddress?->province_id ?? $request->province_id;
        $districtId = $defaultAddress?->district_id ?? $request->district_id;
        $wardId = $defaultAddress?->ward_id ?? $request->ward_id;

        if (!$provinceId || !$districtId || !$wardId) {
            return back()->with('error', 'Không tìm thấy địa chỉ hợp lệ!');
        }

        // Kiểm tra nếu không có sản phẩm nào được chọn
        if (!$request->has('cart_items')) {
            return back()->with('error', 'Không có sản phẩm nào được chọn trong giỏ hàng!');
        }

        $selectedCartIds = array_keys($request->cart_items);
        $cartItems = Cart::where('user_id', $user->id)
                         ->whereIn('id', $selectedCartIds)
                         ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng!');
        }

        // Tính tổng tiền sản phẩm từ bảng variants
        $totalProductPrice = 0;
        foreach ($cartItems as $cartItem) {
            $price = $cartItem->variant->price ?? 0;
            $totalProductPrice += $price * $cartItem->quantity;
        }

        // Lấy phí ship
        $shippingFee = (float) ($request->shipping_fee ?? 0);

        // Kiểm tra voucher giảm giá
        $discountValue = 0;
        if ($request->filled('discount_id')) {
            $voucher = Discount::find($request->discount_id);
            if ($voucher) {
                $discountValue = $voucher->value;
            }
        }

        // Tính tổng thanh toán
        $finalTotal = max(0, $totalProductPrice - $discountValue + $shippingFee);

        // Tạo đơn hàng

        // truyền thêm user_address_id vào đây nhé
        $order = Order::create([
            'user_id'         => $user->id,
            'shipper_id'      => 1,
            'address_detail'  => $request->address_detail,
            'province_id'     => $provinceId,
            'district_id'     => $districtId,
            'ward_id'         => $wardId,
            'payment_method'  => $request->payment_method,
            'shipping_fee'    => $shippingFee,
            'shipping_status' => 'pending',
            'total_amount'    => $finalTotal,
            'status'          => OrderStatus::PENDING_CONFIRMATION->value
        ]);

        // 🌟 **Thêm vào bảng `order_details` và cập nhật stock sản phẩm**
        foreach ($cartItems as $cartItem) {
            OrderDetail::create([
                'order_id'           => $order->id,
                'product_id'         => $cartItem->product_id,
                'product_variant_id' => $cartItem->product_variant_id,
                'quantity'           => $cartItem->quantity,
            ]);

            // Cập nhật stock của sản phẩm (giảm số lượng tồn kho)
            $variant = ProductVariant::find($cartItem->product_variant_id);
            if ($variant) {
                $variant->decrement('stock', $cartItem->quantity);
            }
        }

        // 🌟 **Thêm vào bảng `order_discounts` nếu có giảm giá**
        if ($discountValue > 0) {
            OrderDiscount::create([
                'order_id'    => $order->id,
                'discount_id' => $request->discount_id,
                'discount_value'      => $discountValue,
            ]);
        }

        // 🌟 **Xóa cart sau khi đặt hàng thành công**
        Cart::whereIn('id', $selectedCartIds)->delete();
    // DB::beginTransaction()
        // 🌟 **Xử lý phương thức thanh toán**
        switch ($request->payment_method) {
            case 'CASH':
                return redirect()->route('order.success')->with('success', 'Đơn hàng đã được đặt thành công! Thanh toán khi nhận hàng.');

            case 'bank_transfer':
                return redirect()->route('order.bank_transfer')->with('success', 'Vui lòng chuyển khoản theo thông tin hiển thị.');

            case 'momo':
                return redirect()->route('order.momo')->with('success', 'Vui lòng thanh toán qua ví Momo.');

            case 'VNPAY':
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_Returnurl = route('vnpay.return');
                $vnp_TmnCode = "0BQGSJLL"; // Mã website tại VNPAY
                $vnp_HashSecret = "YYDH932FZ19XBC6F79BXIG833K2UO7ON"; // Chuỗi bí mật

                $vnp_TxnRef = $order->id; // Mã đơn hàng
                $vnp_OrderInfo = 'Thanh toán đơn hàng';
                $vnp_OrderType = 'billpayment';
                $vnp_Amount = $finalTotal * 100; // Số tiền cần nhân 100 theo yêu cầu của VNPay
                $vnp_Locale = 'vn';
                $vnp_BankCode = '';
                $vnp_IpAddr = request()->ip();

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef
                );

                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }

                return redirect($vnp_Url);

            default:
                return redirect()->route('cart.index')->with('error', 'Phương thức thanh toán không hợp lệ!');
        }
    }








}
