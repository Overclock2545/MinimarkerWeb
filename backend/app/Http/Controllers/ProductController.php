<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categoria')->get();
        return view('home', ['products' => $products]);
    }

    public function mostrar($id)
    {
        $producto = Product::with('categoria')->findOrFail($id);

        $enOferta = $producto->oferta_activa &&
                    is_numeric($producto->precio_oferta) &&
                    (
                        !$producto->fecha_fin_oferta ||
                        Carbon::parse($producto->fecha_fin_oferta)->gte(Carbon::now())
                    );

        return view('home', [
            'producto' => $producto,
            'enOferta' => $enOferta
        ]);
    }

    public function buscar(Request $request)
    {
        $query = $request->input('query');

        $products = Product::with('categoria')
            ->where('nombre', 'LIKE', '%' . $query . '%')
            ->get();

        return view('home', [
            'products' => $products,
            'titulo' => "Resultados para: \"$query\""
        ]);
    }

    public function inicio()
    {
        $products = Product::with('categoria')->get();
        return view('home', compact('products'));
    }
}
