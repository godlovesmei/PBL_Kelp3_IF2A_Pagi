<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Constants\RoleConstant;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Usage: middleware(RoleMiddleware::class . ':dealer')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        // Cek berdasarkan method hasRole() di model User
        if (method_exists($user, 'hasRole') && $user->hasRole($role)) {
            return $next($request);
        }

        // Fallback: cek berdasarkan role_id dari RoleConstant
        $roleId = match (strtolower($role)) {
            'dealer' => RoleConstant::DEALER,
            'customer' => RoleConstant::CUSTOMER,
            default => null,
        };

        if ($roleId && $user->role_id == $roleId) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
