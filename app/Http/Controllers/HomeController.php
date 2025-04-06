<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Order;
use App\Models\Page;
use App\Models\ProductVariant;
use App\Models\Review;
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
        $product = Product::with([
            'variants.variantAttributes.attributeValue.attribute'
        ])->find($id);

        $attributesGrouped = [];
        foreach ($product->variants as $variant) {
            foreach ($variant->variantAttributes as $variantAttribute) {
                if (
                    isset($variantAttribute->attributeValue) &&
                    isset($variantAttribute->attributeValue->attribute)
                ) {
                    $attributeId   = $variantAttribute->attributeValue->attribute->id;  // Lấy ID của attribute
                    $attributeName = $variantAttribute->attributeValue->attribute->name; // Lấy tên attribute
                    $attributeValue = $variantAttribute->attributeValue->value; // Lấy giá trị attribute

                    // Khởi tạo mảng nếu chưa có key
                    if (!isset($attributesGrouped[$attributeName])) {
                        $attributesGrouped[$attributeName] = [];
                    }

                    // Tránh trùng lặp bằng cách kiểm tra theo ID
                    $exists = false;
                    foreach ($attributesGrouped[$attributeName] as $attr) {
                        if ($attr['id'] == $attributeId && $attr['value'] == $attributeValue) {
                            $exists = true;
                            break;
                        }
                    }

                    // Nếu chưa tồn tại, thêm vào mảng
                    if (!$exists) {
                        $attributesGrouped[$attributeName][] = [
                            'id'    => $attributeId,
                            'value' => $attributeValue
                        ];
                    }
                }
            }
        }
        $result = [];
        foreach ($product->variants->where('stock', '>', 0)->where('is_active', 1) as $variant) { // chỉ lấy variant có stock > 0
            $sku = $variant->sku;
            $variantData = [
                'product_variant' => $variant,
                'attributes' => []
            ];

            foreach ($variant->variantAttributes as $variantAttribute) {
                $variantData['attributes'][] = [
                    'attributes_id' => $variantAttribute->attributeValue->attributes_id ?? null,
                    'value' => $variantAttribute->attributeValue->value ?? null
                ];
            }

            $result[$sku] = $variantData;
        }

        // dd($result);

         // Chuyển `$result` thành JSON rồi gửi qua view
        $resultJson = json_encode($result, JSON_PRETTY_PRINT);

        $reviews = Review::where('product_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        $variants = ProductVariant::where('product_id', $id)->get();

        $averageRating = $reviews->avg('rating');

        $ratingStats = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];

        $totalReviews = $reviews->count();

        return view('client.page.detail', compact('product', 'attributesGrouped', 'resultJson', 'reviews', 'averageRating', 'ratingStats', 'totalReviews', 'variants'));
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

    public function order()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['payment', 'userAddress'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.order', compact('orders'));
    }

    public function orderDetail(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['orderDetails', 'payment', 'userAddress', 'discounts'])
            ->firstOrFail();

        return view('client.order_detail', compact('order'));
    }

    public function error()
    {
        return view('client.error');
    }

}
