<?php

namespace App\Http\Controllers\Admin;

use App\Models\Images;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Illuminate\Validation\Rule;
use App\Models\VariantAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:products_list')->only(['index']);
        $this->middleware('permission:products_create')->only(['create', 'store']);
        $this->middleware('permission:products_detail')->only(['show']);
        $this->middleware('permission:products_update')->only(['edit', 'update']);
        $this->middleware('permission:products_delete')->only(['destroy']);
    }
    // public function index(){
    //     // Lấy sản phẩm với các biến thể và ảnh
    //     $products = Product::with('images', 'variants')->latest()->get();
    //     return view('admin.pages.product.index', compact('products'));
    // }
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->id) {
            $query->where('id', $request->id);
        }

        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->is_active != '') {
            $query->where('is_active', $request->is_active);
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->min_quantity) {
            $query->where('total_quantity', '>=', $request->min_quantity);
        }

        if ($request->max_quantity) {
            $query->where('total_quantity', '<=', $request->max_quantity);
        }

        $products = $query->with('images', 'variants')->latest()->paginate(10);
        $categories = Category::all();

        return view('admin.pages.product.index', compact('products', 'categories'));
    }




    public function create(){
        $categories = Category::all();
        return view('admin.pages.product.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $dataProduct=$request->all();
        $productName = $dataProduct['product_name'] ?? 'Sản phẩm chưa có tên';

        // Tạo sản phẩm
        $product = Product::create([
            'name' => $productName, // Lấy tên từ dữ liệu đầu vào
            'category_id' => $dataProduct['category_id'], // Nếu không có thì mặc định là 1
            'description' => $dataProduct['description'] ?? '', // Nếu không có thì mặc định rỗng
            'short_description' => $dataProduct['short_description'] ?? '', // Thêm mô tả ngắn
            'price' => $dataProduct['product_price'] ?? 0, // Nếu không có thì mặc định 0
            'view' => 0, // Mặc định là 0 thay vì 1
        ]);

        // Nếu có ảnh tải lên
        if ($request->hasFile('product_image')) {
            // Lưu ảnh vào thư mục 'products' trong storage
            $imagePath = $request->file('product_image')->store('products', 'public');
            Images::create([
                'product_id' => $product->id,
                'url' => $imagePath
            ]);
        }

        // // Xử lý biến thể nếu là "variable"
        if ($dataProduct['product_type'] === 'variable' && isset($dataProduct['variants'])) {
            foreach ($dataProduct['variants'] as $variant) {
                // Lưu attributes và attribute_values trước
                $attributeValues = [];
                if (!empty($variant['attributes'])) {
                    foreach ($variant['attributes'] as $attributeName => $value) {
                        // Lưu attribute vào bảng `attributes`
                        $attribute = Attribute::firstOrCreate(['name' => $attributeName]);

                        // Lưu giá trị của attribute vào bảng `attribute_values`
                        $attributeValue = AttributeValue::firstOrCreate([
                            'attributes_id' => $attribute->id, // Đảm bảo dùng `attribute_id`
                            'value' => $value
                        ]);

                        $attributeValues[] = $attributeValue->id;
                    }
                }

                // Kiểm tra nếu có pricing (giá & tồn kho)
                if (!empty($variant['pricing'])) {
                    // Lưu variant
                    $productVariant = ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => $product->id, // Tạm thời đặt SKU, sẽ cập nhật sau
                        'price' => $variant['pricing']['price'],
                        'stock' => $variant['pricing']['stock'],
                    ]);

                    // Cập nhật lại SKU với ID của biến thể vừa tạo
                    $productVariant->update([
                        'sku' => $product->id . '-' . $productVariant->id
                    ]);

                    // 🔹 Lưu vào bảng `variant_attributes`
                    foreach ($attributeValues as $attributeValueId) {
                        $variantAttributes=VariantAttribute::create([
                            'product_variant_id' => $productVariant->id,
                            'attribute_value_id' => $attributeValueId
                        ]);
                    }

                    if ($request->has('variants')) {

                            if (isset($variant['pricing']['image']) && $variant['pricing']['image'] instanceof \Illuminate\Http\UploadedFile) {
                                // Lưu ảnh vào thư mục storage/app/public/products
                                $imagePath = $variant['pricing']['image']->store('products', 'public');

                                // Lưu đường dẫn vào database
                                Images::create([
                                    'product_id' => $product->id,
                                    'product_variant_id' => $productVariant->id,
                                    'url' => $imagePath
                                ]);
                            }
                    }

                }
            }
        }


        return redirect()->back()->with('success', 'Sản phẩm đã được tạo thành công.');
    }

    public function edit($id)
    {
        // Lấy thông tin sản phẩm cùng với hình ảnh và danh mục
        $product = Product::with('images', 'category')->findOrFail($id);
        // Lấy danh sách tất cả danh mục và thương hiệu
        $categories = Category::all();
        // $brands = Brand::all();

        return view('admin.pages.product.edit', compact('product', 'categories'));
    }
    public function update(Request $request, $id)
    {
        // Validate input data
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'product_image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the product by ID
        $product = Product::findOrFail($id);

        // Update product details
        $product->name = $request->input('product_name');
        $product->short_description = $request->input('short_description');
        $product->description = $request->input('description');

        $product->category_id = $request->input('category_id');
        $product->save();

        // Handle image upload if present
        if ($request->hasFile('product_image')) {
            foreach ($request->file('product_image') as $index => $image) {
                // Store the image
                $path = $image->store('products', 'public');

                // Update existing image or create new one
                $productImage = $product->images()->skip($index)->first();
                if ($productImage) {
                    // Delete old image
                    Storage::disk('public')->delete($productImage->url);
                    // Update with new image
                    $productImage->update(['url' => $path]);
                } else {
                    // Create new image record
                    $product->images()->create(['url' => $path]);
                }
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }


    public function delete($id)
    {
        $product = Product::findOrFail($id); // Tìm sản phẩm theo ID
        $product->is_active = 0; // Cập nhật trạng thái is_active thành 0
        $product->save(); // Lưu thay đổi

        return redirect()->route('admin.product.index')->with('success', 'Sản phẩm đã được tắt thành công!');
    }
    public function toggleStatus(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = $request->is_active;
        $product->save();

        return response()->json(['success' => true]);
    }


}
