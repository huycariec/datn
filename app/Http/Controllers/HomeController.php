<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Order;
use App\Models\Banner;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $discountProducts = Product::where('is_active', 1)
        ->where('price_old', '>', 0) // Chỉ lấy sp có price_old > 0
        ->orderByDesc('price_old')
        ->limit(8)
        ->get();
    
    

        $banners = Banner::orderBy('position')
            ->get()
            ->keyBy('position');

        $wishlistItems = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();

        $newProducts = Product::where('is_active', 1)
        ->orderBy('created_at', 'desc')
        ->take(8)
        ->get();

        return view('client.home', compact('categories', 'discountProducts', 'wishlistItems', 'banners','newProducts'));
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

    public function updateStatusOrder(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required|exists:orders,id',
                'status' => 'required|in:' . implode(',', array_column(OrderStatus::cases(), 'value'))
            ]);

            $order = Order::findOrFail($request->order_id);

            $allowedTransitions = [
                OrderStatus::PENDING_CONFIRMATION->value => [OrderStatus::CANCELLED->value],
                OrderStatus::CONFIRMED->value => [OrderStatus::CANCELLED->value],
                OrderStatus::PREPARING->value => [OrderStatus::CANCELLED->value],
                OrderStatus::PREPARED->value => [OrderStatus::CANCELLED->value],
                OrderStatus::RECEIVED->value => [OrderStatus::RETURNED->value],
                OrderStatus::DELIVERED->value => [
                    OrderStatus::RECEIVED->value,
                    OrderStatus::NOT_RECEIVED->value
                ]
            ];

            if (!in_array($request->status, $allowedTransitions[$order->status->value] ?? [])) {
                return redirect()->back()->with('error', 'Không thể chuyển sang trạng thái này');
            }

            $order->status = $request->status;
            $order->save();

            return redirect()->back()->with('success', 'Cập nhật trạng thái thành công');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function addReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|between:1,5',
            'content' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
        ]);
        $data = $request->all();

        $order = Order::findOrFail($request->order_id);

        if ($order->user_id !== auth()->id() ||
            !in_array($order->status, [\App\Enums\OrderStatus::RECEIVED, \App\Enums\OrderStatus::RETURNED])) {
            return redirect()->back()->with('error', 'Bạn không có quyền đánh giá sản phẩm này.');
        }

        $existingReview = Review::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->where('product_variant_id', $request->product_variant_id)
            ->exists();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('reviews', 'public');
        }
        $data['user_id'] = auth()->id();
        $data['product_variant_id'] = $request->product_variant_id ?? 0;

        Review::create($data);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi thành công!');
    }

    public function error()
    {
        return view('client.error');
    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $sort = $request->input('sort');
    
        $products = Product::query()
            ->where('is_active', 1)  // Chỉ lấy sản phẩm đang active
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%')
                      ->orWhere('short_description', 'like', '%' . $keyword . '%')
                      ->orWhere('price', 'like', '%' . $keyword . '%')
                      ->orWhereHas('category', function ($q2) use ($keyword) {
                          $q2->where('name', 'like', '%' . $keyword . '%');
                      });
                });
            });
    
        if ($sort == 'asc') {
            $products->orderBy('price', 'asc');
        } elseif ($sort == 'desc') {
            $products->orderBy('price', 'desc');
        }
    
        $products = $products->paginate(12);
    
        return view('client.page.search', compact('products', 'keyword', 'sort'));
    }
    
    


}
