<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if (!in_array($pedido->estado, ['en_curso', 'entregado'])) {
            return redirect()->back()->with('error', 'Este pedido aún no puede generar boleta.');
        }

        $descuentoTotal = $pedido->items->sum(function ($item) {
            $producto = $item->product;
            $precio_base = $producto->precio;
            $precio_unitario = $item->precio_unitario;

            return max($precio_base - $precio_unitario, 0) * $item->cantidad;
        });

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

    public function marcarComoEntregado(Request $request, $id)
    {
        $request->validate([
            'foto_entrega' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pedido = Pedido::findOrFail($id);

        if ($request->hasFile('foto_entrega')) {
            $nombreImagen = 'entrega_' . time() . '.' . $request->foto_entrega->getClientOriginalExtension();

            // Guardar la imagen en storage/app/public/entregas
            $request->foto_entrega->move(public_path('entregas'), $nombreImagen);

            // Guardar la ruta relativa para luego usar Storage::url()
            $pedido->foto_entrega = 'entregas/' . $nombreImagen;
        }

        $pedido->estado = 'entregado';
        $pedido->fecha_entregado = now();
        $pedido->save();

        return redirect()->back()->with('success', '✅ Pedido marcado como entregado correctamente.');
    }
}
