<?php

namespace App\Http\Controllers\Home\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 3); // Default to 10 items per page
        $products = Product::orderBy('id', 'desc')->paginate($perPage);
        
        return view('home.index', compact('products'));
    }
}