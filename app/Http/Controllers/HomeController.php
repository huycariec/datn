<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::where('is_active', 1)->get();
        $banners = Banner::orderBy('position')
            ->get()
            ->keyBy('position');

        $wishlistItems = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();

        return view('client.home', compact('categories', 'products', 'wishlistItems', 'banners'));
    }

    public function productsByCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $products = Product::where('category_id', $categoryId)->where('is_active', 1)->get();

        return view('client.page.products_by_category', compact('category', 'products'));
    }

    public function showProductDetail($id)
    {
        $product = Product::findOrFail($id);

        return view('client.page.detail', compact('product'));
    }

    public function addToWishlist($productId)
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để sử dụng Wishlist!');
        }

        if (Wishlist::where('user_id', $userId)->where('product_id', $productId)->exists()) {
            return back()->with('warning', 'Sản phẩm đã có trong danh sách yêu thích!');
        }

        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        return back()->with('success', 'Đã thêm vào danh sách yêu thích!');
    }

    public function removeFromWishlist($productId)
    {
        $userId = Auth::id();
        $wishlistItem = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return back()->with('success', 'Sản phẩm đã được xóa khỏi danh sách yêu thích!');
        }

        return back()->with('error', 'Sản phẩm không tồn tại trong danh sách yêu thích!');
    }

    public function wishlist()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->with('product')->get();
        return view('client.page.wishlist', compact('wishlist'));
    }

    public function PolicyBuy()
    {
        $data = Page::where('type', 'policy_buy')->first();
        return view('client.page.policy_buy', compact('data'));
    }
    public function PolicyReturn()
    {
        $data = Page::where('type', 'policy_return')->first();
        return view('client.page.policy_return', compact('data'));
    }
    public function Instruct()
    {
        $data = Page::where('type', 'instruct')->first();
        return view('client.page.instruct', compact('data'));
    }
    public function Introduction()
    {
        $data = Page::where('type', 'introduction')->first();
        return view('client.page.introduction', compact('data'));
    }
}
