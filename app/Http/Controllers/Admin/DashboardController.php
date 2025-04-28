<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dashboard')->only(['index']);
    }

    public function index()
    {
        // Tổng doanh thu (không tính đơn hàng đã hủy)
        $totalRevenue = Order::whereNotIn('status', ['cancelled', 'pending_cancellation'])
            ->sum('total_amount');

        // Tăng trưởng doanh thu so với tháng trước
        $currentMonthRevenue = Order::whereNotIn('status', ['cancelled', 'pending_cancellation'])
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');

        $lastMonthRevenue = Order::whereNotIn('status', ['cancelled', 'pending_cancellation'])
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('total_amount');

        $revenueGrowth = $lastMonthRevenue > 0 
            ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;

        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::where('role', 'user')->count();

        $averageRating = Review::avg('rating') ?? 0;

        // Filter cho các biểu đồ
        $months = (int)request('months', 6);
        $months_category = (int)request('months_category', 6);
        $months_user = (int)request('months_user', 6);
        $now = Carbon::now();

        $labels = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $labels[] = $now->copy()->subMonths($i)->format('m/Y');
        }
        $rawRevenue = Order::whereNotIn('status', ['cancelled', 'pending_cancellation'])
            ->where('created_at', '>=', $now->copy()->subMonths($months)->startOfMonth())
            ->select(
                DB::raw("CONCAT(LPAD(MONTH(created_at),2,'0'),'/',YEAR(created_at)) as month"),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('revenue', 'month')
            ->toArray();
        $monthlyRevenue = collect($labels)->map(function($month) use ($rawRevenue) {
            return [
                'month' => $month,
                'revenue' => isset($rawRevenue[$month]) ? (float)$rawRevenue[$month] : 0,
            ];
        });

        $startDate = $now->copy()->subMonths($months_category)->startOfMonth();

        $topCategories = Category::select('categories.id', 'categories.name', DB::raw('COALESCE(SUM(orders.total_amount),0) as revenue'))
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->leftJoin('order_details', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('orders', 'order_details.order_id', '=', 'orders.id')
            ->where(function($q) use ($startDate) {
                $q->whereNull('orders.created_at')
                ->orWhere('orders.created_at', '>=', $startDate);
            })
            ->where(function($q) {
                $q->whereNull('orders.status')
                ->orWhereNotIn('orders.status', ['cancelled', 'pending_cancellation']);
            })
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->orderByDesc('categories.id')
            ->limit(10)
            ->get();

        $categoryLabels = $topCategories->pluck('name');
        $categoryRevenue = $topCategories->pluck('revenue')->map(fn($v) => (float)$v);
        // 3. Người dùng mới theo tháng (luôn đủ 6/12 cột)
        $labels_user = [];
        for ($i = $months_user - 1; $i >= 0; $i--) {
            $labels_user[] = $now->copy()->subMonths($i)->format('m/Y');
        }
        $rawNewUsers = User::where('role', 'user')
            ->where('created_at', '>=', $now->copy()->subMonths($months_user)->startOfMonth())
            ->select(
                DB::raw("CONCAT(LPAD(MONTH(created_at),2,'0'),'/',YEAR(created_at)) as month"),
                DB::raw('count(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        $newUsers = collect($labels_user)->map(function($month) use ($rawNewUsers) {
            return [
                'month' => $month,
                'count' => isset($rawNewUsers[$month]) ? (int)$rawNewUsers[$month] : 0,
            ];
        });

        // Các phần còn lại giữ nguyên
        $topProducts = Product::select(
            'products.name',
            DB::raw('SUM(order_details.quantity) as total_quantity'),
            DB::raw('SUM(order_details.unit_price * order_details.quantity) as revenue')
        )
        ->join('order_details', 'products.id', '=', 'order_details.product_id')
        ->join('orders', 'order_details.order_id', '=', 'orders.id')
        ->whereNotIn('orders.status', ['cancelled', 'pending_cancellation'])
        ->groupBy('products.id', 'products.name')
        ->orderByDesc('total_quantity')
        ->limit(5)
        ->get()
        ->map(function($item) {
            return (object)[
                'name' => $item->name,
                'total_quantity' => (int)$item->total_quantity,
                'revenue' => (float)$item->revenue,
            ];
        });

        $highRatedProducts = Product::select('products.name', DB::raw('AVG(reviews.rating) as avg_rating'))
            ->join('reviews', 'products.id', '=', 'reviews.product_id')
            ->groupBy('products.id', 'products.name')
            ->having('avg_rating', '>=', 4)
            ->orderByDesc('avg_rating')
            ->limit(5)
            ->get()
            ->map(function($item) {
                return (object)[
                    'name' => $item->name,
                    'avg_rating' => (float)$item->avg_rating,
                ];
            });

        $orderStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->map(function($item) {
                return [
                    'status' => $item->status,
                    'count' => (int)$item->count,
                ];
            });

        $recentOrders = Order::with(['user', 'orderDetails.product'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.pages.dashboard', [
            'totalRevenue' => $totalRevenue,
            'revenueGrowth' => $revenueGrowth,
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalUsers' => $totalUsers,
            'averageRating' => $averageRating,
            'monthlyRevenue' => $monthlyRevenue,
            'categoryLabels' => $categoryLabels,
            'categoryRevenue' => $categoryRevenue,
            'topProducts' => $topProducts,
            'highRatedProducts' => $highRatedProducts,
            'orderStatus' => $orderStatus,
            'newUsers' => $newUsers,
            'recentOrders' => $recentOrders,
        ]);
    }

    public function aiSuggest(Request $request)
    {
        $question = $request->input('question');
        if ($question === null) {
            // Nếu không có dữ liệu gửi lên (không nên xảy ra), trả về lỗi
            return response()->json(['suggest' => 'Vui lòng nhập câu hỏi cho AI!'], 400);
        }
        // Nếu rỗng thì dùng prompt mặc định
        if (trim($question) === '') {
            $topProducts = Product::select('name', DB::raw('SUM(order_details.quantity) as total_quantity'))
                ->join('order_details', 'products.id', '=', 'order_details.product_id')
                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                ->whereNotIn('orders.status', ['cancelled', 'pending_cancellation'])
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_quantity')
                ->limit(10)
                ->get();
            $prompt = "Dưới đây là danh sách 10 sản phẩm bán chạy nhất của shop trong 6 tháng gần nhất:\n";
            foreach ($topProducts as $p) {
                $prompt .= "- {$p->name}: {$p->total_quantity} lượt bán\n";
            }
            $prompt .= "\nHãy gợi ý cho admin 3 cách thực tế để tăng doanh số bán hàng cho các sản phẩm này (ngắn gọn, dễ hiểu, ưu tiên hành động cụ thể).";
        } else {
            $prompt = $question;
        }

        try {
            $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5',
                'input' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 300,
            ]);
            // dd($response);
            if ($response->status() == 429) {
                return response()->json(['suggest' => 'Bạn đang gửi quá nhiều yêu cầu tới AI. Vui lòng thử lại sau ít phút.'], 429);
            }
            $suggest = $response['choices'][0]['message']['content'] ?? 'Không nhận được gợi ý từ AI.';
            return response()->json(['suggest' => $suggest]);
        } catch (\Exception $e) {
            return response()->json(['suggest' => 'Có lỗi khi kết nối tới AI: ' . $e->getMessage()], 500);
        }
    }
}
