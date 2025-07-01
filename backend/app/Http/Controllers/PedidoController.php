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
}
