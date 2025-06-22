<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Mostrar productos por categoría (usando slug).
     */
    public function mostrar($slug)
    {
        // Buscar la categoría por su slug
        $categoria = Categoria::where('slug', $slug)->firstOrFail();

        // Obtener todos los productos relacionados a esa categoría
        $productos = $categoria->productos;

        // Pasar los datos a la vista section.blade.php
        return view('section', [
            'titulo' => $categoria->nombre,
            'productos' => $productos
        ]);
    }
    public function mostrarPorId($id)
    {
        $categoria = Categoria::findOrFail($id);
        $productos = $categoria->productos;

        return view('home', [ // 👈 usamos la misma vista
            'titulo' => $categoria->nombre,
            'products' => $productos
        ]);
    }
}
