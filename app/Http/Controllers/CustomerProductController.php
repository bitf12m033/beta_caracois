<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlaced;
use App\Mail\AccountCreated;

use App\Models\OrderProducts;
use App\Order;
use App\Product;
use App\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
class CustomerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::statement(DB::raw('set @rownum=0'));

     /*   $e_date = Carbon::parse($product->expired_date)->format('Y-m-d');
        $t_day = Carbon::now()->format('Y-m-d');*/

        $products = Product::where('deleted_at',null)->where('is_active','1')->get(['products.*',
        DB::raw('@rownum  := @rownum  + 1 AS rownum')]);
        // $products = Product::where('is_active','1')->get();
        // dd($products);
        return view('customerProducts.index', ['products' => $products]);
    }
    public function cart()
    {
        return view('customerOrders.cart');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $user = Auth::user();
        $order->customer_name = $user->name;
        $order->customer_address = $user->address1;
        $order->customer_phone = $user->phone;
        $order->customer_email = $user->email;
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

            $remaining  =  Product::where('id', $pro->product_id)->first();
            $tot =  $remaining->quantity_left;
            $remaining->quantity_left = $tot - $pro->quantity;
            if( $remaining->quantity_left <= 0)
            {
                $remaining->is_active = 0 ;
            }
            $remaining->save();

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
        return redirect()->route('customerorder.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addToCartAjax(Request $request) {
        $id = $request->input('productid');
        $session = $request->session();
        $cartData = ($session->get('cart')) ? $session->get('cart') : array();
        if (array_key_exists($id, $cartData)) { 
            $cartData[$id]['qty']++;
        } else 
        {
            $cartData[$id] = array(
                'qty' => 1
            );
        }
        $request->session()->put('cart', $cartData);

        //return redirect()->back()->with('message', 'Product Added Successfully!');
        return response()->json(['msg' => $id], 200);
    }

    public function getCartDetails(Request $request)
    {
        
        if(!session('cart'))
        {
            toastr()->error('Cart is Empty', 'Error!');
            return redirect()->back();
        }
       
        $total =0;
        $items = [];
        foreach (session('cart') as $key => $details)
        {
            // dd($qty);
            $item = Product::where('id',$key)->first();
            $total += $item->sell_price * $details['qty'];
            array_push($items,array('id'=>$item->id,'product_name'=>$item->product_name,'product_image'=>$item->product_image,'qty'=>$details['qty'],'sell_price'=>$item->sell_price,'subtotal'=>$item->sell_price*$details['qty']));
        }

        return view('front.cart',compact('items','total'));
    }
    public function checkout(Request $request)
    {
        
        if(!session('cart'))
        {
            toastr()->error('Cart is Empty', 'Error!');
            return redirect()->back();
        }
       
        $total =0;
        $items = [];
        foreach (session('cart') as $key => $details)
        {
            // dd($qty);
            $item = Product::where('id',$key)->first();
            $total += $item->sell_price * $details['qty'];
            array_push($items,array('id'=>$item->id,'product_name'=>$item->product_name,'product_image'=>$item->product_image,'qty'=>$details['qty'],'sell_price'=>$item->sell_price,'subtotal'=>$item->sell_price*$details['qty']));
        }

        return view('front.checkout',compact('items','total'));
    }

    public function updateCart(Request $request)
    {  
        $qtys = $request->input('quantity');
       $productids = $request->input('productid');
        
       $total = 0;
        if(session('cart'))
        {   $items = [];
            $cart = session()->get('cart');
            foreach (session('cart') as $key => $details) {
                
                if(($k = array_search($key,$productids)) !== FALSE)
                {
                    if($qtys[$k] > 0){

                        $cart[$key]["qty"] = $qtys[$k];
                        $item = Product::where('id',$key)->first();
                        $total += $item->sell_price * $qtys[$k];
                        array_push($items,array('id'=>$item->id,'product_name'=>$item->product_name,'product_image'=>$item->product_image,'qty'=>$qtys[$k],'sell_price'=>$item->sell_price,'subtotal'=>$item->sell_price*$qtys[$k]));
                    }
                    else
                    {

                        unset($cart[$key]);
                    }
                }
            }   
            session()->put('cart', $cart);
            toastr()->success('Cart updated Successfully', 'Success!');
            return redirect()->back();          
        }
  
    }

    public function placeOrder(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'address1' => 'required',
            'phone' => 'required',
            'email'=>'required',
        ]);
        if(!session('cart'))
        {
            toastr()->error('Cart must not be Empty', 'Error!');
            return redirect()->back();
        }
        if(isset($request->create_account) && $request->create_account == 1)
        {
            $userexist = User::where('email',$request->email)->first();

            if($userexist == null)
            {

                $password = $request->password;
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($password);
                $user->role_type = 'customer';
                $user->address1 = $request->address1;
                $user->address2 = $request->address2;
                $user->phone = '+'.$request->phone;
                $user->save();

                $email_data['name'] = $user->name;
                $email_data['email'] = $user->email;
                $email_data['password'] = $password;
                $email_data['subject'] = 'Account Created';

                $name = $request->email;
                Mail::to($name)->send(new AccountCreated($email_data));
            }
        }

        $order = new Order();
        $order->customer_name = $request->name;
        $order->customer_address = $request->address1;
        $order->customer_phone = '+'.$request->phone;
        $order->customer_email = $request->email;
        $order->created_at = Carbon::now();
        $email_data2['created_at'] = Carbon::parse($order->created_at)->format('Y/m/d H:i');
        $total =0;
        $items = [];
        $sr=0;
        foreach (session('cart') as $id => $details)
        {
            $product_price = Product::where('id',$id)->first();
            $total += $product_price->sell_price * $details['qty'];
            $item = array('id'=>$id,'sr'=>++$sr,'quantity'=>$details['qty'],'name'=>$product_price->product_name,'unit_price'=>$product_price->sell_price,'cal_price'=>$product_price->sell_price*$details['qty']);
           array_push($items,$item);
         }
        $order->total_amount = $total;
        $order->products = 0;
        $order->save();

        $email_data2['name'] = $order->customer_name;
        $email_data2['order_no'] = $order->id;
        $email_data2['contact_no'] = $order->customer_phone;
        $email_data2['total'] = $order->total_amount;
        $email_data2['subject'] = 'Order Placed';
        $email_data2['items'] = $items;
        $email_data2['order_status'] = 'Pending';
        $email_data2['notification_text'] = 'Your Order has been Placed';


        $name = $order->customer_email;
        Mail::to($name)->send(new OrderPlaced($email_data2));

        foreach (session('cart') as $id => $details)
        {
            $pro = new OrderProducts();
            $pro->order_id = $order->id;
            $pro->product_id = $id;
            $pro->quantity = $details['qty'];
            $pro->save();

            $remaining  =  Product::where('id', $pro->product_id)->first();
            $tot =  $remaining->quantity_left;
            $remaining->quantity_left = $tot - $pro->quantity;
            if( $remaining->quantity_left <= 0)
            {
                $remaining->is_active = 0 ;
            }
            $remaining->save();

        }

        session()->forget('cart');
        toastr()->success('Order Place Successfully', 'Success!');
        return redirect('/thankyou');

    }

    public function fetchOrderHistoryForUser()
    {
        // dd(Auth::user());
        $email = Auth::user()->email;
        session()->forget('cart');

        DB::statement(DB::raw('set @rownum=0'));

        $orders = Order::where('deleted_at',null)->where('customer_email', $email)->get(['orders.*',
            DB::raw('@rownum  := @rownum  + 1 AS rownum')]);

        $products = Product::all();
        return view('front.order-history', ['orders' => $orders, 'products' => $products]);
    }

    public function deleteItemFromCart($id)
    {
        $cart = session()->get('cart');
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect()->back(); 
    }
}
