<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\CarritoItem;
use App\Models\Pedido;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeguridadYStockTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_usuario_no_puede_modificar_el_carrito_de_otro(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $category = Categoria::create(['nombre' => 'Alimentos']);
        $product = Product::forceCreate(['id' => 'ABC123', 'nombre' => 'Producto', 'categoria_id' => $category->id, 'precio' => 5, 'stock' => 3]);
        $item = CarritoItem::create(['user_id' => $owner->id, 'product_id' => $product->id, 'cantidad' => 1]);

        $this->actingAs($other)->post('/carrito/eliminar/'.$item->id)->assertNotFound();
        $this->assertDatabaseHas('carrito_items', ['id' => $item->id]);
    }

    public function test_confirmar_pedido_descontara_stock_una_sola_vez(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        $buyer = User::factory()->create();
        $category = Categoria::create(['nombre' => 'Alimentos']);
        $product = Product::forceCreate(['id' => 'ABC123', 'nombre' => 'Producto', 'categoria_id' => $category->id, 'precio' => 5, 'stock' => 3]);
        $order = Pedido::create(['user_id' => $buyer->id, 'codigo_pedido' => 'PED-TEST', 'total' => 10, 'estado' => 'pendiente_pago']);
        $order->items()->create(['product_id' => $product->id, 'cantidad' => 2, 'precio_unitario' => 5, 'subtotal' => 10]);

        $this->actingAs($admin)->post('/admin/pedido/confirmar/'.$order->id);
        $this->actingAs($admin)->post('/admin/pedido/confirmar/'.$order->id);
        $this->assertSame(1, $product->fresh()->stock);
        $this->assertSame('en_curso', $order->fresh()->estado);
    }

    public function test_solo_se_aplican_ofertas_activas_y_vigentes(): void
    {
        $buyer = User::factory()->create();
        $category = Categoria::create(['nombre' => 'Alimentos']);
        $product = Product::forceCreate(['id' => 'ABC123', 'nombre' => 'Producto', 'categoria_id' => $category->id, 'precio' => 10, 'stock' => 5, 'precio_oferta' => 5, 'oferta_activa' => false]);
        CarritoItem::create(['user_id' => $buyer->id, 'product_id' => $product->id, 'cantidad' => 1]);

        $this->actingAs($buyer)->post('/carrito/confirmar')->assertRedirect();
        $this->assertDatabaseHas('pedidos', ['user_id' => $buyer->id, 'total' => 10]);
        $product->update(['oferta_activa' => true, 'fecha_fin_oferta' => today()->subDay()]);
        $this->assertFalse($product->fresh()->tieneOferta());
        $product->update(['fecha_fin_oferta' => today()]);
        $this->assertTrue($product->fresh()->tieneOferta());
    }

    public function test_un_cliente_no_puede_descargar_la_boleta_de_otro(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $order = Pedido::create(['user_id' => $owner->id, 'codigo_pedido' => 'PED-TEST', 'total' => 10, 'estado' => 'en_curso']);
        $this->actingAs($other)->get('/boleta/'.$order->id)->assertNotFound();
    }
}
