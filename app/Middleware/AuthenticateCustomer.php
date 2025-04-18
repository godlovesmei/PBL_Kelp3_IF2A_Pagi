<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateCustomer
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login');
        }
        return $next($request);
    }

    protected function redirectTo($request)
{
    if (!$request->expectsJson()) {
        return route('customer.login'); // Ganti ke route yang sesuai
    }
}

}
