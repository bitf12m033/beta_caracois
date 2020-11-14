<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class DeliveryBoyMiddleware
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
        if (Auth::user() && Auth::user()->role_type != 'delivery')
        {
            return response()->view('pages.unauthorized',['role' => 'Delivery Boy']);
        }
        return $next($request);

       /* if(!Auth::check())
        {
            return redirect()->route('home-login');
        }

        if(Auth::user()->role_type == 'delivery')
        {
            return $next($request);
        }

        if(Auth::user()->role_type == 'customer')
        {
            return redirect()->route('home');
        }

        if(Auth::user()->role_type == 'admin')
        {
            return redirect()->route('admin');
        }
        */

    }
}
