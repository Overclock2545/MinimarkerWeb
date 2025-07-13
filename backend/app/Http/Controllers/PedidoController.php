<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;

class PedidoController extends Controller
{
    public function misPedidos()
    {
        $pedidos = Pedido::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pedidos', compact('pedidos'));
    }

    public function descargarBoleta($id)
    {
        $pedido = Pedido::with(['items.product', 'usuario'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Validar estado del pedido
        if (!in_array($pedido->estado, ['en_curso', 'entregado'])) {
            return redirect()->back()->with('error', 'Este pedido aún no puede generar boleta.');
        }

        // Calcular descuento total
        $descuentoTotal = $pedido->items->sum(function ($item) {
            $producto = $item->product;
            $precio_base = $producto->precio;
            $precio_unitario = $item->precio_unitario;

            return max($precio_base - $precio_unitario, 0) * $item->cantidad;
        });

        // Generar boleta PDF
        $pdf = Pdf::loadView('boletas.boleta', compact('pedido', 'descuentoTotal'))->setPaper('A4');

        return $pdf->download('boleta_' . $pedido->codigo_pedido . '.pdf');
    }

    public function confirmar($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->estado = 'en_curso';
        $pedido->save();

        return redirect()->back()->with('success', 'Pedido confirmado. Ahora está en curso.');
    }

    public function pedidosCurso()
    {
        $pedidos = Pedido::where('estado', 'en_curso')->paginate(10);
        return view('admin.pedidos_curso', compact('pedidos'));
    }

    public function entregar($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->estado = 'entregado';
        $pedido->save();

        return redirect()->back()->with('success', 'Pedido marcado como entregado.');
    }

    public function historial()
    {
        $pedidos = Pedido::where('estado', 'entregado')->paginate(10);
        return view('admin.pedidos_historial', compact('pedidos'));
    }
}
