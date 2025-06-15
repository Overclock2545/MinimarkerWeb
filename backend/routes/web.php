<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Http\Controllers\CarritoController;

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
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar/{product}', [CarritoController::class, 'add'])->name('carrito.agregar');
    Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'remove'])->name('carrito.eliminar');
});

// Rutas de autenticación (login, register, etc.)
require __DIR__ . '/auth.php';
// Ruta para una categoría genérica (se puede duplicar para otras)
Route::get('/categoria-generica', function () {
    $productos = [
        (object)[
            'nombre' => 'Lámpara LED',
            'precio' => 25.50,
            'imagen_url' => 'https://via.placeholder.com/200'
        ],
        (object)[
            'nombre' => 'Organizador de cables',
            'precio' => 12.00,
            'imagen_url' => 'https://via.placeholder.com/200'
        ],
    ];

    return view('categorias.categoria-generica', compact('productos'));
});
