<?php

namespace App\Http\Controllers;

use App\Models\OrderProducts;
use App\Product;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // dd($request->all());
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
        if ($request->file('product_image')) {
              $imagePath = $request->file('product_image');
              $imageName = uniqid().".".$request->file('product_image')->extension();

              $path = $request->file('product_image')->storeAs('uploads/product', $imageName, 'public');
            $request->file('product_image')->move(public_path('uploads/product'), $imageName);
        }
        $product->product_image = $path;
        //Total value finding
        $sell = $product->sell_price;
        $left = $product->quantity_left;
        $product->total= $sell * $left;
        // dd($product);
        if($product->save())
        {
            toastr()->success('Product added successfully.!', 'Success!');
        }
        else
        {
            toastr()->error('Oops...Something went Wrong', 'error!');
        }
            return redirect('/products');
        //sign them in
       /* $notification = [
            'message' => 'Product is added successfully.!',
            'alert-type' => 'success'
        ];*/

        
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
        if ($request->file('product_image')) {
              $imagePath = $request->file('product_image');
              $imageName = uniqid().".".$request->file('product_image')->extension();

              $path = $request->file('product_image')->storeAs('uploads/product', $imageName, 'public');
            $request->file('product_image')->move(public_path('uploads/product'), $imageName);
            $product->product_image = $path;
        }

        if($product->update($request->all()))
        {
            toastr()->success('Product updated successfully.!', 'Success!');
        }
        else
        {
            toastr()->error('Oops...Something went Wrong', 'error!');
        }
        //sign them in
        $notification = [
            'message' => 'Product is added successfully.!',
            'alert-type' => 'success'
        ];
        return redirect('/products');//->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
       
        if($product->delete())
        {
            toastr()->success('Product deleted successfully.!', 'Success!');
        }
        else
        {
            toastr()->error('Oops...Something went Wrong', 'error!');
        }
        return redirect()->route('products.index');
                        // ->with('success','Product deleted successfully');
      
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
            $temp['product_image'] = $product->product_image;
            $temp['receive_date'] = $product->receive_date;
            $temp['category'] = $product->category;
            $temp['expired_date'] = $product->expired_date;
            // $temp['orginal_price'] = $product->orginal_price;
            $temp['quantity'] = $product->quantity;
            $temp['sell_price'] = $product->sell_price;
            // $temp['Status'] = rand(1,5);
            $temp['Type'] = $product->category;
            $temp['Actions'] = null;
            array_push($response['data'], $temp);
           
        }
        return response()->json($response);
    }
    public function productAjax(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("products")
                ->select("id","product_name","sell_price")
                ->where('product_name','LIKE',"%$search%")
                ->where('is_active','1')
                ->whereNull('deleted_at')
                ->get();
        }
        else
        {
            $data = DB::table("products")
                ->select("id","product_name","sell_price","expired_date")
             /*   ->where(Carbon::parse('expired_date'), '>=',Carbon::now()->format('m/d/Y'))*/
                ->where('is_active','1')
                ->whereNull('deleted_at')
                ->get();
        }
        return response()->json($data);
    }
    public function addToCart(Request $request,$id)
    {
        $product = Product::find($id);

        if(!$product) {

            abort(404);

        }

        $cart = session()->get('cart');

        // if cart is empty then this the first product
        if(!$cart) {

            $cart = [
                $id => [
                    "product_id" => $id,
                    "name" => $product->product_name,
                    "quantity" => 1,
                    "price" => $product->sell_price,
                    /*"photo" => $product->photo*/
                ]
            ];

            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {

            $cart[$id]['quantity']++;

            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Product added to cart successfully!');

        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "product_id" => $id,
            "name" => $product->product_name,
            "quantity" => 1,
            "price" => $product->sell_price,
            /*"photo" => $product->photo*/
        ];

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    public function cart()
    {
        return view('orders.cart');
    }
    public function update_cart(Request $request)
    {

        if($request->id and $request->quantity)
        {
            $cart = session()->get('cart');

            $cart[$request->id]["quantity"] = $request->quantity;

            session()->put('cart', $cart);

            session()->flash('success', 'Cart updated successfully');
        }

    }
    public function remove_cart(Request $request)
    {
        if($request->id) {

            $cart = session()->get('cart');

            if(isset($cart[$request->id])) {

                unset($cart[$request->id]);

                session()->put('cart', $cart);
            }

            session()->flash('success', 'Product removed successfully');
        }
    }
    public function order_products(Request $request)
    {
        $orders = OrderProducts::where('order_id',$request->order_id)->get();
        // return $request->shift_id;
        $html =  '<table class="table table-hover nowrap">
                   <thead class="thead-default">
                            <tr>
                            <th>Brand name</th>
                            <th>Product name</th>
                            <th>Category</th>
                            <th>Price</th>
                             <th>Quantity</th>
                            </tr>
                </thead>
                  <tbody> ';
        foreach ($orders as $shift)
        {
            $html .= '<tr>';
            $html .= '<td>';
                $html .=  $shift->product->brand_name;
            $html .= '</td>';
            $html .= '<td>';
                $html .=  $shift->product->product_name;
            $html .= '</td>';
            $html .= '<td>';
            $html .=  $shift->product->category;
            $html .= '</td>';
            $html .= '<td>';
            $html .=  $shift->product->sell_price;
            $html .= '</td>';
            $html .= '<td>';
            $html .=  $shift->quantity;
            $html .= '</td>';

            $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>
            </table>';
        return $html;
        die;
    }

}
