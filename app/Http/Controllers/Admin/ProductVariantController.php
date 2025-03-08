<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
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
    public function store(Request $request){
        dd($request->all());
        // return view('admin.pages.variant.store');
    }
}
