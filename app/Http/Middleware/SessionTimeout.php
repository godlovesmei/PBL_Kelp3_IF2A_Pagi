<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionTimeout
{
    public function handle($request, Closure $next)
    {
        // Cek apakah session sudah terlalu lama
        if (Auth::check()) {
            if (Session::get('last_activity') && time() - Session::get('last_activity') > 60 * 30) {  // Contoh timeout 30 menit
                Auth::logout();
                return redirect('/login')->with('error', 'Session timeout, please log in again.');
            }
            Session::put('last_activity', time());
        }
        
        return $next($request);
    }
}