<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Merchant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            if (auth()->user()->is_merchant && auth()->user()->status == 'active') {
                return $next($request);
            }

            return redirect()->route('auth.loginForm')->with('error', 'You don\'t have permission to access the page!');
        }
        
        auth()->logout();
        return redirect()->route('auth.loginForm')->with('error', 'Please log in!');
    }
}
