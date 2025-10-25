<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // IMPORTANT: Needed for Schema::defaultStringLength(191)
use Illuminate\Pagination\Paginator;  // CRITICAL: Needed for Paginator::useBootstrap()

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        // This method call now works because Paginator is imported above.
        Paginator::useBootstrap(); 
    }
}
