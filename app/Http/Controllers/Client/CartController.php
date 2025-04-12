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
        $request->validate([
            'sku'      => 'required|exists:product_variants,sku',
            'quantity' => 'required|integer|min:1',
        ], [
            'sku.required'      => 'Thiếu thông tin SKU!',
            'sku.exists'        => 'Sản phẩm không tồn tại!',
            'quantity.required' => 'Vui lòng nhập số lượng!',
            'quantity.integer'  => 'Số lượng phải là số!',
            'quantity.min'      => 'Số lượng phải lớn hơn 0!',
        ]);

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

        $stock = $productVariant->stock; // Số lượng tồn kho hiện tại

        if ($cartItem) {
        $newQuantity = $cartItem->quantity + $quantity;

        if ($newQuantity > $stock) {
        // Nếu cộng vào vượt quá kho
        $cartItem->update(['quantity' => $stock]);

        return redirect()->back()->with('error', 'Số lượng sản phẩm trong giỏ hàng đã được điều chỉnh bằng số lượng tồn kho!');
        } else {
        // Cộng dồn bình thường
        $cartItem->update(['quantity' => $newQuantity]);
        }
        } else {
        // Thêm mới
        $addQuantity = $quantity > $stock ? $stock : $quantity;

        if ($quantity > $stock) {
        $message = 'Số lượng bạn chọn vượt quá kho, sản phẩm được thêm với số lượng tối đa hiện có!';
        } else {
        $message = 'Sản phẩm đã được thêm vào giỏ hàng!';
        }

        Cart::create([
        'user_id' => $userId,
        'product_id' => $productId,
        'product_variant_id' => $variantId,
        'quantity' => $addQuantity,
        ]);

        return redirect()->back()->with('success', $message);
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
    
            // Thuộc tính đã chọn của variant hiện tại
            $selectedAttributes = $variant->variantAttributes->mapWithKeys(function ($variantAttribute) {
                return [
                    optional($variantAttribute->attributeValue->attribute)->name => optional($variantAttribute->attributeValue)->value
                ];
            })->toArray();
    
            // Lấy tất cả thuộc tính + stock của từng variant
            $allAttributes = $product->variants->mapWithKeys(function ($variant) {
                $variantKey = $variant->product_id . '-' . $variant->id;
    
                $attributes = $variant->variantAttributes->mapWithKeys(function ($variantAttribute) {
                    return [
                        optional($variantAttribute->attributeValue->attribute)->name => optional($variantAttribute->attributeValue)->value
                    ];
                })->toArray();
    
                return [
                    $variantKey => array_merge($attributes, [
                        'stock' => $variant->stock
                    ])
                ];
            })->toArray();
    
            return [
                'cart_id' => $cart->id,
                'quantity' => $cart->quantity,
                'stock' => optional($variant)->stock,
                'variant_sku'=>optional($variant)->sku,
                'product_name' => optional($product)->name ?? 'Sản phẩm không tồn tại',
                'variant_price' => number_format(optional($variant)->price ?? 0, 2, '.', ''),
                'product_image' => optional($variant->images->first())->url
                                    ?? optional($product->images->first())->url
                                    ?? null,
                'selected_attributes' => $selectedAttributes,
                'all_attributes' => $allAttributes,
                'is_product_active' => optional($product)->is_active == 1,
                'is_variant_active' => optional($variant)->is_active == 1,
                
            ];
        })->values()->toArray();
        // dd($cartItems);
    
        $cartSkus = collect($cartItems)->pluck('variant_sku')->toArray();

        return view('client.page.cart.index', compact('cartItems','cartSkus'));
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
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'sku' => 'required|exists:product_variants,sku',
        ]);
    
        $variant = ProductVariant::where('sku', $request->sku)->first();
        $cart = Cart::find($request->cart_id);
    
        if (!$variant) {
            return back()->with('error', 'Biến thể sản phẩm không tồn tại!');
        }
    
        if ($variant->stock <= 0) {
            return back()->with('error', 'Sản phẩm đã hết hàng!');
        }
    
        $message = 'Cập nhật phân loại thành công!';
    
        // Số lượng tối thiểu là 1
        if ($cart->quantity < 1) {
            $cart->quantity = 1;
            $message .= ' Số lượng tối thiểu là 1.';
        }
    
        // Số lượng tối đa là tồn kho
        if ($cart->quantity > $variant->stock) {
            $cart->quantity = $variant->stock;
            $message .= ' Số lượng đã được điều chỉnh về tối đa trong kho (' . $variant->stock . ').';
        }
    
        $cart->product_variant_id = $variant->id;
        $cart->save();
    
        return back()->with('success', $message);
    }
    
    





}
