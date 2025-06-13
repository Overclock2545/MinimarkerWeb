<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

// Ruta pública para la página de bienvenida (puedes mantenerla o eliminarla)
Route::get('/', function () {
    return Redirect::to('/inicio');
});

// Ruta pública para la pantalla principal
Route::get('/inicio', function () {
    return view('home'); // resources/views/home.blade.php
})->name('inicio');

// Ruta protegida para el dashboard (si lo usas)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Agrupación de rutas que requieren login
Route::middleware(['auth'])->group(function () {
    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes (login, register, etc.)
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
