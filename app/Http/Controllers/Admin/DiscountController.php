<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $query = Discount::query();
        if (!empty($data['name'])) {
            $query->where('code', 'like', '%' . $data['name'] . '%');
        }

        $discounts = $query->orderBy('id', 'desc')
            ->paginate($data['size'] ?? 20);
        return view('admin.pages.discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.pages.discounts.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiscountRequest $request)
    {
        $data = $request->all();
        Discount::create($data);
        return redirect()->route('discounts.index')->with('success', "Tạo mã giảm giá thành công");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $isEdit = false;
        $discount = Discount::findOrFail($id);
        return view('admin.pages.discounts.edit', compact('discount', 'isEdit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $isEdit = true;
        $discount = Discount::findOrFail($id);
        return view('admin.pages.discounts.edit', compact('discount', 'isEdit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiscountRequest $request, string $id)
    {
        $data = $request->all();
        $discount = Discount::findOrFail($id);
        $discount->update($data);
        return redirect()->route('discounts.index')->with('success', "Cập nhật mã giảm giá thành công");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        return response()->json(['success' => true]);
    }
}
