<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd(Auth::user());
         // return $next($request);
        if(!Auth::check())
        {
            return redirect('home-login');
        }

        if(Auth::user()->role_type == 'customer')
        {
            return $next($request);
        }

        if(Auth::user()->role_type == 'admin')
        {
            return redirect()->route('admin');
        }

        if(Auth::user()->role_type == 'delivery')
        {
            return redirect()->route('delivery');
        }
        
    }
}
