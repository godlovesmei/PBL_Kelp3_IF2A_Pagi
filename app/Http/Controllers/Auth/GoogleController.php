<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // 1. Arahkan user ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Handle callback dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah email sudah pernah digunakan
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Jika belum, buat user baru
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt(Str::random(16)), // password acak
                ]);
            }

            // Login user
            Auth::login($user);

            // Redirect ke halaman home/dashboard
            return redirect()->intended('/home');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['google_error' => 'Login with Google failed.']);
        }
    }
}

