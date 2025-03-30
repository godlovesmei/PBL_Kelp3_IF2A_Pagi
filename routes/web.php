<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\PelangganController;

Route::get('/', function () {
    return view('welcome'); // Menampilkan halaman utama
});

// **AUTHENTICATION ROUTES**
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// Logout (Harus dalam kondisi sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// **DASHBOARD DEALER**
Route::middleware(['auth:dealer'])->group(function () {
    Route::get('/dealer/dashboard', [DealerController::class, 'index'])->name('dealer.dashboard');
    Route::get('/dealer/produk', [DealerController::class, 'produk'])->name('dealer.produk');
    Route::get('/dealer/pesanan', [DealerController::class, 'pesanan'])->name('dealer.pesanan');
    Route::get('/dealer/pelanggan', [DealerController::class, 'pelanggan'])->name('dealer.pelanggan');
});

// **DASHBOARD PELANGGAN (HARUS LOGIN SEBAGAI PELANGGAN)**
Route::middleware(['auth:pelanggan'])->group(function () {
    Route::get('/pelanggan/dashboard', [PelangganController::class, 'dashboard'])->name('pelanggan.dashboard');
});
