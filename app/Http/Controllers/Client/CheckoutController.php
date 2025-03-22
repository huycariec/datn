<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;

class CheckoutController extends Controller
{

    
    public function index(Request $request)
    {
        $cartIds = $request->input('cart_id');      // Mảng cart_id gửi lên
        $quantities = $request->input('quantity');  // Mảng quantity tương ứng
    
        // Kiểm tra dữ liệu hợp lệ
        if (is_array($cartIds) && is_array($quantities) && count($cartIds) === count($quantities)) {
            foreach ($cartIds as $index => $cartId) {
                $quantity = (int) $quantities[$index];
    
                // Chỉ update nếu quantity hợp lệ
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
                    'variant.product', // Nếu muốn lấy luôn product qua variant
                    'variant.images'

                ])
                ->where('id', $cartId)
                ->first();
        
            if ($cartItem) {
                $cartItems[] = $cartItem;
            }
        }
        

        // dd($cartItems);


        return view('client.page.checkout.index',compact('cartItems'));
    } 
}
