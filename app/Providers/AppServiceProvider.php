<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RoleService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services to the container.
     */
    public function register(): void
    {
        // Binding RoleService as a singleton
        $this->app->singleton(RoleService::class, function ($app) {
            return new RoleService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Logic after all services are booted (if needed)
    }
}