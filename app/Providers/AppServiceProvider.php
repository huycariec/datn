<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $categories = Category::select('id', 'name', 'image')->get();
            $view->with('categoriesView', $categories);
        });
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
        View::composer('client.inc.header', function ($view) {
            $userId = Auth::id();
    
            $cartItems = collect(); // Khởi tạo danh sách trống mặc định
            $cartQuantity = 0;
    
            if ($userId) {
                $cartItems = Cart::with([
                    'product.images',  // Lấy ảnh của sản phẩm
                    'variant.images'   // Lấy ảnh của biến thể
                ])
                ->where('user_id', $userId)
                ->get()
                ->map(function ($cart) {
                    return [
                        'quantity' => $cart->quantity,
                        'product_name' => optional($cart->product)->name ?? 'Sản phẩm không tồn tại',
                        'variant_price' => optional($cart->variant)->price ?? 0,
                        'variant_id' => optional($cart->variant)->id, // ID của biến thể
                        'product_image' => optional($cart->variant->images->first())->url ??
                                           optional($cart->product->images->first())->url ?? 'default-image.jpg'
                    ];
                });
    
                $cartQuantity = $cartItems->sum('quantity');
            }
    
            $view->with([
                'cart_items' => $cartItems,
                'cart_quantity' => $cartQuantity
            ]);
        });
    }
}
