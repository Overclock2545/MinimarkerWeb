<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * Este valor define el espacio de nombres de los controladores.
     * Laravel lo usará para agrupar rutas que usan controladores.
     */
    protected $namespace = 'App\Http\Controllers';
    public const HOME = '/inicio';


    /**
     * Define los bindings de rutas, filtros de patrones y rutas personalizadas.
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Registra las rutas de la aplicación.
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define las rutas API (routes/api.php).
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define las rutas web (routes/web.php).
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }
}
