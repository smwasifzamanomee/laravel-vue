<?php

namespace App\Http\Controllers\Home\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('home.index', compact('products'));
    }
}
