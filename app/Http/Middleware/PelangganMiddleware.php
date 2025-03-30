<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PelangganMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('pelanggan')->check()) {
            return redirect()->route('pelanggan.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
