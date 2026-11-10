<?php

namespace Tests\Feature;

use App\Models\SolicitudCotizacion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CotizacionTest extends TestCase
{
    use RefreshDatabase;

    private function datos(): array
    {
        return [
            'ruc' => '20123456789', 'razon_social' => 'Empresa ficticia',
            'contacto' => 'Contacto ficticio', 'telefono' => '999123456',
            'ofertas' => [
                ['id' => 'conecta-25', 'cantidad' => 2],
                ['id' => 'router-negocio', 'cantidad' => 1],
            ],
        ];
    }

    public function test_registra_recupera_y_conserva_resumen_sin_datos_personales_en_la_url(): void
    {
        $response = $this->post('/cotizacion', $this->datos());
        $response->assertRedirect();
        $url = $response->headers->get('Location');
        $this->assertMatchesRegularExpression('~/propuesta/[a-f0-9]{64}$~', $url);
        $this->assertStringNotContainsString('20123456789', $url);
        $this->assertStringNotContainsString('999123456', $url);
        $solicitud = SolicitudCotizacion::firstOrFail();
        $this->assertSame(7980, (int) $solicitud->total_mensual_centimos);
        $this->assertSame(24900, (int) $solicitud->total_unico_centimos);
        $this->assertSame('web', $solicitud->origen);
        $this->assertNotSame(basename($url), $solicitud->token_hash);
        $this->get($url)->assertOk()->assertSee($solicitud->codigo)->assertSee('Conecta MYPE 25')->assertSee('Router Negocio Wi-Fi')->assertDontSee('20123456789');
        $this->get($url)->assertOk()->assertHeader('Cache-Control', 'no-store, private');
        $this->get('/propuesta/'.str_repeat('a', 64))->assertNotFound();
    }

    public function test_valida_datos_obligatorios_y_cantidades(): void
    {
        $this->get('/cotizacion')->assertOk()->assertSee('Razón social')->assertSee('RUC');
        $this->post('/cotizacion', [])->assertSessionHasErrors(['ruc', 'razon_social', 'contacto', 'telefono', 'ofertas']);
        $datos = $this->datos();
        $datos['ruc'] = '123'; $datos['telefono'] = 'abc'; $datos['ofertas'][0]['cantidad'] = 0;
        $this->post('/cotizacion', $datos)->assertSessionHasErrors(['ruc', 'telefono', 'ofertas.0.cantidad']);
        $datos = $this->datos(); $datos['ofertas'][0]['cantidad'] = 100;
        $this->post('/cotizacion', $datos)->assertSessionHasErrors(['ofertas.0.cantidad']);
        $datos = $this->datos(); $datos['ofertas'][0]['id'] = 'no-existe';
        $this->post('/cotizacion', $datos)->assertSessionHasErrors(['ofertas']);
        $datos = $this->datos(); $datos['ofertas'][1]['id'] = 'conecta-25';
        $this->post('/cotizacion', $datos)->assertSessionHasErrors(['ofertas.0.id', 'ofertas.1.id']);
        $this->assertDatabaseCount('solicitudes_cotizacion', 0);
    }

    public function test_el_servidor_ignora_precios_enviados_por_el_cliente(): void
    {
        $datos = $this->datos(); $datos['ofertas'][0]['precio'] = 0;
        $this->post('/cotizacion', $datos)->assertRedirect();
        $this->assertSame(7980, (int) SolicitudCotizacion::firstOrFail()->total_mensual_centimos);
    }

    public function test_si_falla_el_guardado_conserva_los_campos_y_no_confirma(): void
    {
        DB::shouldReceive('transaction')->once()->andThrow(new \RuntimeException('fallo simulado'));
        $this->from('/cotizacion')->post('/cotizacion', $this->datos())
            ->assertRedirect('/cotizacion')->assertSessionHasErrors('guardado')
            ->assertSessionHasInput('razon_social', 'Empresa ficticia');
    }

    public function test_las_ofertas_sin_precio_muestran_importes_parciales(): void
    {
        $catalogo = config('catalogo_b2'); $catalogo['portabilidad']['ofertas'][0]['precio'] = null;
        config(['catalogo_b2' => $catalogo]);
        $response = $this->post('/cotizacion', $this->datos());
        $this->get($response->headers->get('Location'))->assertOk()->assertSee('Precio por definir')->assertSee('importes mostrados son parciales');
    }
}
