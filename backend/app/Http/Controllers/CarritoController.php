<?php

namespace App\Http\Controllers;

use App\Models\CarritoItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    // Agregar producto al carrito desde la vista de productos
    public function add(Request $request, $productId)
    {
        $user = Auth::user();

        // Verifica si ya está en el carrito
        $item = CarritoItem::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($item) {
            // Si ya existe, aumenta la cantidad
            $item->cantidad += $request->input('cantidad', 1);

            $item->save();
        } else {
            // Si no, crea una nueva entrada
            CarritoItem::create([
    'user_id' => $user->id,
    'product_id' => $productId,
    'cantidad' => $request->input('cantidad', 1),
]);

        }

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    public function remove($id)
    {
        // Busca el ítem del carrito por su ID
        $item = \App\Models\CarritoItem::findOrFail($id);


        // Elimina el ítem del carrito
        $item->delete();

        // Redirige de vuelta al carrito con un mensaje de éxito
        return redirect()->back()->with('status', 'Producto eliminado del carrito.');
    }

    // Aumentar cantidad desde la vista del carrito
    public function incrementar($id)
    {
        $item = CarritoItem::findOrFail($id);
        $item->cantidad += 1;
        $item->save();

        return redirect()->route('carrito');
    }

    // Disminuir cantidad desde la vista del carrito
    public function disminuir($id)
    {
        $item = CarritoItem::findOrFail($id);

        if ($item->cantidad > 1) {
            $item->cantidad -= 1;
            $item->save();
        } else {
            $item->delete(); // si la cantidad es 1 y se disminuye, se elimina
        }

        return redirect()->route('carrito');
    }



    public function index()
    {
        $user = Auth::user();

        // Carga los items del carrito con sus productos asociados
        $carrito = CarritoItem::where('user_id', $user->id)
            ->with('product') // Asegúrate que CarritoItem tenga esta relación
            ->get();

        return view('carrito', compact('carrito'));
    }



    //
}
