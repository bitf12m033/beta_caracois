<?php

namespace App\Http\Middleware;

use Closure;

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
        if ($request->user() && $request->user()->role_type != 'delivery')
        {
            return response()->view('pages.unauthorized',['role' => 'Delivery Boy']);
        }
        return $next($request);
    }
}
