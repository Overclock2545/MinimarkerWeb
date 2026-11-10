<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CotizacionController;
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
