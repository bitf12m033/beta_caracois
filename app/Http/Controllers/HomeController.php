<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\OrderProducts;
use App\Order;
use App\Product;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_orders = Order::where('deleted_at',null)->get()->count();
        $pending_orders = Order::where('deleted_at',null)->where('order_status',0)->where('payment_status',0)->get()->count();
        $complete_orders = Order::where('deleted_at',null)->where('order_status',1)->where('payment_status',1)->get()->count();
        // dd($complete_orders);
        return view('dashboard.index',compact('total_orders','pending_orders','complete_orders'));
    }

    public function showProducts()
    {
        $products = Product::all();

        return view('front.products',compact('products'));
    }
}
