<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Constants\RoleConstant;

class AuthenticateCustomer
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
    if (Auth::check()) {
        if (Auth::user()->role_id == RoleConstant::CUSTOMER) {
            return $next($request);
        }

        \Log::info('User does not have customer role.', [
            'user_id' => Auth::user()->id,
            'role_id' => Auth::user()->role_id,
        ]);
    } else {
        \Log::info('User is not authenticated.');
    }

    // Redirect jika pengguna bukan customer
    return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
}
}