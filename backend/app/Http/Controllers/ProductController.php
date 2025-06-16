<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Asegúrate de tener esto bien
        return view('home', ['products' => $products]); // 👈 clave: 'products'
    }
    public function mostrar($id)
{
    $producto = Product::with('categoria')->findOrFail($id);

    return view('home', ['producto' => $producto ]);
}
public function buscar(Request $request)
{
    $query = $request->input('query');

    $products = Product::with('categoria')
        ->where('nombre', 'LIKE', '%' . $query . '%') // búsqueda parcial
        ->get();

    return view('home', [
        'products' => $products,
        'titulo' => "Resultados para: \"$query\""
    ]);
}


}
