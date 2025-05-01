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
use App\Models\PaymentLog;
use App\Models\OrderDetail;
use App\Models\ShippingFee;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Models\OrderDiscount;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Enums\PaymentStatus;

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

        // $today = Carbon::now();
        $today = Carbon::now('Asia/Ho_Chi_Minh');


        $vouchers = Discount::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('quantity', '>', 0)
            ->get();
            // Kiểm tra và loại bỏ voucher mà user đã từng sử dụng
        if ($user) {
            $usedDiscountIds = OrderDiscount::whereIn('order_id', Order::where('user_id', $user->id)->pluck('id'))
                ->pluck('discount_id')
                ->toArray();

            $vouchers = $vouchers->filter(function ($voucher) use ($usedDiscountIds) {
                return !in_array($voucher->id, $usedDiscountIds);
            });
        }

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

            // Kiểm tra và giới hạn max_discount_value nếu có
            if (!empty($voucher->max_discount_value) && $voucher->computed_value > $voucher->max_discount_value) {
                $voucher->computed_value = $voucher->max_discount_value;
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
        DB::beginTransaction();

        try {
            $user = auth()->user();

            if ($request->filled('user_address_id')) {
                $selectedAddress = $user->addresses->where('id', $request->user_address_id)->firstOrFail();
            
                $provinceId = $selectedAddress->province_id;
                $districtId = $selectedAddress->district_id;
                $wardId = $selectedAddress->ward_id;
                $address_detail = $selectedAddress-> address_detail;
            } else {

                $provinceId = $request->new_province_id;
                $districtId = $request->new_district_id;
                $wardId = $request->new_ward_id;
                $address_detail = $request-> new_address_detail;

                UserAddress::create([
                    'user_id' => $user->id,  // Thêm user_id vào bảng user_addresses
                    'address_detail' => $address_detail,
                    'province_id' => $provinceId,
                    'district_id' => $districtId,
                    'ward_id' => $wardId,
                ]);
            }
            

            if (!$provinceId || !$districtId || !$wardId) {
                return back()->with('error', 'Không tìm thấy địa chỉ hợp lệ!');
            }

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

            $inactiveProductNames = $cartItems->filter(function ($item) {
                $variant = $item->variant;
                $product = optional($variant)->product;
            
                return optional($variant)->is_active == 0 || optional($product)->is_active == 0;
            })->pluck('product.name')->toArray();
            
            if (!empty($inactiveProductNames)) {
                return back()->with('error', 'Sản phẩm "' . implode(', ', $inactiveProductNames) . '" đã ngừng bán, vui lòng kiểm tra lại giỏ hàng!');
            }
            

            $totalProductPrice = $cartItems->sum(function($item) {
                return ($item->variant->price ?? 0) * $item->quantity;
            });
            
            $shippingFee = (float) ($request->shipping_fee ?? 0);
            $discountValue = 0;
            
            // Xử lý voucher giảm giá nếu có
            if ($request->filled('discount_id')) {
                $voucher = Discount::find($request->discount_id);
                if ($voucher) {
                    $discountValue = $voucher->type == 'percent'
                        ? $totalProductPrice * $voucher->value / 100
                        : $voucher->value;
                }
            }
            
            $finalTotal = max(0, $totalProductPrice - $discountValue + $shippingFee);
            
            // Tạo đơn hàng
            $order = Order::create([
                'user_id'         => $user->id,
                'shipper_id'      => 1,
                'province_id'     => $provinceId,
                'district_id'     => $districtId,
                'ward_id'         => $wardId,
                'address_detail'  => $address_detail,
                'payment_method'  => $request->payment_method,
                'shipping_fee'    => $shippingFee,
                'shipping_status' => 'pending',
                'total_amount'    => $finalTotal,
                'status'          => OrderStatus::PENDING_CONFIRMATION->value
            ]);
            
            foreach ($cartItems as $cartItem) {
                // Lấy số lượng tồn kho của variant sản phẩm
                $stock = $cartItem->variant->stock;
            
                // Kiểm tra nếu số lượng tồn kho không đủ
                if ($stock < $cartItem->quantity) {
                    // Nếu số lượng trong kho không đủ, sửa lại số lượng đặt mua và thông báo cho người dùng
                    $cartItem->quantity = $stock; // Cập nhật số lượng đặt mua theo số lượng tồn kho
            
                    // Gửi thông báo về việc giảm số lượng sản phẩm trong đơn hàng
                    return back()->with('error', 'Sản phẩm ' . $cartItem->product->name . ' không đủ trong kho. Số lượng đã được giảm xuống ' . $stock . ' sản phẩm.');
                }
            
                // Tạo chi tiết đơn hàng
                OrderDetail::create([
                    'order_id'           => $order->id,
                    'product_id'         => $cartItem->product_id,
                    'product_variant_id' => $cartItem->product_variant_id,
                    'unit_price'         => \App\Models\ProductVariant::find($cartItem->product_variant_id)?->price,
                    'quantity'           => $cartItem->quantity,
                ]);
            
                // Giảm số lượng tồn kho của variant
                $cartItem->variant->decrement('stock', $cartItem->quantity);
            }
            

            if ($discountValue > 0) {
                OrderDiscount::create([
                    'order_id'        => $order->id,
                    'discount_id'     => $request->discount_id,
                    'discount_value'  => $discountValue,
                ]);
            }

            Cart::whereIn('id', $selectedCartIds)->delete();

            // Ghi log Payment
            PaymentLog::create([
                'order_id' => $order->id,
                'amount'   => $finalTotal,
                'method'   => $request->payment_method,
                'status'   => PaymentStatus::PENDING, // ban đầu chưa thanh toán
            ]);

            DB::commit();

            switch ($request->payment_method) {
                case 'CASH':
                    return redirect()->route('order')
                        ->with('success', 'Đơn hàng đã được đặt thành công! Thanh toán khi nhận hàng.');

                case 'bank_transfer':
                    return redirect()->route('order.bank_transfer')
                        ->with('success', 'Vui lòng chuyển khoản theo thông tin hiển thị.');

                case 'momo':
                    return redirect()->route('order.momo')
                        ->with('success', 'Vui lòng thanh toán qua ví Momo.');

                case 'VNPAY':
                    $vnp_Url = $this->buildVnpayUrl($order, $finalTotal);
                    return redirect($vnp_Url);

                default:
                    return redirect()->route('cart.index')
                        ->with('error', 'Phương thức thanh toán không hợp lệ!');
            }

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Place Order Error: ' . $e->getMessage());
            return back()->with('error', 'Đã có lỗi xảy ra, vui lòng thử lại sau!');
        }
    }

    public function generateVnpayUrl(Request $request)
    {
        $orderId = $request->input('order_id');
        $finalTotal = $request->input('total_price');

        $order = Order::findOrFail($orderId);

        if ($order->payment->method == \App\Enums\PaymentMethod::VNPAY &&
            in_array($order->payment->status, [\App\Enums\PaymentStatus::PENDING, \App\Enums\PaymentStatus::FAILED])) {
            $vnpayUrl = $this->buildVnpayUrl($order, $finalTotal);
            return redirect($vnpayUrl);
        }

        return redirect()->back()->with('error', 'Không thể tạo URL thanh toán');
    }

    private function buildVnpayUrl($order, $finalTotal)
    {
        $vnp_Url        = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl  = route('vnpay.return');
        $vnp_TmnCode    = "0BQGSJLL";
        $vnp_HashSecret = "YYDH932FZ19XBC6F79BXIG833K2UO7ON";

        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $finalTotal * 100,
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => request()->ip(),
            "vnp_Locale"     => 'vn',
            "vnp_OrderInfo"  => 'Thanh toán đơn hàng',
            "vnp_OrderType"  => 'billpayment',
            "vnp_ReturnUrl"  => $vnp_Returnurl,
            "vnp_TxnRef"     => $order->id
        ];

        ksort($inputData);
        $query = urldecode(http_build_query($inputData));

        $hashdata = collect($inputData)
            ->map(fn($v, $k) => urlencode($k) . "=" . urlencode($v))
            ->implode('&');

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        return "{$vnp_Url}?{$query}&vnp_SecureHash={$vnpSecureHash}";
    }









}
