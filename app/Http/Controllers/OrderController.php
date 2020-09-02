<?php

namespace App\Http\Controllers;

use App\Models\OrderProducts;
use App\Order;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        session()->forget('cart');

        DB::statement(DB::raw('set @rownum=0'));

        $orders = Order::get(['orders.*',
            DB::raw('@rownum  := @rownum  + 1 AS rownum')]);

        $products = Product::all();
        return view('orders.index', ['orders' => $orders, 'products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('orders.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!session('cart'))
        {
            toastr()->error('Cart must not be Empty', 'Error!');
            return redirect()->back();
        }
        $order = new Order();
        $order->customer_name = $request->customer_name;
        $order->customer_address = $request->customer_add;
        $order->customer_phone = '+'.$request->contact_num;
        $total =0;
        $productes = [];
        foreach (session('cart') as $id => $details)
        {
            $product_price = Product::where('id',$details['product_id'])->first();
            $total += $product_price->sell_price * $details['quantity'];
          //  array_push($productes,$details['product_id']);
         }
        $order->total_amount = $total;
        $order->products = 0;
        $order->save();
        foreach (session('cart') as $id => $details)
        {
            $pro = new OrderProducts();
            $pro->order_id = $order->id;
            $pro->product_id = $details['product_id'];
            $pro->quantity = $details['quantity'];
            $pro->save();
        }
       /* foreach($request->product as $am)
        {
            $product_price = Product::where('id',$am)->first();
            $amount = $amount + $product_price->sell_price;
        }
        $order->total_amount = $amount;
        $order->products = serialize($request->product);
        $order->save();*/
        session()->forget('cart');
        toastr()->success('Order Place Successfully', 'Success!');
        return redirect()->route('orders.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        $product = OrderProducts::where('order_id',$id)->get();
        return view('orders.edit',  compact('order','product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $order = Order::where('id',$request->id)->first();
        $order->deleted_at = Carbon::now()->toDateTimeString();
        $order->save();
        return redirect()->route('orders.index')
            ->with('success','Order deleted successfully');
    }
    public function change_status(Request $request)
    {
        //dd($request->all());
        if( isset($request->dataURL) and strlen($request->dataURL) > 700 )
        {
            $data               = $request->dataURL;
            list($type, $data)  = explode(';', $data);
            list(, $data)       = explode(',', $data);
            $data               = base64_decode($data);
            $logoName           = rand(000000000, 999999999) . '.png';
            file_put_contents(public_path() . '/uploads/signatures/' . $logoName, $data);
            $order = Order::where('id',$request->order_id)->first();
            if(isset($request->payment_received) && $request->payment_received == 1 )
            $order->payment_status = $request->payment_received;
            $order->order_status = 1;
            $order->signature = $logoName;
            $order->save();

            return redirect()->back()->with('success', 'Order Updated successfully!');
        }
    }
}
