<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

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
    }

    // Other methods...
}

