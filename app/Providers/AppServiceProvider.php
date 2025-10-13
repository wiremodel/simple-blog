<?php

namespace App\Providers;

use App\CustomLoginResponse;
use Filament\Auth\Http\Responses\LoginResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(LoginResponse::class, CustomLoginResponse::class);
    }
}
