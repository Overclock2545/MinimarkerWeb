<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\ContinuidadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;

Route::withoutMiddleware([StartSession::class, ShareErrorsFromSession::class, ValidateCsrfToken::class])->group(function () {
    Route::get('/', [ProductController::class, 'inicioComercial'])->name('inicio');
    Route::redirect('/inicio', '/');
    Route::get('/catalogo', [ProductController::class, 'catalogoComercial'])->name('catalogo');
    Route::get('/catalogo/{id}', [ProductController::class, 'detalleComercial'])->name('catalogo.detalle');
    Route::get('/producto/{id}', [ProductController::class, 'detalleComercial'])->name('producto.ver');
    Route::redirect('/ofertas', '/catalogo')->name('ofertas.publicas');
    Route::get('/comparar', [ProductController::class, 'compararComercial'])->name('comparar');
    Route::get('/carrito', [CarritoController::class, 'demostracion'])->name('carrito');
});

Route::get('/cotizacion', [CotizacionController::class, 'crear'])->name('cotizacion.crear');
Route::post('/cotizacion', [CotizacionController::class, 'guardar'])->middleware('throttle:10,1')->name('cotizacion.guardar');
Route::get('/propuesta/{token}', [CotizacionController::class, 'propuesta'])->name('cotizacion.propuesta');
Route::post('/propuesta/{token}/contacto', [ContinuidadController::class, 'contacto'])->middleware('throttle:10,1')->name('continuidad.contacto');
Route::post('/propuesta/{token}/encuesta', [ContinuidadController::class, 'encuesta'])->middleware('throttle:10,1')->name('continuidad.encuesta');
Route::get('/referido/{codigo}', [ContinuidadController::class, 'referido'])->name('continuidad.referido');
Route::get('/interno/metricas', [ContinuidadController::class, 'metricas'])->middleware('throttle:10,1')->name('continuidad.metricas');
