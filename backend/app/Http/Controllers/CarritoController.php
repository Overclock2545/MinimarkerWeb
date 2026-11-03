<?php

namespace App\Http\Controllers;

use App\Models\CarritoItem;
use App\Models\Pedido;
use App\Models\PedidoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CarritoController extends Controller
{
    /**
     * Mostrar los productos del carrito del usuario autenticado.
     */
    public function index()
    {
        $user = Auth::user();

        $carrito = CarritoItem::where('user_id', $user->id)
            ->with('product')
            ->get();

        return view('carrito', compact('carrito'));
    }

    /**
     * Agregar un producto al carrito.
     */
    public function add(Request $request, $productId)
    {
        $request->validate(['cantidad' => 'sometimes|integer|min:1|max:10000']);
        \App\Models\Product::findOrFail($productId);
        $user = Auth::user();

        $item = CarritoItem::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($item) {
            $item->cantidad += $request->input('cantidad', 1);
            $item->save();
        } else {
            CarritoItem::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'cantidad' => $request->input('cantidad', 1),
            ]);
        }

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    /**
     * Eliminar un producto del carrito.
     */
    public function remove($id)
    {
        $item = CarritoItem::where('user_id', Auth::id())->findOrFail($id);
        $item->delete();

        return redirect()->back()->with('status', 'Producto eliminado del carrito.');
    }

    /**
     * Aumentar la cantidad de un producto en el carrito.
     */
    public function incrementar($id)
    {
        $item = CarritoItem::where('user_id', Auth::id())->findOrFail($id);
        $item->cantidad += 1;
        $item->save();

        return redirect()->route('carrito');
    }

    /**
     * Disminuir la cantidad de un producto en el carrito.
     */
    public function disminuir($id)
    {
        $item = CarritoItem::where('user_id', Auth::id())->findOrFail($id);

        if ($item->cantidad > 1) {
            $item->cantidad -= 1;
            $item->save();
        } else {
            $item->delete();
        }

        return redirect()->route('carrito');
    }

    /**
     * Confirmar el pedido del carrito y redirigir a WhatsApp.
     */
    public function confirmarPedido()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $carritoItems = $user->carritoItems()->with('product')->get();

        if ($carritoItems->isEmpty()) {
            return redirect()->back()->with('error', 'Tu carrito está vacío.');
        }

        // Validar stock antes de procesar
        foreach ($carritoItems as $item) {
            if (!$item->product || $item->cantidad < 1 || $item->cantidad > $item->product->stock) {
                return redirect()->back()->with('error', 'Producto no disponible o cantidad superior al stock.');
            }
        }


        DB::beginTransaction();
        try {
            // Generar código único
            $codigo = 'PED-' . strtoupper((string) Str::uuid());

            // Calcular total
// Calcular total (considerando precio de oferta si aplica)
$total = $carritoItems->sum(function ($item) {
    $producto = $item->product;
    $precio = $producto->precioActual();

    return $precio * $item->cantidad;
});


            // Crear pedido
            $pedido = Pedido::create([
                'user_id' => $user->id,
                'codigo_pedido' => $codigo,
                'total' => $total,
                'estado' => 'pendiente_pago',
            ]);

            // Crear items del pedido
            $descuentoTotal = 0;

foreach ($carritoItems as $item) {
    $producto = $item->product;
    $cantidad = $item->cantidad;

    $precio_base = $producto->precio;
    $precio_unitario = $producto->precioActual();

    $subtotal = $precio_unitario * $cantidad;

    // Calcular ahorro por producto
    $descuento = ($precio_base - $precio_unitario) * $cantidad;
    $descuentoTotal += max($descuento, 0);

    PedidoItem::create([
        'pedido_id' => $pedido->id,
        'product_id' => $producto->id,
        'cantidad' => $cantidad,
        'precio_unitario' => $precio_unitario,
        'subtotal' => $subtotal,
    ]);
}


            // Vaciar carrito
            $user->carritoItems()->delete();

            DB::commit();

            // Redirección a WhatsApp
            $mensaje = urlencode("Hola, acabo de realizar el pedido {$codigo}. Quisiera coordinar el pago.");
            $urlWhatsApp = "https://wa.me/51944770988?text={$mensaje}"; // Reemplaza con tu número real

            return redirect($urlWhatsApp)->with('success', 'Pedido registrado. Redirigiendo a WhatsApp.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al procesar tu pedido.');
        }
    }
}
