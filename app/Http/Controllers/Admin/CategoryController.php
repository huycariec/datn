<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
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

    $data = [
        'name' => $request->name,
        'description' => $request->description, // Lưu mô tả
    ];

    // Kiểm tra nếu có file ảnh
    if ($request->hasFile('image')) {
        // Lưu ảnh vào storage/public/categories/
        $imagePath = $request->file('image')->store('categories', 'public');
        $data['image'] = $imagePath; // Lưu đường dẫn vào database
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

    $category = Category::findOrFail($id);

    $data = [
        'name' => $request->name,
        'description' => $request->description,
    ];

    // Nếu có file ảnh mới, xóa ảnh cũ và lưu ảnh mới
    if ($request->hasFile('image')) {
        // Xóa ảnh cũ nếu có
        if ($category->image) {
            \Storage::disk('public')->delete($category->image);
        }

        // Lưu ảnh mới vào thư mục storage/public/categories/
        $imagePath = $request->file('image')->store('categories', 'public');
        $data['image'] = $imagePath;
    }

    // Cập nhật danh mục
    $category->update($data);

    return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        // $hash = Product::where('category_id', $id)->exists();
        // if (!$hash) {
        $category->delete();
        $catefories = Category::all();
        foreach ($catefories as $x) {
            if ($x->parent_id == $id) {
                $x->delete();
            }
        }
        return redirect()->route('categories.index')->with('success', 'Xoá danh mục thành công !');

        // }else{
        //     return redirect()->route('admin.categories.index')->with('error', 'Vui lòng chuyển các sản phẩm sang danh mục khác để tiền hành xoá danh mục này.');

        // }
    }
}
