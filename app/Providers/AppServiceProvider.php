<?php

namespace App\Providers;

use App\Services\HolidayService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(HolidayService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('MANAGEMENT', function ($user) {
            return $user->role === 'MANAGEMENT';
        });

        Gate::define('OPERATOR', function ($user) {
            return $user->role === 'OPERATOR';
        });

        Gate::define('ADMIN', function ($user) {
            return $user->role === 'ADMIN';
        });
    }
}
