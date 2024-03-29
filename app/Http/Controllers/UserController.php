<?php

namespace App\Http\Controllers;

use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use App\User;
Use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\AccountCreated;
use Illuminate\Support\Facades\Mail;
use Auth;
class UserController extends Controller
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
        if(Auth::user()->role_type == 'customer')
            return view('front.index');
        else
            return view('dashboard.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('dashboard.user.add');
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' =>'required|unique:users',
            'phone' => 'required',
            'zip' => 'required',
            'state' => 'required',
            'dob' => 'required',
            'role_type' => 'required',
            'user_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->file('user_image')) {
              $imagePath = $request->file('user_image');
              $imageName = uniqid().".".$request->file('user_image')->extension();

              $path = $request->file('user_image')->storeAs('uploads/user', $imageName, 'public');
            $request->file('user_image')->move(public_path('uploads/user'), $imageName);
        }
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->zip = $request->input('zip');
        $user->address1 = $request->input('address1');
        $user->address2 = $request->input('address2');
        $user->dob = Carbon::parse($request->input('dob'))->format('Y-m-d');
        $user->role_type = $request->input('role_type');
        if($request->input('password'))
            $user->password = Hash::make($request->input('password'));
        $user->user_image = $path;
        
        // dd($product);
        if($user->save())
        {
            toastr()->success('User is added successfully.!', 'Success!');
            //sign them in
            $email_data['name'] = $user->name;
            $email_data['email'] = $user->email;
            $email_data['password'] = $request->input('password');
            $email_data['subject'] = 'New Account Created';

            $name = $request->email;
            Mail::to($name)->send(new AccountCreated($email_data));
            return redirect('/users');
        }
        else
        {
            toastr()->error('Oops...Something went Wrong!', 'error!');
            return redirect()->back();
        }
       // return redirect('/users')->with($notification);

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
    public function edit(User $user)
    {

        return view('dashboard.user.edit',compact("user"));
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
         $request->validate([
            'name' => 'required',
            // 'email' => 'required|unique:users',
            'phone' => 'required',
            // 'password' => 'required',
            'zip' => 'required',
            'state' => 'required',
            'dob' => 'required',
            // 'role_type' => 'required',
            'user_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $user = User::find($id);
        if ($request->file('user_image')) {
              $imagePath = $request->file('user_image');
              $imageName = uniqid().".".$request->file('user_image')->extension();

            $path = $request->file('user_image')->storeAs('uploads/user', $imageName, 'public');
            $request->file('user_image')->move(public_path('uploads/user'), $imageName);
            $user->user_image = $path;
        }
       
        
        $user->name = $request->input('name');
        // $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->zip = $request->input('zip');
        $user->address1 = $request->input('address1');
        $user->address2 = $request->input('address2');
        $user->dob = Carbon::parse($request->input('dob'))->format('Y-m-d');
        $user->role_type = $request->input('role_type');
        // $user->password = Hash::make($request->input('password'));
        
        
        if($user->save())
        {
            toastr()->success('User is updated successfully.', 'Success!');
        }
        else
        {
            toastr()->error('Oops...Something went Wrong', 'error!');
        }
        //sign them in
        $notification = [
            'message' => 'User is updated successfully.!',
            'alert-type' => 'success'
        ];
        return redirect('/users');//->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->delete())
        {
            toastr()->success('User deleted successfully.!', 'Success!');
        }
        else
        {
            toastr()->error('Oops...Something went Wrong', 'error!');
        }

        // toastr()->error('User is Deleted successfully.!', 'Success!');
        return redirect()->back();

    }

     public function fetchAllUsers()
    {
        $users = User::all();

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
        foreach ($users as $user) {
            $temp= [];
            $temp['sr'] = $id++;
            $temp['id'] = $user->id;
            // $temp['brand_name'] = $product->brand_name;
            $temp['name'] = $user->name;
            $temp['user_image'] = $user->user_image;
            // $temp['receive_date'] = $product->receive_date;
            // $temp['category'] = $product->category;
            $temp['email'] = $user->email;
            // $temp['orginal_price'] = $product->orginal_price;
            $temp['phone'] = $user->phone;
            $temp['address1'] = $user->address1;
            $temp['Status'] = rand(1,5);
            $role_type = 2;
            if($user->role_type == 'admin')
                $role_type =1;
            else if($user->role_type == 'customer')
                $role_type = 2;
            else if ($user->role_type == 'delivery')
                $role_type = 3;
            $temp['Type'] = $role_type;
            $temp['Actions'] = null;
            array_push($response['data'], $temp);
           
        }
        return response()->json($response);
    }
    public function changepassword()
    {
        return view('auth.changepassword');
    }
    public function updatepassword(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        toastr()->success('Password changed successfully.', 'Success!!');
        return redirect()->back();
    }
    public function delivery_boys()
    {
        DB::statement(DB::raw('set @rownum=0'));

        /*   $e_date = Carbon::parse($product->expired_date)->format('Y-m-d');
           $t_day = Carbon::now()->format('Y-m-d');*/

        $users = User::where('deleted_at',null)->where('role_type','delivery')->get(['users.*',
            DB::raw('@rownum  := @rownum  + 1 AS rownum')]);
        $title = 'Delivery Persons';

        return view('dashboard.user.delivery_boy',compact('users','title'));
    }
    public function all_customers()
    {
        DB::statement(DB::raw('set @rownum=0'));

        /*   $e_date = Carbon::parse($product->expired_date)->format('Y-m-d');
           $t_day = Carbon::now()->format('Y-m-d');*/

        $users = User::where('deleted_at',null)->where('role_type','customer')->get(['users.*',
            DB::raw('@rownum  := @rownum  + 1 AS rownum')]);

        $title = 'Customers';
        return view('dashboard.user.delivery_boy',compact('users','title'));
    }

}
