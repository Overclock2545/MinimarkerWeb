<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

use App\Http\Middleware\EsAdmin;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// Redirección desde "/" a "/inicio"
Route::get('/', fn() => Redirect::to('/inicio'));

// Vista de inicio con productos
Route::get('/inicio', function () {
    $products = Product::with('categoria')->get();
    return view('home', compact('products'));
})->name('inicio');

// Vista de un producto individual
Route::get('/producto/{id}', [ProductController::class, 'mostrar'])->name('producto.ver');

// Búsqueda de productos
Route::get('/buscar', [ProductController::class, 'buscar'])->name('buscar.productos');

// Categorías por ID
Route::get('/categorias/id/{id}', [CategoriaController::class, 'mostrarPorId'])->name('categorias.porId');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas por Inicio de Sesión
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Carrito de compras
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/agregar/{product}', [CarritoController::class, 'add'])->name('carrito.agregar');
    Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'remove'])->name('carrito.eliminar');
    Route::post('/carrito/incrementar/{id}', [CarritoController::class, 'incrementar'])->name('carrito.incrementar');
    Route::post('/carrito/disminuir/{id}', [CarritoController::class, 'disminuir'])->name('carrito.disminuir');

    // Favoritos
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos');
    Route::post('/favoritos/agregar/{productId}', [FavoritoController::class, 'agregar'])->name('favoritos.agregar');
    Route::delete('/favoritos/eliminar/{product_id}', [FavoritoController::class, 'eliminar'])->name('favoritos.eliminar');
});

/*
|--------------------------------------------------------------------------
| Rutas para Administradores
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', EsAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.panel');
    Route::post('/admin/stock/agregar', [AdminController::class, 'agregarStock'])->name('admin.agregar.stock');
});

/*
|--------------------------------------------------------------------------
| Autenticación (Fortify / Breeze / Jetstream)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

// Dashboard (solo si usas Jetstream con verificación de correo)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
