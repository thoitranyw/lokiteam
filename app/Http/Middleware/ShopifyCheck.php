<?php

namespace App\Http\Middleware;

use Closure;

class ShopifyCheck
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
        if(!session('shopId'))
            return redirect(route('apps.installApp'));
        return $next($request);
    }
}
