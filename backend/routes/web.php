<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\FavoritoController;
use App\Http\Middleware\EsAdmin;
use App\Http\Controllers\AdminController;



Route::get('/inicio', function () {
    $products = Product::with('categoria')->get();
    return view('home', compact('products'));
})->name('inicio');

Route::get('/', function () {
    return Redirect::to('/inicio');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/agregar/{product}', [CarritoController::class, 'add'])->name('carrito.agregar');
    Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'remove'])->name('carrito.eliminar');
    Route::post('/carrito/incrementar/{id}', [CarritoController::class, 'incrementar'])->name('carrito.incrementar');
    Route::post('/carrito/disminuir/{id}', [CarritoController::class, 'disminuir'])->name('carrito.disminuir');
    Route::post('/favoritos/toggle/{productId}', [FavoritoController::class, 'toggle'])->name('favoritos.toggle');
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.index');
});


Route::middleware(['auth', EsAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.panel');
    Route::post('/admin/stock/agregar', [AdminController::class, 'agregarStock'])->name('admin.agregar.stock');
    // etc.
});



require __DIR__ . '/auth.php';

Route::get('/categorias/id/{id}', [CategoriaController::class, 'mostrarPorId'])->name('categorias.porId');

Route::get('/producto/{id}', [ProductController::class, 'mostrar'])->name('producto.ver');

Route::get('/buscar', [ProductController::class, 'buscar'])->name('buscar.productos');
