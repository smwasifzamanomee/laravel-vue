<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkout\Order;
use App\Models\Checkout\Order_items;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $orders = Order::with(['user', 'order_items.product'])->orderBy('id', 'desc')->get();
        return view('admin.order.index', compact('orders'));
    }
    
    public function getOrderItems($orderId)
    {
        $orderItems = Order_items::with('product')->where('order_id', $orderId)->get();
        return response()->json($orderItems);
    }
}