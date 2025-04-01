<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
