<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;

// Ruta principal del sistema que carga los productos
Route::get('/inicio', function () {
    $products = Product::with('categoria')->get();
    return view('home', compact('products'));
})->name('inicio');

// Redirecciona la raíz al inicio
Route::get('/', function () {
    return Redirect::to('/inicio');
});

// Ruta protegida para el dashboard (opcional)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de autenticación (login, register, etc.)
require __DIR__ . '/auth.php';
use App\Http\Controllers\CategoriaController;

Route::get('/categorias/id/{id}', [CategoriaController::class, 'mostrarPorId'])->name('categorias.porId');
//
use App\Http\Controllers\ProductController;

Route::get('/producto/{id}', [ProductController::class, 'mostrar'])->name('producto.ver');
