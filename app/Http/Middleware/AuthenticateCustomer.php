<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah user sudah login menggunakan guard 'customer'
        if (!Auth::guard('customer')->check()) {
            // Jika request ekspektasi JSON (misalnya dari API), return JSON error
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            // Jika bukan JSON, redirect ke halaman login
            return redirect()->route('customer.login');
        }

        // Lanjutkan request jika user sudah login
        return $next($request);
    }
}
