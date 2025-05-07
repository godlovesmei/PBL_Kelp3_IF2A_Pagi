<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Auth\DealerAuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\ShopController;
use App\Http\Controllers\Customer\AboutController;
use App\Http\Controllers\Customer\ContactController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Customer\CarController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Dealer\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// ✅ Halaman publik (tanpa login pun bisa akses)
Route::get('/home', [HomeController::class, 'index'])->name('pages.home');
Route::get('/shop', [ShopController::class, 'index'])->name('pages.shop');
Route::get('/about', [AboutController::class, 'index'])->name('pages.about');
Route::get('/contact', [ContactController::class, 'index'])->name('pages.contact');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('pages.wishlist');
Route::get('/cars/{id}', [ShopController::class, 'show'])->name('pages.cars.show');

// ✅ Rute untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    // Halaman profil (dapat diakses oleh semua pengguna yang login)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard default (untuk fallback jika role tidak terdeteksi)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');
});

// Route untuk dealer dashboard
Route::middleware(['auth', 'role:dealer'])->group(function () {
    Route::get('dealer/dashboard', function () {
        return view('dealer.dashboard');
    })->name('dealer.dashboard');
});



// ✅ Rute untuk login/logout
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__ . '/auth.php';