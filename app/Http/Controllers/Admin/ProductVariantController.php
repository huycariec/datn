<?php

namespace App\Http\Controllers\Admin;

use App\Models\Images;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use App\Models\VariantAttribute;
use App\Http\Controllers\Controller;

class ProductVariantController extends Controller
{
    public function index($id){
        // $product = Product::with(['variants.images'])->find($id);
        $product = Product::with([
            'variants.images',
            'variants.variantAttributes.attributeValue.attribute'
        ])->find($id);
        
        
        return view('admin.pages.variant.index',compact('product'));
    }
    public function store(Request $request)
    {
        // Tạo biến thể sản phẩm (lưu ngay vào database)
        $variant = ProductVariant::create([
            'product_id' => $request->product_id,
            'price' => $request->variants['price'],
            'stock' => $request->variants['stock'],
            'sku' => ''
        ]);

        // Cập nhật SKU sau khi có ID
        $variant->update([
            'sku' => $variant->product_id . '-' . $variant->id
        ]);

            // Lưu thuộc tính vào bảng variant_attributes
            if (!empty($request->variants['attributes'])) {
                foreach ($request->variants['attributes'] as $attribute_id => $attribute_value_name) {
                    $attributeValue = AttributeValue::where('value', $attribute_value_name)
                        ->where('attributes_id', $attribute_id)
                        ->first();

                    if ($attributeValue) {
                        VariantAttribute::create([
                            'product_variant_id' => $variant->id,
                            'attributes_id' => $attribute_id,
                            'attribute_value_id' => $attributeValue->id,
                        ]);
                    }
                }
            }

            // Nếu có hình ảnh, xử lý lưu ảnh
            if ($request->hasFile('variants.image')) {
                $imagePath = $request->file('variants.image')->store('product_variants', 'public');

                // Lưu vào bảng images
                Images::create([
                    'product_id' => $request->product_id,
                    'product_variant_id' => $variant->id,
                    'url' => $imagePath,
                ]);
            }

            return redirect()->back()->with('success', 'Biến thể sản phẩm đã được thêm thành công!');
    }
    public function edit($id)
    {
        $variant = ProductVariant::with([
            'variantAttributes.attributeValue.attribute'
        ])->findOrFail($id);
        
        $attributes = $variant->variantAttributes->map(function($item) {
            return [
                'attribute_name' => optional($item->attributeValue->attribute)->name,
                'attribute_value' => optional($item->attributeValue)->value,
            ];
        });
    
        return view('admin.pages.variant.edit', compact('variant', 'attributes'));
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
            ]);
    
            ProductVariant::findOrFail($id)->update([
                'price' => $request->price,
                'stock' => $request->quantity,
            ]);
    
            return response()->json(['status' => 'success', 'message' => 'Cập nhật thành công!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Đã có lỗi xảy ra!']);
        }
    }
    
    
    

    public function updateStatus(Request $request)
    {
        $variant = ProductVariant::findOrFail($request->id);
        
        $variant->is_active = $variant->is_active == 1 ? 0 : 1;
        $variant->save();

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật trạng thái thành công!',
            'is_active' => $variant->is_active // gửi về luôn để frontend xử lý nếu cần
        ]);
    }

    

    
}
