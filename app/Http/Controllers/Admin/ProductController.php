<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\Images;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\OrderDetail;
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
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'product_price' => 'nullable|numeric|min:0',
            'product_price_old' => 'nullable|numeric|min:0',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'product_type' => 'required|in:simple,variable',
            'variants' => 'required_if:product_type,variable|array',
            'variants.*.attributes' => 'required_if:product_type,variable|array',
            'variants.*.attributes.*' => 'required|string|max:255',
            'variants.*.pricing.price' => 'required_if:product_type,variable|numeric|min:0',
            'variants.*.pricing.stock' => 'required_if:product_type,variable|integer|min:0',
            'variants.*.pricing.image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'product_name.required' => 'Tên sản phẩm là bắt buộc.',
            'product_name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục đã chọn không tồn tại.',
            'description.string' => 'Mô tả phải là một chuỗi.',
            'short_description.string' => 'Mô tả ngắn phải là một chuỗi.',
            'short_description.max' => 'Mô tả ngắn không được vượt quá 500 ký tự.',
            'product_price.numeric' => 'Giá sản phẩm phải là một số.',
            'product_price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
            'product_price_old.numeric' => 'Giá gốc phải là một số.',
            'product_price_old.min' => 'Giá gốc phải lớn hơn hoặc bằng 0.',
            'product_image.image' => 'Ảnh sản phẩm phải là một tệp hình ảnh.',
            'product_image.mimes' => 'Ảnh sản phẩm phải có định dạng jpg, jpeg, png.',
            'product_image.max' => 'Ảnh sản phẩm không được lớn hơn 2MB.',
            'product_type.required' => 'Vui lòng chọn loại sản phẩm.',
            'product_type.in' => 'Loại sản phẩm không hợp lệ.',
            'variants.required_if' => 'Vui lòng thêm ít nhất một biến thể cho sản phẩm.',
            'variants.*.attributes.required_if' => 'Thuộc tính của biến thể là bắt buộc.',
            'variants.*.attributes.*.required' => 'Giá trị thuộc tính là bắt buộc.',
            'variants.*.attributes.*.max' => 'Giá trị thuộc tính không được vượt quá 255 ký tự.',
            'variants.*.pricing.price.required_if' => 'Giá của biến thể là bắt buộc.',
            'variants.*.pricing.price.numeric' => 'Giá của biến thể phải là một số.',
            'variants.*.pricing.price.min' => 'Giá của biến thể phải lớn hơn hoặc bằng 0.',
            'variants.*.pricing.stock.required_if' => 'Tồn kho của biến thể là bắt buộc.',
            'variants.*.pricing.stock.integer' => 'Tồn kho của biến thể phải là số nguyên.',
            'variants.*.pricing.stock.min' => 'Tồn kho của biến thể không được nhỏ hơn 0.',
            'variants.*.pricing.image.image' => 'Ảnh của biến thể phải là tệp hình ảnh.',
            'variants.*.pricing.image.mimes' => 'Ảnh của biến thể phải có định dạng jpg, jpeg, png hoặc webp.',
            'variants.*.pricing.image.max' => 'Ảnh của biến thể không được lớn hơn 2MB.',
        ]);
        
        // 👉 So sánh sau validate
        if (
            $request->filled('product_price') &&
            $request->filled('product_price_old') &&
            $request->product_price > $request->product_price_old
        ) {
            return back()->withErrors([
                'product_price' => 'Giá khuyến mãi không được lớn hơn giá gốc.',
            ])->withInput();
        }
        
        
        $dataProduct=$request->all();
        $productName = $dataProduct['product_name'] ?? 'Sản phẩm chưa có tên';

        // Tạo sản phẩm
        $product = Product::create([
            'name' => $productName, // Lấy tên từ dữ liệu đầu vào
            'category_id' => $dataProduct['category_id'], // Nếu không có thì mặc định là 1
            'description' => $dataProduct['description'] ?? '', // Nếu không có thì mặc định rỗng
            'short_description' => $dataProduct['short_description'] ?? '', // Thêm mô tả ngắn
            'price' => $dataProduct['product_price'],
            'price_pld'=>$dataProduct['product_price_old'],
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


    //tắt trạng thái
    public function delete($id)
    {
        // Kiểm tra xem sản phẩm đã có trong đơn hàng chưa
        $hasOrderDetails = OrderDetail::where('product_id', $id)->exists();
    
        if ($hasOrderDetails) {
            return redirect()->route('admin.product.index')
                ->with('error', 'Không thể xóa sản phẩm vì đã có dữ liệu liên quan đến đơn hàng.');
        }
    
        // Xóa các biến thể sản phẩm liên quan
        ProductVariant::where('product_id', $id)->delete();
    
        // Xóa các mục giỏ hàng liên quan
        Cart::where('product_id', $id)->delete();
    
        // Xóa sản phẩm
        $product = Product::findOrFail($id);
        $product->delete();
    
        return redirect()->route('admin.product.index')
            ->with('success', 'Sản phẩm và các dữ liệu liên quan đã được xóa thành công!');
    }
    

    public function toggleStatus(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = $request->is_active;
        $product->save();

        return response()->json(['success' => true]);
    }
}
