<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomerAuthController;

// Customer authentication routes
Route::prefix('customer')->group(function () {
    Route::get('register', [CustomerAuthController::class, 'showRegisterForm'])->name('customer.register');
    Route::post('register', [CustomerAuthController::class, 'register'])->name('customer.register.process');

    Route::get('login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');
    Route::post('login', [CustomerAuthController::class, 'login'])->name('customer.login.process');
    Route::post('logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

    Route::get('dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');
});
