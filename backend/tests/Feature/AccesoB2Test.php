<?php

namespace Tests\Feature;

use App\Models\B2Usuario;
use Database\Seeders\DatosDemostracionB2Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AccesoB2Test extends TestCase
{
    use RefreshDatabase;

    public function test_sesion_antigua_no_consulta_la_tabla_de_usuarios_anteriores(): void
    {
        \Illuminate\Support\Facades\Schema::dropIfExists('users');
        $claveSesionAnterior = auth('web')->getName();
        $this->withSession([$claveSesionAnterior => 1])
            ->post('/acceso', ['email' => 'nadie@example.test', 'password' => 'incorrecta'])
            ->assertSessionHasErrors('email');
    }

    public function test_registro_crea_usuario_sin_permisos_de_administracion(): void
    {
        $this->post('/crear-cuenta', ['name' => 'Cliente demo', 'email' => 'cliente@example.test', 'password' => 'clave-segura-123', 'password_confirmation' => 'clave-segura-123', 'rol' => 'admin'])->assertRedirect('/');
        $this->assertDatabaseHas('b2_usuarios', ['email' => 'cliente@example.test', 'rol' => 'usuario']);
        $this->get('/')->assertSee('Cliente demo')->assertDontSee('>Métricas</a>', false);
        $this->get('/interno/metricas')->assertForbidden();
    }

    public function test_admin_puede_entrar_y_cerrar_sesion(): void
    {
        B2Usuario::create(['name' => 'Admin demo', 'email' => 'admin@example.test', 'password' => 'clave-segura-123', 'rol' => 'admin']);
        $this->post('/acceso', ['email' => 'admin@example.test', 'password' => 'clave-incorrecta'])->assertSessionHasErrors('email');
        $this->post('/acceso', ['email' => 'admin@example.test', 'password' => 'clave-segura-123'])->assertRedirect('/interno/metricas');
        $this->get('/interno/metricas')->assertOk()->assertSee('Métricas del');
        $this->post('/salir')->assertRedirect('/');
        $this->assertGuest('b2');
    }

    public function test_datos_demo_son_repetibles_y_marcados(): void
    {
        $this->seed(DatosDemostracionB2Seeder::class);
        $this->seed(DatosDemostracionB2Seeder::class);
        $this->assertSame(240, DB::table('solicitudes_cotizacion')->where('codigo', 'like', 'B2-DEMO-%')->count());
        $this->assertSame(60, DB::table('solicitudes_cotizacion')->where('origen', 'referido')->count());
        $this->assertSame(160, DB::table('encuestas_demo')->count());
        $this->assertSame(80, DB::table('solicitudes_contacto_demo')->count());
    }
}
