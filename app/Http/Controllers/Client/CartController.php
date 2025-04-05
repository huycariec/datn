<?php

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{
    public function store(Request $request) {
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
        }

        // Lấy SKU từ request
        $sku = $request->input('sku');

        // Tìm product_variant theo SKU
        $productVariant = ProductVariant::where('sku', $sku)->first();

        if (!$productVariant) {
            return redirect()->back()->with('error', 'Sản phẩm không hợp lệ!');
        }

        // Lấy thông tin cần thiết
        $userId = Auth::id();
        $productId = $request->input('product_id');
        $variantId = $productVariant->id;
        $quantity = $request->input('quantity', 1); // Mặc định là 1 nếu không có input

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->where('product_variant_id', $variantId)
                        ->first();

        if ($cartItem) {
            // Nếu đã có, cập nhật lại số lượng thay vì cộng dồn
            $cartItem->update(['quantity' => $quantity]);
        } else {
            // Nếu chưa có, thêm mới vào giỏ hàng
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }
    public function index()
    {
        $cartItems = Cart::with([
            'product.images',
            'variant.images',
            'variant.variantAttributes.attributeValue.attribute',
            'product.variants.variantAttributes.attributeValue.attribute'
        ])
        ->where('user_id', Auth::id())
        ->get()
        ->map(function ($cart) {
            $product = $cart->product;
            $variant = $cart->variant;

            // Lấy danh sách thuộc tính đã chọn của biến thể hiện tại
            $selectedAttributes = $variant->variantAttributes->mapWithKeys(function ($variantAttribute) {
                return [
                    optional($variantAttribute->attributeValue->attribute)->name => optional($variantAttribute->attributeValue)->value
                ];
            })->toArray();

            // Lấy tất cả thuộc tính của sản phẩm theo từng biến thể, nhóm theo `product_id-variant_id`
            $allAttributes = $product->variants->mapWithKeys(function ($variant) {
                $variantKey = $variant->product_id . '-' . $variant->id;

                return [
                    $variantKey => $variant->variantAttributes->mapWithKeys(function ($variantAttribute) {
                        return [
                            optional($variantAttribute->attributeValue->attribute)->name => optional($variantAttribute->attributeValue)->value
                        ];
                    })->toArray()
                ];
            })->toArray();

            return [
                'cart_id' => $cart->id,
                'quantity' => $cart->quantity,
                'stock' => optional($variant)->stock ,
                'product_name' => optional($product)->name ?? 'Sản phẩm không tồn tại',
                'variant_price' => number_format(optional($variant)->price ?? 0, 2, '.', ''),
                'product_image' => optional($variant->images->first())->url ??
                                   optional($product->images->first())->url ?? null,
                'selected_attributes' => $selectedAttributes, // Chỉ thuộc tính của biến thể hiện tại
                'all_attributes' => $allAttributes // Nhóm tất cả biến thể theo product_id-variant_id
            ];
        })->values()->toArray();


        // dd($cartItems);

        return view('client.page.cart.index', compact('cartItems'));

    }

    public function remove(Request $request)
    {
        $cartId = $request->input('cart_id');

        // Kiểm tra sản phẩm có tồn tại trong giỏ hàng không
        $cartItem = Cart::find($cartId);

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }

        // Xóa sản phẩm khỏi giỏ hàng
        $cartItem->delete();

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }
    public function updateVariant(Request $request)
    {

        // Tìm product_variant theo SKU
        $variant =ProductVariant::where('sku', $request->sku)->first();

        if (!$variant) {
            return back()->with('error', 'Biến thể sản phẩm không tồn tại!');
        }

        // Lấy giỏ hàng cần cập nhật
        $cart =Cart::find($request->cart_id);

        // Nếu số lượng trong giỏ lớn hơn tồn kho, cập nhật lại số lượng bằng tồn kho
        if ($cart->quantity > $variant->stock) {
            $cart->quantity = $variant->stock;
        }

        // Cập nhật biến thể sản phẩm
        $cart->product_variant_id = $variant->id;
        $cart->save();

        return back()->with('success', 'Cập nhật phân loại thành công!');
    }





}
