<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Banner;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Inyectar el contenido del banner en todas las vistas que usen el header
        View::composer('partials.header', function ($view) {
            $view->with('banner', Banner::first());
        });
    }
}
