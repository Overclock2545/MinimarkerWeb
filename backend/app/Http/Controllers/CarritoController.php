<?php

namespace App\Http\Controllers;

use App\Models\CarritoItem;
use App\Models\Pedido;
use App\Models\PedidoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $item = CarritoItem::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('status', 'Producto eliminado del carrito.');
    }

    /**
     * Aumentar la cantidad de un producto en el carrito.
     */
    public function incrementar($id)
    {
        $item = CarritoItem::findOrFail($id);
        $item->cantidad += 1;
        $item->save();

        return redirect()->route('carrito');
    }

    /**
     * Disminuir la cantidad de un producto en el carrito.
     */
    public function disminuir($id)
    {
        $item = CarritoItem::findOrFail($id);

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
            if ($item->cantidad > $item->product->stock) {
                return redirect()->back()->with('error', 'No hay suficiente stock para el producto: ' . $item->product->nombre);
            }
        }


        DB::beginTransaction();
        try {
            // Generar código único
            $ultimoPedidoId = Pedido::max('id') ?? 0;
            $codigo = 'PED-' . str_pad($ultimoPedidoId + 1, 5, '0', STR_PAD_LEFT);

            // Calcular total
            $total = $carritoItems->sum(function ($item) {
                return $item->product->precio * $item->cantidad;
            });

            // Crear pedido
            $pedido = Pedido::create([
                'user_id' => $user->id,
                'codigo_pedido' => $codigo,
                'total' => $total,
                'estado' => 'pendiente_pago',
            ]);

            // Crear items del pedido
            foreach ($carritoItems as $item) {
                $precio = $item->product->precio;
                $cantidad = $item->cantidad;
                $subtotal = $precio * $cantidad;

                PedidoItem::create([
                    'pedido_id' => $pedido->id,
                    'product_id' => $item->product->id,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->product->precio,
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
