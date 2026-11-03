<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\Categoria;
use App\Models\LandingPage;


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
    public function boot()
{
                if (app()->environment('production')) {
        URL::forceScheme('https');
    }
        Paginator::useBootstrap();
    // Compartir categorías con todas las vistas automáticamente
    View::composer('*', function ($view) {
        if (!config('app.legacy_minimarket', false) || str_starts_with($view->name(), 'b2.')) {
            return;
        }
        $view->with('categorias', Categoria::all());
        $view->with('landingPage', LandingPage::first());
    });
}
}
