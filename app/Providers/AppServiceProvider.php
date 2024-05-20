<?php

namespace App\Providers;

use App\Providers\Filament\AdminPanelProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //filament
        // $this->app->register(AdminPanelProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //filament
        $this->app->register(AdminPanelProvider::class);
    }
}
