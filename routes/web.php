<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Auth\DealerAuthController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\ShopController;
use App\Http\Controllers\Customer\AboutController;
use App\Http\Controllers\Customer\ContactController;


Route::get('/home', [HomeController::class, 'index'])->name('customer.home');
Route::get('/shop', [ShopController::class, 'index'])->name('customer.shop');
Route::get('/about', [AboutController::class, 'index'])->name('customer.about');
Route::get('/contact', [ContactController::class, 'index'])->name('customer.contact');

// Memanggil route tambahan
require __DIR__.'/customer.php';
require __DIR__.'/dealer.php';

// Customer Forgot Password
Route::get('customer/forgot-password', [CustomerAuthController::class, 'showForgotPasswordForm'])->name('customer.password.request');
Route::post('customer/forgot-password', [CustomerAuthController::class, 'sendResetLink'])->name('customer.password.email');

// Dealer Forgot Password
Route::get('dealer/forgot-password', [DealerAuthController::class, 'showLinkRequestForm'])->name('dealer.password.request');
Route::post('dealer/forgot-password', [DealerAuthController::class, 'sendResetLinkEmail'])->name('dealer.password.email');

// Customer Reset Password
Route::get('customer/reset-password/{token}', [CustomerAuthController::class, 'showResetForm'])->name('customer.password.reset');
Route::post('customer/reset-password', [CustomerAuthController::class, 'resetPassword'])->name('customer.password.update');