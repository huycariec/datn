<?php

namespace App\Http\Controllers\Admin;

use App\Models\Images;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Illuminate\Validation\Rule;
use App\Models\VariantAttribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index(){
        $products = Product::with('images')->where('is_active', 1)->latest()->get();
        // dd($products);
        return view('admin.pages.product.index',compact('products'));
    }
    public function create(){
        return view('admin.pages.product.create');
    }
    public function store(Request $request)
    {
        $dataProduct=$request->all();
        $productName = $dataProduct['product_name'] ?? 'Sản phẩm chưa có tên';
    
        // Tạo sản phẩm
        $product = Product::create([
            'name' => $productName,
            'category_id' => 1,
            'product_type' => 1,
            'description'=>$dataProduct['description'],
            'price'=> $dataProduct['product_price'],
            'view'=>1

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

    public function edit($id){
        $product = Product::with(['variants.images'])->find($id);
        return view('admin.pages.product.edit',compact('product'));

    }
    public function delete($id)
    {
        $product = Product::findOrFail($id); // Tìm sản phẩm theo ID
        $product->is_active = 0; // Cập nhật trạng thái is_active thành 0
        $product->save(); // Lưu thay đổi
    
        return redirect()->route('admin.product.index')->with('success', 'Sản phẩm đã được tắt thành công!');
    }
    
}
