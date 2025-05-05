<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Auth\DealerAuthController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\ShopController;
use App\Http\Controllers\Customer\AboutController;
use App\Http\Controllers\Customer\ContactController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Customer\CarController;
use App\Http\Controllers\Customer\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// ✅ Halaman publik (tanpa login pun bisa akses)
Route::get('/home', [HomeController::class, 'index'])->name('customer.home');
Route::get('/shop', [ShopController::class, 'index'])->name('customer.shop');
Route::get('/about', [AboutController::class, 'index'])->name('customer.about');
Route::get('/contact', [ContactController::class, 'index'])->name('customer.contact');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('customer.wishlist');
Route::get('/customer/cars/{id}', [CarController::class, 'show'])->name('customer.cars.show');

// ✅ Rute untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    // Halaman profil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');
});

// ✅ Rute untuk admin
Route::middleware(['auth', 'verified', 'role:dealer'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dealer.dashboard');
    })->name('dealer.dashboard');
});

require __DIR__.'/auth.php';