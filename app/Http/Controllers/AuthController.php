<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Dealer;
use App\Models\Pelanggan;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menampilkan halaman register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses Login
    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required|in:dealer,pelanggan',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $guard = $request->role === 'dealer' ? 'dealer' : 'pelanggan';

        if (Auth::guard($guard)->attempt($request->only('email', 'password'))) {
            $redirectRoute = $guard === 'dealer' ? 'dealer.dashboard' : 'pelanggan.dashboard';
            return redirect()->route($redirectRoute);
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    // Proses Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    // Proses Registrasi (Hanya untuk Pelanggan)
    public function register(Request $request)
    {
        $request->validate([
            'role' => 'required|in:pelanggan',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:pelanggans,email',
            ],
            'password' => 'required|min:6|confirmed',
        ]);

        if ($request->role === 'pelanggan') {
            Pelanggan::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('login')->with('success', 'Registrasi pelanggan berhasil! Silakan login.');
        }

        return back()->withErrors(['role' => 'Registrasi hanya tersedia untuk pelanggan']);
    }
}
