<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AdminMiddleware
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
        if(!Auth::check())
        {
            return redirect()->route('home-login');
        }

        if(Auth::user()->role_type == 'admin')
        {
            return $next($request);
        }

        if(Auth::user()->role_type == 'customer')
        {
            return redirect()->route('home');
        }

        if(Auth::user()->role_type == 'delivery')
        {
            return redirect()->route('delivery');
        }
        // dd(Auth::user());
       /* if (Auth::user() && Auth::user()->role_type != 'admin')
        {
            return response()->view('pages.unauthorized',['role' => 'ADMIN']);
        }
        return $next($request);*/
    }
}
