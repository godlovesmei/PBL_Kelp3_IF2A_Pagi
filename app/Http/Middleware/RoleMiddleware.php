<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Constants\RoleConstant;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, $role)
    {
        // Eager load role untuk menghindari N+1 query
        $user = Auth::user()->load('role');

        // Validasi apakah user memiliki role yang valid berdasarkan RoleConstant
        if ($user && $user->role) {
            // Menangani role dengan ID yang sesuai dengan yang didefinisikan di RoleConstant
            switch (strtoupper($role)) {
                case 'DEALER':
                    $roleId = RoleConstant::DEALER;
                    break;
                case 'CUSTOMER':
                    $roleId = RoleConstant::CUSTOMER;
                    break;
                default:
                    $roleId = null;
            }

            // Periksa apakah role user cocok dengan role yang diminta
            if ($user->role->id === $roleId) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}
