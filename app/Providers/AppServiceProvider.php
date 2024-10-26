<?php

namespace App\Providers;

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\View;
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
        
            $menu = MenuController::createMenu();
            View::composer('*', function ($view) use ($menu) {
                $view->with('menu', $menu);
            });
    }
}
