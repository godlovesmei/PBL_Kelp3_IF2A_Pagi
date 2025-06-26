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
use App\Http\Controllers\User\SimulatePriceController;
use App\Http\Controllers\User\PurchaseController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\Dealer\OrderTrackingController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Dealer\BrochureController as DealerBrochureController;
use App\Http\Controllers\User\BrochureController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Dealer\AnalyticsController;
use App\Http\Controllers\Dealer\SalesController;
use App\Http\Controllers\Dealer\InstallmentTrackingController;
use App\Http\Controllers\Dealer\PaymentTrackingController;

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
Route::get('/brochures', [BrochureController::class, 'index'])->name('pages.brochure.index');


// Middleware gabungan untuk customer yang sudah login
Route::middleware(['auth', RoleMiddleware::class . ':customer'])->group(function () {

    // Form pembelian mobil
    Route::get('/purchase/{carId}', [PurchaseController::class, 'showOrderForm'])->name('purchase.form');

    // Submit form pembelian
    Route::post('/purchase', [PurchaseController::class, 'submit'])->name('purchase.submit');

    // Wishlist routes
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('pages.wishlist.store');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('pages.wishlist.destroy');

// Order routes — note naming konsisten 'user.orders'
Route::prefix('my-orders')->name('user.orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');

    // Upload bukti pembayaran
    Route::post('/upload-cash', [OrderController::class, 'uploadCash'])->name('uploadCash');
    Route::post('/upload-dp', [OrderController::class, 'uploadDP'])->name('uploadDP');
    Route::post('/upload-installment', [OrderController::class, 'uploadInstallment'])->name('uploadInstallment');
    Route::get('/{order_id}/invoice', [OrderController::class, 'downloadInvoice'])->name('downloadInvoice');
});
});



// ✅ Rute untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    // Halaman profil (dapat diakses oleh semua pengguna yang login)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('pages.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('pages.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('pages.profile.destroy');

    // Rute untuk notifikasi
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read.all');
    Route::get('/notifications/read-and-redirect/{id}', [NotificationController::class, 'readAndRedirect'])->name('notifications.readAndRedirect');
});

// Group routes protected by authentication for dealers
Route::middleware(['auth', RoleMiddleware::class . ':dealer'])->group(function () {
    // Dashboard dealer
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('pages.dealer.dashboard');
    // Analytics dealer
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('pages.dealer.analytics');
    // Rute untuk melacak cicilan
    Route::get('/installments', [InstallmentTrackingController::class, 'index'])->name('pages.dealer.installments');
    // Rute untuk melacak pembayaran
    Route::get('/payments', [PaymentTrackingController::class, 'index'])->name('pages.dealer.payments');
    // Rute untuk melihat penjualan
    Route::get('/sales', [SalesController::class, 'index'])->name('pages.dealer.sales');

    // CRUD mobil untuk dealer
    Route::resource('car', DealerCarController::class)->names([
        'index'   => 'pages.dealer.index',
        'create'  => 'pages.dealer.create',
        'store'   => 'pages.dealer.store',
        'edit'    => 'pages.dealer.edit',
        'update'  => 'pages.dealer.update',
        'destroy' => 'pages.dealer.destroy',
    ]);

    // Brosur dealer
    Route::resource('brochure', DealerBrochureController::class)->names([
        'index'   => 'pages.dealer.brochure.index',
        'create'  => 'pages.dealer.brochure.create',
        'store'   => 'pages.dealer.brochure.store',
        'edit'    => 'pages.dealer.brochure.edit',
        'update'  => 'pages.dealer.brochure.update',
        'destroy' => 'pages.dealer.brochure.destroy',
    ]);

    // Pesanan dealer
    Route::get('/orders', [OrderTrackingController::class, 'index'])->name('pages.dealer.order-index');
    Route::get('/orders/{order}', [OrderTrackingController::class, 'show'])->name('pages.dealer.order-show');
    Route::get('/orders/filter/{status}', [OrderTrackingController::class, 'filter'])->name('pages.dealer.order-filter');
    Route::post('/orders/{order}/update', [OrderTrackingController::class, 'updateStatus'])->name('pages.dealer.order-update');
});

// ✅ Rute fallback untuk user dengan role tidak dikenali
Route::fallback(function () {
    return redirect('/')->with('error', 'Page not found.');
});


// ✅ Rute untuk login/logout
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rute tambahan dari file auth.php
require __DIR__ . '/auth.php';
