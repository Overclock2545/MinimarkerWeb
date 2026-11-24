<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('b2:crear-admin {email} {--nombre=Administrador}', function (string $email) {
    $email = mb_strtolower(trim($email));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $this->error('Indica un correo válido.'); return 1; }
    if (\App\Models\B2Usuario::where('email', $email)->exists()) { $this->error('La cuenta ya existe; no se ha modificado.'); return 1; }
    $password = $this->secret('Contraseña del administrador (mínimo 10 caracteres)');
    if (!is_string($password) || mb_strlen($password) < 10) { $this->error('La contraseña es demasiado corta.'); return 1; }
    \App\Models\B2Usuario::create(['name' => $this->option('nombre'), 'email' => $email, 'password' => $password, 'rol' => 'admin']);
    $this->info('Administrador creado.');
})->purpose('Crear una cuenta administrativa B2 sin modificar cuentas existentes');
