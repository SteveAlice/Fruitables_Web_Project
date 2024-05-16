<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotAdmin 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     if (\Auth::user()->role != 'admin') {
    //         return route('404');
    //     }
       
    // }
    public function handle($request, $next)
    {
        if (\Auth::user()->role != 'admin') {
            return redirect(route('404'));
        }
        return $next($request);
    }
}
