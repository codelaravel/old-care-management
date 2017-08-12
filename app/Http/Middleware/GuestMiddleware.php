<?php

namespace App\Http\Middleware;

use Sentinel;
use Closure;

class GuestMiddleware
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
        if (Sentinel::guest()) {
            return $next($request);
        } else {
            return redirect('/dashboard');
        }
    }
}
