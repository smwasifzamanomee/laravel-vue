<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.product.index', compact('products'));
    }
    public function create()
    { 
        $categories = Category::all();
        // dd($categories);
        return view('admin.product.productCreate', compact('categories'));
    }
    public function store(Request $request)
    {
        // Use Validator for manual validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|numeric',
            'discount_price' => 'required|numeric',
            'status' => 'required',
            'featured' => 'required',
            'popular' => 'required'
        ]);
    
        // Check for validation failure
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
    
        // Get validated data
        $validatedData = $validator->validated();
    
        // Store image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }
    
        // Save product
        Product::create($validatedData);
    
        return redirect()->back()->with('message', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.product.productEdit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'quantity' => 'required|numeric',
            'discount_price' => 'required|numeric',
            'status' => 'required',
            'featured' => 'required',
            'popular' => 'required',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->discount_price = $request->discount_price;
        $product->status = $request->status;
        $product->featured = $request->featured;
        $product->popular = $request->popular;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->back()->with('message', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->back()->with('message', 'Product deleted successfully.');
    }
}
