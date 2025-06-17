<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductController; 

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
});

require __DIR__ . '/auth.php';

Route::get('/categorias/id/{id}', [CategoriaController::class, 'mostrarPorId'])->name('categorias.porId');

Route::get('/producto/{id}', [ProductController::class, 'mostrar'])->name('producto.ver');

Route::get('/buscar', [ProductController::class, 'buscar'])->name('buscar.productos');
