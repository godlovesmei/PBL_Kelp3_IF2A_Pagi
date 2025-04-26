<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;


class CustomerAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register', ['role' => 'customer']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:customers,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Customer::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('customer.login')->with('success', 'Registration successful!');
    }

    public function showLoginForm()
    {
        return view('auth.login', ['role' => 'customer']);
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    if (Auth::guard('customer')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('customer.home'); // atau 'customer.home' kalau mau ke /home
    }

    return back()->with('error', 'Invalid email or password');
}

public function logout(Request $request)
{
    Auth::guard('customer')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('customer.login');
}

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password', ['role' => 'customer']);
    }

    public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $status = Password::broker('customers')->sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', __($status)) // <<<<< INI DIA
        : back()->withErrors(['email' => __($status)]);
}

    public function showResetForm(Request $request, $token = null)
{
    return view('auth.reset-password', [
        'token' => $token,
        'email' => $request->email,
        'role' => 'customer'
    ]);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $status = Password::broker('customers')->reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($customer, $password) {
            $customer->password = Hash::make($password);
            $customer->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('customer.login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
}


}