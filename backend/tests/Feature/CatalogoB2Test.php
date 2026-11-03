<?php

namespace Tests\Feature;

use Tests\TestCase;

class CatalogoB2Test extends TestCase
{
    public function test_recorrido_de_demostracion(): void
    {
        $this->get('/')->assertOk()->assertSee('B2 Solutions')->assertSee('Explorar catálogo');
        $this->get('/catalogo')->assertOk()->assertSee('Conecta MYPE 25')->assertSee('Internet Negocio 600')->assertSee('Router Negocio Wi-Fi');
        $this->get('/catalogo?categoria=internet')->assertOk()->assertSee('Internet Negocio 150')->assertDontSee('Conecta MYPE 25');
        $this->get('/catalogo/conecta-25')->assertOk()->assertSee('25 GB')->assertSee('INFORMACIÓN DE DEMOSTRACIÓN', false);
        $this->get('/comparar')->assertOk()->assertSee('Aún no hay opciones seleccionadas');
        $this->get('/carrito')->assertOk()->assertSee('Tu carrito está vacío')->assertSee('Carrito de demostración');
        $this->get('/catalogo/no-existe')->assertNotFound();
        $this->get('/catalogo?categoria=no-existe')->assertNotFound();
        $this->post('/carrito/confirmar')->assertNotFound();
        $this->get('/inicio')->assertRedirect('/');
        $this->get('/ofertas')->assertRedirect('/catalogo');
        $this->get('/producto/conecta-25')->assertOk()->assertSee('Conecta MYPE 25');
    }

    public function test_todas_las_ofertas_tienen_detalle_y_datos_de_comparacion(): void
    {
        $categorias = config('catalogo_b2');
        $this->assertCount(3, $categorias);
        foreach ($categorias as $categoria) {
            $this->assertCount(3, $categoria['ofertas']);
            foreach ($categoria['ofertas'] as $oferta) {
                $this->assertCount(3, $oferta['valores']);
                $this->get('/catalogo/'.$oferta['id'])->assertOk()->assertSee($oferta['nombre']);
            }
        }
    }
}
