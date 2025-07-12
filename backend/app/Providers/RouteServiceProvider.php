<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerificarRol; // Asegúrate de tener este use

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Este valor define el espacio de nombres de los controladores.
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Redirección después del login.
     */
    public const HOME = '/inicio';

    /**
     * Aliases de middlewares personalizados.
     */
    protected $middlewareAliases = [
        'verificarRol' => VerificarRol::class,
    ];

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
