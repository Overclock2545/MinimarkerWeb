<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


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
        $pedido = Pedido::with(['items.producto', 'usuario'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $pdf = Pdf::loadView('boletas.boleta', compact('pedido'));

        return $pdf->download('boleta_' . $pedido->codigo_pedido . '.pdf');
    }

    // Confirmar el pago (pasa de 'pendiente_pago' → 'en_curso')
public function confirmar($id)
{
    $pedido = Pedido::findOrFail($id);
    $pedido->estado = 'en_curso';
    $pedido->save();

    return redirect()->back()->with('success', 'Pedido confirmado. Ahora está en curso.');
}

// Mostrar pedidos en curso
public function pedidosCurso()
{
    $pedidos = Pedido::where('estado', 'en_curso')->paginate(10);
    return view('admin.pedidos_curso', compact('pedidos'));
}

// Marcar pedido como entregado (pasa de 'en_curso' → 'entregado')
public function entregar($id)
{
    $pedido = Pedido::findOrFail($id);
    $pedido->estado = 'entregado';
    $pedido->save();

    return redirect()->back()->with('success', 'Pedido marcado como entregado.');
}

// Mostrar historial (pedidos entregados)
public function historial()
{
    $pedidos = Pedido::where('estado', 'entregado')->paginate(10);
    return view('admin.pedidos_historial', compact('pedidos'));
}

}
