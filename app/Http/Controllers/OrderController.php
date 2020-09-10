<?php

namespace App\Http\Controllers;

use App\Mail\AccountCreated;
use App\Mail\OrderPlaced;
use App\Models\OrderProducts;
use App\Order;
use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

        $orders = Order::where('deleted_at',null)->get(['orders.*',
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
        $this->validate($request, [
            'customer_name' => 'required',
            'customer_add' => 'required',
            'contact_num' => 'required',
            'email'=>'required',
        ]);
        if(!session('cart'))
        {
            toastr()->error('Cart must not be Empty', 'Error!');
            return redirect()->back();
        }
        $userexist = User::where('email',$request->email)->first();
        if($userexist == null)
        {

            $password = Str::random(10);
            $user = new User();
            $user->name = $request->customer_name;
            $user->email = $request->email;
            $user->password = Hash::make($password);
            $user->role_type = 'customer';
            $user->address1 = $request->customer_add;
            $user->save();

            $email_data['name'] = $user->name;
            $email_data['email'] = $user->email;
            $email_data['password'] = $password;
            $email_data['subject'] = 'Account Created';

            $name = $request->email;
            Mail::to($name)->send(new AccountCreated($email_data));
        }

        $order = new Order();
        $order->customer_name = $request->customer_name;
        $order->customer_address = $request->customer_add;
        $order->customer_phone = '+'.$request->contact_num;
        $order->customer_email = $request->email;
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

        $email_data2['name'] = $order->customer_name;
        $email_data2['order_no'] = $order->id;
        $email_data2['contact_no'] = $order->customer_phone;
        $email_data2['total'] = $order->total_amount;
        $email_data2['subject'] = 'Account Created';

        $name = $order->customer_email;
        Mail::to($name)->send(new OrderPlaced($email_data2));

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
        if(session('cart'))
        {
            return view('orders.edit',  compact('order'));
        }
        session()->forget('cart');

        $products = OrderProducts::where('order_id',$id)->get();
      //  dd($products);
        foreach ($products as $pr)
        {
            $product = Product::find($pr->product_id);
            if(!$product) {

                abort(404);

            }

            $cart = session()->get('cart');

            // if cart is empty then this the first product
            if(!$cart) {

                $cart = [
                    $pr->product_id => [
                        "product_id" => $product->id,
                        "name" => $product->product_name,
                        "quantity" => $pr->quantity,
                        "price" => $product->sell_price,
                        /*"photo" => $product->photo*/
                    ]
                ];

                session()->put('cart', $cart);
               // return redirect()->back()->with('success', 'Product added to cart successfully!');
            }
            else
            {
                $cart[$pr->product_id] = [
                    "product_id" => $product->id,
                    "name" => $product->product_name,
                    "quantity" => $pr->quantity,
                    "price" => $product->sell_price,
                    /*"photo" => $product->photo*/
                ];

                session()->put('cart', $cart);
            }

        }
      //  dd(session('cart') );
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
        dd($order);
    }
    public function orders_update(Request $request)
    {
        $this->validate($request, [
            'customer_name' => 'required',
            'customer_add' => 'required',
            'contact' => 'required',
        ]);
        if(!session('cart'))
        {
            toastr()->error('Cart must not be Empty', 'Error!');
            return redirect()->back();
        }
        $order = Order::where('id',$request->id)->first();
        $order->customer_name = $request->customer_name;
        $order->customer_address = $request->customer_add;
        $order->customer_phone = $request->contact;
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
        $prod = OrderProducts::where('order_id',$request->id)->get();
        foreach ($prod as $pf)
        {
            $pf->delete();
        }
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
        toastr()->success('Order Updated Successfully', 'Success!');
        return redirect()->route('orders.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::where('id',$id)->first();
        $order->deleted_at = Carbon::now()->toDateTimeString();
        $order->save();
        toastr()->success('Order Deleted Successfully', 'Success!');
        return redirect()->route('orders.index');
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
