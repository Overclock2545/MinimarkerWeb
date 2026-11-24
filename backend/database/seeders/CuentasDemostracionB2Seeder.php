<?php

namespace Database\Seeders;

use App\Models\B2Usuario;
use Illuminate\Database\Seeder;

class CuentasDemostracionB2Seeder extends Seeder
{
    public function run(): void
    {
        $admin = getenv('B2_DEMO_ADMIN_PASSWORD');
        $usuario = getenv('B2_DEMO_USER_PASSWORD');
        if (!is_string($admin) || strlen($admin) < 10 || !is_string($usuario) || strlen($usuario) < 10) {
            throw new \RuntimeException('Define B2_DEMO_ADMIN_PASSWORD y B2_DEMO_USER_PASSWORD con al menos 10 caracteres.');
        }
        B2Usuario::firstOrCreate(['email' => 'admin@gmail.com'], ['name' => 'Administrador demo', 'password' => $admin, 'rol' => 'admin']);
        B2Usuario::firstOrCreate(['email' => 'usuario@demo.test'], ['name' => 'Usuario demo', 'password' => $usuario, 'rol' => 'usuario']);
    }
}
