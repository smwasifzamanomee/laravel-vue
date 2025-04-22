<?php

namespace App\Http\Controllers\Home\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use Session;
use App\Models\Checkout\Order;
use App\Models\Checkout\Order_items;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            "id" => $product->id,
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
    public function increase($id)
    {
        $cart = session()->get('cart');
        $cart[$id]['quantity']++;
        session()->put('cart', $cart);
        return back();
    }

    public function decrease($id)
    {
        $cart = session()->get('cart');
        if ($cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
        }
        session()->put('cart', $cart);
        return back();
    }
    public function delete($id){
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index');
    }
    public function checkout()
    {
        $cart = session()->get('cart');

        if (!$cart || count($cart) === 0) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            $totalQuantity = 0;
            $totalPrice = 0;

            foreach ($cart as $item) {
                $totalQuantity += $item['quantity'];
                $totalPrice += $item['quantity'] * $item['price'];
            }

            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'total_quantity' => $totalQuantity,
            ]);

            // Create the order items
            foreach ($cart as $item) {
                Order_items::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price'],
                ]);
            }

            // Clear cart after order placed
            session()->forget('cart');

            DB::commit();

            return redirect()->route('order.success')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function about(){
        $data = Product::all();
        return view('home.about', compact('data'));
    }
}
