<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{

    public function toggle($productId)
    {
        $user = Auth::user();

        $favorito = Favorito::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($favorito) {
            $favorito->delete();
        } else {
            Favorito::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
        }

        return redirect()->back()->with('success', 'Producto actualizado en favoritos');
    }

    public function index()
    {
        $favoritos = Auth::user()->favoritos;
        return view('favoritos', compact('favoritos'));
    }
    //
}
