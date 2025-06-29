<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Asegúrate de que el modelo Product esté correctamente importado
use App\Models\User;
use App\Models\CarritoItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.index', compact('products'));
        // asegúrate de tener la vista correspondiente
    }

    //Metodo para ver productos

    public function gestionarProductos(Request $request)
    {
        $busqueda = $request->input('q');
        $productos = Product::with('categoria')
            ->when($busqueda, function ($query, $busqueda) {
                $query->where('nombre', 'like', "%$busqueda%")
                    ->orWhere('id', 'like', "%$busqueda%");
            })
            ->paginate(10);

        return view('admin.productos.index', compact('productos', 'busqueda'));
    }

    // Metodo para editar productos
    public function formularioEditarProducto($id)
    {
        $producto = Product::findOrFail($id);
        $categorias = \App\Models\Categoria::all();

        return view('admin.productos.editar', compact('producto', 'categorias'));
    }

    public function actualizarProducto(Request $request, $id)
    {
        $producto = Product::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Actualiza campos
        $producto->update([
            'nombre' => $request->nombre,
            'categoria_id' => $request->categoria_id,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'descripcion' => $request->descripcion,
        ]);

        // Si sube una nueva imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');

            // Nombre único
            $nombreArchivo = Str::uuid() . '.' . $imagen->getClientOriginalExtension();

            // Guarda en storage/app/public/productos
            $ruta = $imagen->storeAs('productos', $nombreArchivo, 'public');

            // Elimina imagen anterior
            if ($producto->imagen) {
                $rutaVieja = str_replace('storage/', '', $producto->imagen); // convierte 'storage/productos/...' a 'productos/...'
                Storage::disk('public')->delete($rutaVieja);
            }

            // Guarda nueva ruta accesible públicamente
            $producto->imagen = 'storage/productos/' . $nombreArchivo;
            $producto->save();
        }


        return redirect()->route('admin.productos.gestionar')->with('success', 'Producto actualizado correctamente.');
    }


    //Metodo para ver usuarios

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
