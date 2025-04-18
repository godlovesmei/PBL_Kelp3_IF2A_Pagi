<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\DealerAuthController;
use App\Http\Controllers\Dealer\CarController;

// Dealer authentication routes
Route::prefix('dealer')->group(function () {
    // Registration routes
    Route::get('register', [DealerAuthController::class, 'showRegisterForm'])->name('dealer.register');
    Route::post('register', [DealerAuthController::class, 'register'])->name('dealer.register.process');

    // Login routes
    Route::get('login', [DealerAuthController::class, 'showLoginForm'])->name('dealer.login');
    Route::post('login', [DealerAuthController::class, 'login'])->name('dealer.login.process');

    // Logout route
    Route::post('logout', [DealerAuthController::class, 'logout'])->name('dealer.logout');
});

// Routes that require dealer authentication
Route::middleware(['auth:dealer'])->prefix('dealer')->group(function () {
    // Dashboard route
    Route::get('dashboard', [CarController::class, 'dashboard'])->name('dealer.dashboard');

    // CRUD Mobil Routes
    Route::get('mobil', [CarController::class, 'index'])->name('dealer.mobil');
    Route::get('mobil/create', [CarController::class, 'create'])->name('dealer.mobil.create');
    Route::post('mobil', [CarController::class, 'store'])->name('dealer.mobil.store');
    Route::get('mobil/{car}/edit', [CarController::class, 'edit'])->name('dealer.mobil.edit');
    Route::put('mobil/{car}', [CarController::class, 'update'])->name('dealer.mobil.update');
    Route::delete('mobil/{car}', [CarController::class, 'destroy'])->name('dealer.mobil.destroy');
});