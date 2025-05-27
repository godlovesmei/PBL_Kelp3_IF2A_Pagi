<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Constants\RoleConstant;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user using the custom LoginRequest
        $request->authenticate();

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Get the role_id of the authenticated user
        $roleId = Auth::user()->role_id;

        // Redirect based on role_id
        switch ($roleId) {
            case RoleConstant::DEALER:
                session()->flash('status', 'Welcome, Dealer!'); // Flash success message
                return redirect()->route('pages.dealer.dashboard');

            case RoleConstant::CUSTOMER:
                session()->flash('status', 'You have successfully logged in.'); // Flash success message
                return redirect()->route('pages.home');

            default:
                // Logout the user and redirect to login with an error message
                Auth::logout();
                session()->flash('error', 'Unauthorized access!');
                return redirect()->route('login');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Logout the user
        Auth::guard('web')->logout();

        // Invalidate the session to clear all session data
        $request->session()->invalidate();

        // Regenerate the CSRF token to ensure security
        $request->session()->regenerateToken();

        // Redirect to the login page
        return redirect()->route('login');
    }
}