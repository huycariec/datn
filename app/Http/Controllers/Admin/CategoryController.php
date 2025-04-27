<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:categories_list')->only(['index']);
        $this->middleware('permission:categories_create')->only(['create', 'store']);
        $this->middleware('permission:categories_detail')->only(['show']);
        $this->middleware('permission:categories_update')->only(['edit', 'update']);
        $this->middleware('permission:categories_delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sort_by') && in_array($request->sort_by, ['asc', 'desc'])) {
            $query->orderBy('name', $request->sort_by);
        }

        $categories = $query->paginate(10);

        return view('admin.pages.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.pages.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:1000',
        ]);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Tạo danh mục mới thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('admin.categories.index')->with('error', 'Category not found');
        }
        $categories = Category::all();
        return view('admin.pages.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:1000',
        ]);
        $data = $request->all();

        $category = Category::findOrFail($id);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
            if ($category->image && file_exists(storage_path('app/public/' . $category->image))) {
                Storage::delete('public/' . $category->image);
            }
        }
        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Cập nhập danh mục thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Vui lòng chuyển các sản phẩm sang danh mục khác để tiền hành xoá danh mục này.');
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Xoá danh mục thành công !');
    }
}
