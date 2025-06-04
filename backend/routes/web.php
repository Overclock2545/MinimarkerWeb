<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Ruta pública para la página de bienvenida (puedes mantenerla o eliminarla)
Route::get('/', function () {
    return view('welcome');
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
