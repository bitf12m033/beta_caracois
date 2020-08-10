<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
Use Carbon\Carbon;

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
        
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
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
        $user->password = $request->input('password');
        $user->user_image = $path;
        
        // dd($product);
        $user->save();
        //sign them in
        $notification = [
            'message' => 'User is added successfully.!',
            'alert-type' => 'success'
        ];
        return redirect('/users')->with($notification);

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
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
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
       
        $user = User::find($id);
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
        $user->password = $request->input('password');
        $user->user_image = $path;
        
        // dd($product);
        $user->save();

        //sign them in
        $notification = [
            'message' => 'User is updated successfully.!',
            'alert-type' => 'success'
        ];
        return redirect('/users')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');

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
            $temp['Type'] = rand(1,3);
            $temp['Actions'] = null;
            array_push($response['data'], $temp);
           
        }
        return response()->json($response);
    }
}
