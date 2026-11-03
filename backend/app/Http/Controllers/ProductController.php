<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function inicioComercial()
    {
        return view('home');
    }

    public function catalogoComercial(Request $request)
    {
        $categorias = config('catalogo_b2');
        $activa = $request->query('categoria', 'todas');
        abort_if($activa !== 'todas' && !isset($categorias[$activa]), 404);

        return view('categorias.categoria-generica', compact('categorias', 'activa'));
    }

    public function detalleComercial(string $id)
    {
        foreach (config('catalogo_b2') as $clave => $categoria) {
            foreach ($categoria['ofertas'] as $oferta) {
                if ($oferta['id'] === $id) {
                    return view('section', compact('categoria', 'clave', 'oferta'));
                }
            }
        }

        abort(404);
    }

    public function compararComercial()
    {
        return view('ofertas_publicas', ['categorias' => config('catalogo_b2')]);
    }

    public function index()
    {
        $products = Product::with('categoria')->get();

        $favoritos = $this->obtenerFavoritos();

        return view('home', [
            'products' => $products,
            'favoritos' => $favoritos
        ]);
    }

    public function mostrar($id)
    {
        $producto = Product::with(['categoria', 'imagenes'])->findOrFail($id);

        $enOferta = $producto->tieneOferta();

        $favoritos = $this->obtenerFavoritos();

        return view('home', compact('producto', 'enOferta', 'favoritos'));
    }

    public function buscar(Request $request)
    {
        $query = $request->input('query');

        $products = Product::with('categoria')
            ->where('nombre', 'LIKE', '%' . $query . '%')
            ->get();

        $favoritos = $this->obtenerFavoritos();

        return view('home', [
            'products' => $products,
            'titulo' => "Resultados para: \"$query\"",
            'favoritos' => $favoritos
        ]);
    }

    public function inicio()
    {
        $products = Product::with('categoria')->get();

        $favoritos = $this->obtenerFavoritos();

        logger($favoritos); // Para depurar si se desea

        return view('home', [
            'products' => $products,
            'favoritos' => $favoritos
        ]);
    }

    // ✅ Método privado para obtener favoritos correctamente
    private function obtenerFavoritos()
    {
        if (Auth::check()) {
            $user = User::with('favoritos')->find(Auth::id());
            return $user->favoritos->pluck('id')->toArray();
        }

        return [];
    }

    public function mostrarOfertas()
{
    $productos = Product::where('oferta_activa', true)->whereNotNull('precio_oferta')
        ->whereColumn('precio_oferta', '<', 'precio')
        ->where(function ($query) { $query->whereNull('fecha_fin_oferta')->orWhereDate('fecha_fin_oferta', '>=', today()); })->get();
    return view('ofertas_publicas', compact('productos'));
}

}
