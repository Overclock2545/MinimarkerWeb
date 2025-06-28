<?php

namespace App\Http\Controllers;

use App\Models\CarritoItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    /**
     * Mostrar los productos del carrito del usuario autenticado.
     */
    public function index()
    {
        $user = Auth::user();

        $carrito = CarritoItem::where('user_id', $user->id)
            ->with('product') // Asegúrate que CarritoItem tenga esta relación
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
}
