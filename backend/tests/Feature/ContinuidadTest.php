<?php

namespace Tests\Feature;

use App\Models\SolicitudCotizacion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContinuidadTest extends TestCase
{
    use RefreshDatabase;

    private function crearSolicitud(array $extra = []): string
    {
        $data = array_merge([
            'ruc' => '20123456789', 'razon_social' => 'Empresa ficticia', 'contacto' => 'Persona ficticia',
            'telefono' => '999123456', 'ofertas' => [['id' => 'conecta-25', 'cantidad' => 2]],
        ], $extra);
        return $this->post('/cotizacion', $data)->headers->get('Location');
    }

    public function test_propuesta_recuperable_y_whatsapp_contiene_codigo_y_ofertas_sin_datos_personales(): void
    {
        config(['continuidad.whatsapp' => '51974368162']);
        $url = $this->crearSolicitud();
        $solicitud = SolicitudCotizacion::firstOrFail();
        $this->flushSession();
        $response = $this->get($url)->assertOk()->assertSee('Abrir WhatsApp')->assertSee('Prefiero una llamada')->assertSee('Guarda tu enlace privado')->assertSee('Copiar enlace')->assertSee($solicitud->codigo);
        $html = html_entity_decode($response->getContent());
        $this->assertStringContainsString('https://wa.me/51974368162?text=', $html);
        $this->assertStringContainsString(rawurlencode($solicitud->codigo), $html);
        $this->assertStringContainsString(rawurlencode('Conecta MYPE 25 x 2'), $html);
        $this->assertStringNotContainsString('999123456', $html);
        $this->assertStringNotContainsString('20123456789', $html);
    }

    public function test_contacto_y_encuesta_se_registran_sin_enviar_mensajes(): void
    {
        $url = $this->crearSolicitud();
        $this->from($url)->post($url.'/contacto', ['preferencia' => 'llamada'])->assertRedirect($url)->assertSessionHas('contacto_exito');
        $this->assertDatabaseHas('solicitudes_contacto_demo', ['preferencia' => 'llamada', 'procedencia' => 'enlace_propuesta']);
        $this->from($url)->post($url.'/encuesta', ['valoracion' => 5, 'comentario' => 'Fácil'])->assertSessionHas('encuesta_exito');
        $fechaOriginal = \Illuminate\Support\Facades\DB::table('encuestas_demo')->value('created_at');
        $this->travel(1)->day();
        $this->post($url.'/encuesta', ['valoracion' => 2])->assertRedirect();
        $this->assertDatabaseCount('encuestas_demo', 1);
        $this->assertDatabaseHas('encuestas_demo', ['valoracion' => 2]);
        $this->assertSame($fechaOriginal, \Illuminate\Support\Facades\DB::table('encuestas_demo')->value('created_at'));
        $this->post($url.'/encuesta', ['valoracion' => 7])->assertSessionHasErrors('valoracion');
        $this->post('/propuesta/'.str_repeat('a', 64).'/contacto', ['preferencia' => 'llamada'])->assertNotFound();
    }

    public function test_un_referido_registra_la_procedencia_y_vinculo(): void
    {
        $this->crearSolicitud();
        $origen = SolicitudCotizacion::firstOrFail();
        $this->get('/referido/'.$origen->codigo_referido)->assertOk()->assertSee('REFERENCIA DE DEMOSTRACIÓN');
        $this->crearSolicitud(['referido' => $origen->codigo_referido]);
        $this->assertDatabaseHas('solicitudes_cotizacion', ['origen' => 'referido', 'referido_por_id' => $origen->id]);
        $this->get('/referido/'.str_repeat('0', 32))->assertNotFound();
    }

    public function test_una_propuesta_previa_obtiene_referencia_al_consultarse(): void
    {
        $url = $this->crearSolicitud();
        $solicitud = SolicitudCotizacion::firstOrFail();
        $solicitud->update(['codigo_referido' => null]);
        $this->get($url)->assertOk()->assertSee('Enlace de referido');
        $this->assertNotNull($solicitud->fresh()->codigo_referido);
    }

    public function test_metricas_exigen_clave_y_muestran_solo_datos_agregados(): void
    {
        config(['continuidad.metricas_clave' => 'clave-de-prueba-larga']);
        $this->crearSolicitud();
        $this->get('/interno/metricas')->assertUnauthorized();
        $this->withBasicAuth('admin', 'clave-incorrecta')->get('/interno/metricas')->assertUnauthorized();
        $this->withBasicAuth('admin', 'clave-de-prueba-larga')->get('/interno/metricas')
            ->assertOk()->assertSee('Solicitudes por origen')->assertSee('Portabilidad')->assertDontSee('20123456789')->assertDontSee('999123456');
    }

    public function test_metricas_permanecen_cerradas_sin_configuracion(): void
    {
        config(['continuidad.metricas_clave' => null]);
        $this->get('/interno/metricas')->assertStatus(503);
    }

    public function test_referido_invalido_no_registra_solicitud(): void
    {
        $this->from('/cotizacion')->post('/cotizacion', [
            'ruc' => '20123456789', 'razon_social' => 'Empresa ficticia', 'contacto' => 'Persona ficticia',
            'telefono' => '999123456', 'ofertas' => [['id' => 'conecta-25', 'cantidad' => 1]],
            'referido' => str_repeat('f', 32),
        ])->assertSessionHasErrors('referido');
        $this->assertDatabaseCount('solicitudes_cotizacion', 0);
    }
}
