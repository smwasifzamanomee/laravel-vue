<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkout\Order;

class OrderController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->get();
        // dd($orders);
        return view('admin.order.index', compact('orders'));
    }
}
