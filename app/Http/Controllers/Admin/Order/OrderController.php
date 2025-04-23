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
    
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        $priceRange = $request->input('price_filter');
        $quantityRange = $request->input('quantity_filter');
        
        $query = Order::with(['user', 'order_items.product'])
            ->orderBy('id', 'desc');
            
        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                })->orWhere('id', 'like', "%{$search}%");
            });
        }
        
        // Apply price filter
        if ($priceRange) {
            if (strpos($priceRange, '+') !== false) {
                $minPrice = (float) str_replace('+', '', $priceRange);
                $query->where('total_price', '>=', $minPrice);
            } else {
                [$minPrice, $maxPrice] = explode('-', $priceRange);
                $query->whereBetween('total_price', [(float)$minPrice, (float)$maxPrice]);
            }
        }
        
        // Apply quantity filter
        if ($quantityRange) {
            if (strpos($quantityRange, '+') !== false) {
                $minQuantity = (int) str_replace('+', '', $quantityRange);
                $query->where('total_quantity', '>=', $minQuantity);
            } else {
                [$minQuantity, $maxQuantity] = explode('-', $quantityRange);
                $query->whereBetween('total_quantity', [(int)$minQuantity, (int)$maxQuantity]);
            }
        }
        
        $orders = $query->paginate($perPage);
        
        if ($request->wantsJson()) {
            return response()->json($orders);
        }
        
        return view('admin.order.index', compact('orders'));
    }
    
    public function getOrderItems($orderId)
    {
        $orderItems = Order_items::with('product')->where('order_id', $orderId)->get();
        return response()->json($orderItems);
    }
}