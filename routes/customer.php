<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\WishlistController;


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

    
// Rute yang membutuhkan login
Route::middleware(['auth.customer'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('customer.profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('customer.profile.update');
    Route::get('/shop/{id}', [ShopController::class, 'show'])->name('customer.cars.show');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('customer.wishlist.store');
});
});

