<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
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
    // In app/Providers/AppServiceProvider.php


    public function boot()
    {
        App::setLocale('en'); // Set default locale (e.g., English)
    }

}
