<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    public function index()
{
    $products = Product::with('categoria')->get();

    $favoritos = Auth::check()
        ? Auth::user()->favoritos->pluck('id')->toArray()
        : [];

    return view('home', [
        'products' => $products,
        'favoritos' => $favoritos
    ]);
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

    $favoritos = Auth::check() ? Auth::user()->favoritos->pluck('id')->toArray() : [];


    return view('home', compact('producto', 'enOferta', 'favoritos'));
}


    public function buscar(Request $request)
{
    $query = $request->input('query');

    $products = Product::with('categoria')
        ->where('nombre', 'LIKE', '%' . $query . '%')
        ->get();

    $favoritos = Auth::check()
        ? Auth::user()->favoritos->pluck('id')->toArray()
        : [];

    return view('home', [
        'products' => $products,
        'titulo' => "Resultados para: \"$query\"",
        'favoritos' => $favoritos
    ]);
}

    public function inicio()
{
    $products = Product::with('categoria')->get();

    $favoritos = Auth::check()
        ? Auth::user()->favoritos->pluck('id')->toArray()
        : [];

    return view('home', [
        'products' => $products,
        'favoritos' => $favoritos
    ]);
}

}
