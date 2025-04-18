<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateDealer
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('dealer')->check()) {
            return redirect()->route('dealer.login');
        }
        return $next($request);
    }
}
