<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Constants\RoleConstant;  // Pastikan RoleConstant sudah di-import

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Cek apakah pengguna sudah login
        if (Auth::check()) {
            $user = Auth::user();

            // Bandingkan role user dengan role yang diberikan
            if ($user->role_id != constant("App\Constants\RoleConstant::" . strtoupper($role))) {
                // Jika role tidak sesuai, redirect ke halaman home dengan pesan error
                return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        } else {
            // Jika pengguna belum login, arahkan ke halaman login
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);  // Jika semua pemeriksaan lolos, lanjutkan ke request
    }
}