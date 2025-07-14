<?php

namespace App\Http\Controllers;

use App\Models\favorito;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class FavoritoController extends Controller
{
    // Muestra la lista de productos favoritos del usuario autenticado
    public function index()
    {
        $favoritos = favorito::with('producto')
            ->where('user_id', Auth::id())
            ->get();
        return view('favoritos', compact('favoritos'));
    }

    // Agrega o elimina un producto de los favoritos del usuario autenticado
    public function agregar($productId)
    {
        $user = Auth::user();

        $favorito = favorito::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($favorito) {
            $favorito->delete();
        } else {
            favorito::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
        }

        return redirect()->back()->with('success', 'Producto actualizado en favoritos');
    }

    // Elimina un producto de los favoritos del usuario autenticado
    public function eliminar($productId)
    {
        favorito::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        return redirect()->back()->with('success', 'Producto eliminado de favoritos');
    }

    //
}
