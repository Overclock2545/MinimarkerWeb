<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Asegúrate de que el modelo Product esté correctamente importado
class AdminController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.index', compact('products'));
        // asegúrate de tener la vista correspondiente
    }

    public function agregarStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|string|exists:product,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Product::findOrFail($request->product_id);
        $producto->stock += $request->cantidad;
        $producto->save();

        return redirect()->route('admin.panel')->with('success', 'Stock actualizado correctamente.');

        // lógica para actualizar el stock
    }
}
