<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo()
    {
        // dd(Auth::user());
        switch (Auth::user()->role_type) {
            case 'admin':
                $this->redirectTo = '/admin';
                return $this->redirectTo;            
            case 'customer':
                $this->redirectTo = '/home';
                return $this->redirectTo;
                break;
            case 'delivery':
                $this->redirectTo = '/delivery';
                return $this->redirectTo;
                break;
            default:
           
                $this->redirectTo = '/home-login';
                return $this->redirectTo;
                break;
        }
    }
}
