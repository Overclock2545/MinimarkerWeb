<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
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

        $enOferta = $producto->oferta_activa &&
                    is_numeric($producto->precio_oferta) &&
                    (
                        !$producto->fecha_fin_oferta ||
                        Carbon::parse($producto->fecha_fin_oferta)->gte(Carbon::now())
                    );

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
    $productos = Product::whereNotNull('precio_oferta')->get(); // O ajusta según tu lógica
    return view('ofertas_publicas', compact('productos'));
}

}
