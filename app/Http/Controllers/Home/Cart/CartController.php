<?php

namespace App\Http\Controllers\Home\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use Session;

class CartController extends Controller
{
    //
    public function index(){
        // session from get 
        $cart = Session::get('cart');
        // dd($cart);
        return view('home.cart', compact('cart'));
    }

    // add to cart all are set in session storage
    public function add($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // If already in cart, return error message
        if (isset($cart[$id])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product already added to cart',
            ]);
        }

        // Add to cart
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->image,
        ];

        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart',
            'cart' => $cart,
            'cart_count' => count($cart) // Optional: useful for displaying cart count
        ]);
    }
}
