<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function showBuyingGuide()
    {
        return view('huongdan');  // hoặc 'pages.huongdan' nếu view trong thư mục 'pages'
    }
}
