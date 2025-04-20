<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch the authenticated user
        $usertype = Auth::user()->usertype;
        // Check if the user is an admin
        if ($usertype == 1) {
            // Redirect to the admin dashboard
            return view('admin.dashboard');
        }
        else {
            $perPage = $request->input('per_page', 3); // Default to 10 items per page
            $products = Product::orderBy('id', 'desc')->paginate($perPage);

            // Redirect to the user dashboard
            return view('home.index', compact('products'));
        }
    }
}
