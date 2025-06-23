<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Asegúrate de que el modelo Product esté correctamente importado
use App\Models\User;
use App\Models\CarritoItem;
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
    

       


public function gestionarUsuarios()
{
    $usuarios = User::all();
    return view('admin.usuarios', compact('usuarios'));
}


public function editarUsuario($id)
{
    $usuario = User::findOrFail($id);
    return view('admin.editar_usuario', compact('usuario'));
}

public function actualizarUsuario(Request $request, $id)
{
    $usuario = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'rol' => 'required|string',
        'celular' => 'nullable|string',
        'documento_identidad' => 'nullable|string',
    ]);

    $usuario->update($request->all());

    return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado correctamente.');
}

public function eliminarUsuario($id)
{
    $usuario = User::findOrFail($id);
    $usuario->delete();

    return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado correctamente.');
}



public function verCarrito($id)
{
    $usuario = User::findOrFail($id);
    $carrito = $usuario->carritoItems()->with('product')->get();

    return view('admin.carrito_usuario', compact('usuario', 'carrito'));
}

}
