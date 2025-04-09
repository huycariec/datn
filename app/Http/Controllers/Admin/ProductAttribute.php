<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductAttribute extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:attributes_create')->only(['index']);
        $this->middleware('permission:attributes_create')->only(['create', 'store']);
        $this->middleware('permission:attributes_detail')->only(['show']);
        $this->middleware('permission:attributes_update')->only(['edit', 'update']);
        $this->middleware('permission:attributes_delete')->only(['destroy']);
    }
    public function index(){
        $attributes = Session::get('attribute');

        return view('admin.pages.attribute.index',compact('attributes'));
    }

    public function create(){
        // Session::flush();
        return view('admin.pages.attribute.create');


    }

    public function store(Request $request)
    {
        $attribute_name = request('attribute_name');
        $attribute_values = explode('|', request('attribute_value'));
        $attribute_values = array_map('trim', $attribute_values);

        // Lấy danh sách thuộc tính trong session (nếu chưa có thì tạo mảng rỗng)
        $attributes = Session::get('attribute', []);

        // Kiểm tra nếu thuộc tính đã tồn tại trong session
        if (isset($attributes[$attribute_name])) {
            return redirect()->back()->with('message', 'Thuộc tính đã tồn tại.');
        }

        // Nếu chưa tồn tại, thêm mới vào session
        $attributes[$attribute_name] = $attribute_values;

        // Cập nhật lại session
        Session::put('attribute', $attributes);
        session()->save();

        return redirect()->back()->with('message', 'Thuộc tính đã được thêm mới!');
    }

    public function destroy($key)
    {
        // Lấy danh sách thuộc tính từ session
        $attributes = session('attribute', []);

        // Kiểm tra nếu tồn tại key trong session
        if (!array_key_exists($key, $attributes)) {
            return redirect()->back()->with('error', 'Không tìm thấy thuộc tính!');
        }

        // Xóa thuộc tính khỏi session
        unset($attributes[$key]);
        session(['attribute' => $attributes]);

        return redirect()->back()->with('message', 'Thuộc tính đã được xóa!');
    }
    public function edit($id)
    {
        $attributes = session('attribute', []); // Lấy toàn bộ session hoặc mảng rỗng
        $attributeEdit = $attributes[$id] ?? null; // Kiểm tra nếu tồn tại ID
        $attribute_name = $id;
        return view('admin.pages.attribute.edit', compact('attributeEdit', 'attribute_name'));
    }


}
