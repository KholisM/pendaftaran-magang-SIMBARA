<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LamaranService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LamaranService::class, function ($app) {
            return new LamaranService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
