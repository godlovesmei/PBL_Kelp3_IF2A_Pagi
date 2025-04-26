<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Http\Middleware\AuthenticateCustomer; // Pastikan ini sudah benar

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Menambahkan rute untuk dealer
        Route::middleware('web')
            ->prefix('dealer')
            ->group(base_path('routes/dealer.php'));

        // Mendaftarkan middleware 'auth.customer' untuk routing customer
        Route::middleware(['auth.customer'])->group(function () {
            // Tentukan route yang perlu menggunakan middleware ini
            // Route::get('/profile', [ProfileController::class, 'show']);
            // Route::post('/profile', [ProfileController::class, 'update']);
        });
    }
}


