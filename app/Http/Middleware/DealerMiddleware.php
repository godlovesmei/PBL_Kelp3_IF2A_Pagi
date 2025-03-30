<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('dealer')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login sebagai dealer terlebih dahulu.');
        }
        return $next($request);
    }
}


