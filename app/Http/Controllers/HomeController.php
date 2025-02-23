<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(){
        $categories = Category::all(); 
        $products = Product::where('is_active', 1)->get();
        return view('client.home', compact('categories', 'products')); 
    }
}
