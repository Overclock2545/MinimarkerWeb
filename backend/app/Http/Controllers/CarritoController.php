<?php

namespace App\Http\Controllers;

use App\Models\CarritoItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function add(Request $request, $productId)
    {
        $user = Auth::user();

        // Verifica si ya está en el carrito
        $item = CarritoItem::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($item) {
            // Si ya existe, aumenta la cantidad
            $item->quantity += 1;
            $item->save();
        } else {
            // Si no, crea una nueva entrada
            CarritoItem::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }
    //
}
