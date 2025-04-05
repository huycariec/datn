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

    public function updateStatus(Request $request, $id)
    {
        $productVariant = ProductVariant::findOrFail($id);
        $productVariant->is_active = $request->is_active;
        $productVariant->save();

        return response()->json(['success' => true]);
    }
    public function edit($id)
    {
        $variant = ProductVariant::with([
            'variantAttributes.attribute',
            'variantAttributes.attributeValue'
        ])->findOrFail($id);
    
        // Tạo mảng thuộc tính
        $attributes = [];
    
        foreach ($variant->variantAttributes as $variantAttribute) {
            if ($variantAttribute->attribute && $variantAttribute->attributeValue) {
                $attributes[] = [
                    'attribute_name' => $variantAttribute->attribute->name,
                    'attribute_value' => $variantAttribute->attributeValue->value,
                ];
            }
        }
    
        return view('admin.pages.variant.edit', compact('variant', 'attributes'));
    }
    
    

    
}
