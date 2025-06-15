<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
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
        // View composer untuk kirim notifikasi ke semua view
        View::composer('partials.navbar', function ($view) {
            if (auth()->check()) {
                $user = auth()->user();
                // Ambil semua notifikasi (read & unread, limit 20 misal)
                $notifications = $user->notifications()->latest()->limit(20)->get();
                // Hitung unread
                $unreadCount = $notifications->whereNull('read_at')->count();
            } else {
                $notifications = collect();
                $unreadCount = 0;
            }

            $view->with([
                'notifications' => $notifications,
                'unreadCount' => $unreadCount
            ]);
        });
    }
}
