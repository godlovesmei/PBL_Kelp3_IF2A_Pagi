<?php

// DealerAuthController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Dealer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DealerAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register', ['role' => 'dealer']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:dealers,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Dealer::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('dealer.dashboard')->with('success', 'Registration successful!');
    }

    public function showLoginForm()
    {
        return view('auth.login', ['role' => 'dealer']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::guard('dealer')->attempt($credentials)) {
            return redirect()->route('dealer.dashboard');
        }

        return back()->with('error', 'Invalid email or password');
    }

    public function logout()
    {
        Auth::guard('dealer')->logout();
        return redirect()->route('dealer.login');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password', ['role' => 'dealer']);
    }

}
