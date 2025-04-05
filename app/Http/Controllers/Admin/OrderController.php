<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->all();

        $query = Order::query();

        if (!empty($data['status']) && in_array($data['status'], array_column(\App\Enums\OrderStatus::cases(), 'value'))) {
            $query->where('status', $data['status']);
        }

        if (!empty($data['payment_method'])) {
            $query->where('payment_method', $data['payment_method']);
        }

        if (!empty($data['name'])) {
            $query->whereHas('user', function ($q) use ($data) {
                $q->where('name', 'LIKE', '%' . $data['name'] . '%');
            });
        }

        if (!empty($data['min_amount']) && !empty($data['max_amount']) &&
            is_numeric($data['min_amount']) && is_numeric($data['max_amount']) &&
            $data['min_amount'] >= 0 && $data['max_amount'] >= $data['min_amount']) {
            $query->whereBetween('total_amount', [
                (float) $data['min_amount'],
                (float) $data['max_amount']
            ]);
        } elseif (!empty($data['min_amount']) && is_numeric($data['min_amount']) && $data['min_amount'] >= 0) {
            $query->where('total_amount', '>=', (float) $data['min_amount']);
        } elseif (!empty($data['max_amount']) && is_numeric($data['max_amount']) && $data['max_amount'] >= 0) {
            $query->where('total_amount', '<=', (float) $data['max_amount']);
        }

        $orders = $query->paginate($data['size'] ?? 20);

        return view('admin.pages.orders.index', compact('orders', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            if (!$order) {
                return view('admin.pages.orders.list')->with('error', 'Đơn hàng không tồn tại !');
            }
            return view('admin.pages.orders.show', compact('order'));
        } catch (\Exception $exception) {
            return view('admin.pages.orders.list')->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng không tồn tại'
            ], 404);
        }

        $request->validate([
            'status' => [
                'required',
                Rule::in(array_column(OrderStatus::toArray(), 'value')),
            ],
        ], [
            'status.required' => 'Trạng thái không được để trống',
            'status.in' => 'Trạng thái không hợp lệ',
        ]);

        $statusTransitions = [
            'pending_confirmation' => ['pending_confirmation', 'confirmed', 'cancelled'],
            'confirmed' => ['confirmed', 'preparing', 'cancelled'],
            'preparing' => ['preparing', 'prepared', 'cancelled'],
            'prepared' => ['prepared', 'picked_up'],
            'picked_up' => ['picked_up', 'in_transit'],
            'in_transit' => ['in_transit', 'delivered'],
            'delivered' => ['delivered'],
            'received' => ['received'],
            'returned' => ['returned', 'refunded'],
            'cancelled' => [],
            'refunded' => []
        ];

        $currentStatus = $order->status->value;
        $newStatus = $request->input('status');

        if (!in_array($newStatus, $statusTransitions[$currentStatus] ?? [])) {
            return response()->json([
                'success' => false,
                'message' => "Không thể chuyển từ trạng thái '$currentStatus' sang '$newStatus'"
            ], 400);
        }

        $order->update(['status' => $newStatus]);

        session()->flash('success', 'Cập nhật trạng thái đơn hàng thành công');

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái đơn hàng thành công',
            'data' => [
                'order_id' => $order->id,
                'new_status' => $newStatus,
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
