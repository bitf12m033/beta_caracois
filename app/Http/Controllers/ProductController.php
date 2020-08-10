<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.product.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'brand_name' => 'required',
            'product_name' => 'required',
            'category' => 'required',
            'receive_date' => 'required',
            'expired_date' => 'required',
            'original_price' => 'required',
            'sell_price' => 'required',
            'quantity' => 'required',
        ]);

        //crete and save the Product
        // dd($validatedData);
        $product = new Product();
        $product->brand_name = $request->input('brand_name');
        $product->product_name = $request->input('product_name');
        $product->category = $request->input('category');
        $product->receive_date = $request->input('receive_date');
        $product->expired_date = $request->input('expired_date');
        $product->original_price = $request->input('original_price');
        $product->sell_price = $request->input('sell_price');
        $product->quantity = $request->input('quantity');
        $product->quantity_left = $request->input('quantity');
        //Total value finding
        $sell = $product->sell_price;
        $left = $product->quantity_left;
        $product->total= $sell * $left;
        // dd($product);
        $product->save();
        //sign them in
        $notification = [
            'message' => 'Product is added successfully.!',
            'alert-type' => 'success'
        ];
        return redirect('/products')->with($notification);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        
        return view('dashboard.product.edit',compact("product"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'brand_name' => 'required',
            'product_name' => 'required',
            'category' => 'required',
            'receive_date' => 'required',
            'expired_date' => 'required',
            'original_price' => 'required',
            'sell_price' => 'required',
            'quantity' => 'required',
        ]);

        $product->update($request->all());

        //sign them in
        $notification = [
            'message' => 'Product is added successfully.!',
            'alert-type' => 'success'
        ];
        return redirect('/products')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
      
    }
    /**
     * AJAX requests
     */

    public function fetchAllProducts()
    {
        $products = Product::all();

        $response = [];
        $response["meta"]=array(
                "page"=> 1,
                "pages"=> 1,
                "perpage"=> -1,
                "total"=> 350,
                "sort"=> "asc",
                "field"=> "id",
            );
        $response['data'] = [];
        
         $id = 1;   
        foreach ($products as $product) {
            $temp= [];
            $temp['sr'] = $id++;
            $temp['id'] = $product->id;
            // $temp['brand_name'] = $product->brand_name;
            $temp['product_name'] = $product->product_name;
            // $temp['receive_date'] = $product->receive_date;
            // $temp['category'] = $product->category;
            $temp['expired_date'] = $product->expired_date;
            // $temp['orginal_price'] = $product->orginal_price;
            $temp['quantity'] = $product->quantity;
            $temp['sell_price'] = $product->sell_price;
            $temp['Status'] = rand(1,5);
            $temp['Type'] = rand(1,3);
            $temp['Actions'] = null;
            array_push($response['data'], $temp);
           
        }
        return response()->json($response);
    }
}
