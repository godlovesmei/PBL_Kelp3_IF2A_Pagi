<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\CarController;
use App\Http\Controllers\Dealer\DashboardController;
use App\Http\Controllers\Dealer\CarController as DealerCarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\SimulatePriceController;
use App\Http\Controllers\User\PurchaseController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// ✅ Halaman publik (dapat diakses tanpa login)
Route::get('/home', [HomeController::class, 'index'])->name('pages.home');
Route::get('/shop', [ShopController::class, 'index'])->name('pages.shop');
Route::get('/about', [AboutController::class, 'index'])->name('pages.about');
Route::get('/contact', [ContactController::class, 'index'])->name('pages.contact');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('pages.wishlist'); // Wishlist tetap bisa dilihat tanpa login
Route::get('/cars/{id}', [ShopController::class, 'show'])->name('pages.cars.show');
Route::get('/transactions', [TransactionController::class, 'index'])->name('pages.user.transactions');
Route::get('simulate-price/{car}', [SimulatePriceController::class, 'simulate']);


// Routes yang memerlukan autentikasi (hanya bisa diakses oleh pengguna yang sudah login)
Route::middleware(['auth'])->group(function () {
    // Menampilkan form pembelian untuk mobil tertentu
    Route::get('/purchase/{carId}', [PurchaseController::class, 'showOrderForm'])->name('purchase.form');

    // Menangani submission form pembelian
    Route::post('/purchase', [PurchaseController::class, 'submit'])->name('purchase.submit');

    // Tambah item ke wishlist
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('pages.wishlist.store');

    // Hapus item dari wishlist
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('pages.wishlist.destroy');
});

// ✅ Rute untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    // Halaman profil (dapat diakses oleh semua pengguna yang login)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('pages.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('pages.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('pages.profile.destroy');
});


// Group routes protected by authentication for dealers
Route::middleware(['auth'])->group(function () {
    
    // Dashboard route
    Route::get('/dashboard', [DealerCarController::class, 'dashboard'])->name('pages.dealer.dashboard');

    // CRUD routes for cars using Route::resource
    Route::resource('products', DealerCarController::class)->names([
        'index' => 'pages.dealer.index',
        'create' => 'pages.dealer.create',
        'store' => 'pages.dealer.store',
        'edit' => 'pages.dealer.edit',
        'update' => 'pages.dealer.update',
        'destroy' => 'pages.dealer.destroy',
    ]);
});

// ✅ Rute fallback untuk user dengan role tidak dikenali
Route::fallback(function () {
    return redirect('/')->with('error', 'Page not found.');
});

// Dealer Order Pages
Route::get('/dealer/order', function () {
    return view('pages.dealer.order');
})->name('dealer.order');

Route::get('/dealer/processing', function () {
    return view('pages.dealer.processing');
})->name('dealer.processing');

Route::get('/dealer/confirm', function () {
    return view('pages.dealer.confirm');
})->name('dealer.confirm');

Route::get('/dealer/shipped', function () {
    return view('pages.dealer.shipped');
})->name('dealer.shipped');

Route::get('/dealer/completed', function () {
    return view('pages.dealer.completed');
})->name('dealer.completed');

// ✅ Rute untuk login/logout
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rute tambahan dari file auth.php
require __DIR__ . '/auth.php';