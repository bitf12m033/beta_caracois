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
        
        return view('front.index');
    }

    public function showProducts()
    {
        $products = Product::all();

        return view('front.products',compact('products'));
    }
}
