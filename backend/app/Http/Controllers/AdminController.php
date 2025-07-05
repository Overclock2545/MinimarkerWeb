<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Asegúrate de que el modelo Product esté correctamente importado
use App\Models\User;
use App\Models\CarritoItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Categoria;
use App\Models\Pedido; // Asegúrate de que el modelo Categoria esté correctamente importado

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
    public function eliminarProducto($id)
    {
        $producto = Product::findOrFail($id);

        // Elimina imagen si existe
        if ($producto->imagen) {
            $rutaVieja = str_replace('storage/', '', $producto->imagen);
            Storage::disk('public')->delete($rutaVieja);
        }

        $producto->delete();

        return redirect()->route('admin.productos.gestionar')->with('success', 'Producto eliminado correctamente.');
    }

    //Metodo para crear nuevos productos
    public function formularioNuevoProducto()
    {
        $categorias = Categoria::all();
        return view('admin.productos.nuevo', compact('categorias'));
    }

    public function guardarNuevoProducto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $producto = new Product();
        $producto->id = strtoupper(Str::random(6)); // ID personalizado
        $producto->nombre = $request->nombre;
        $producto->categoria_id = $request->categoria_id;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->stock = $request->stock;

        // Subida de imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreArchivo = Str::uuid() . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('productos', $nombreArchivo, 'public');
            $producto->imagen = 'storage/productos/' . $nombreArchivo;
        }

        $producto->save();

        return redirect()->route('admin.productos.gestionar')->with('success', 'Producto creado exitosamente.');
    }


    //Metodo para gestionar categorias
    public function gestionarCategorias()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('admin.categorias', compact('categorias'));
    }

    public function guardarCategoria(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:35|unique:categorias,nombre',
        ]);

        Categoria::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('admin.categorias')->with('success', 'Categoría agregada correctamente.');
    }

    public function eliminarCategoria($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('admin.categorias')->with('success', 'Categoría eliminada.');
    }


    public function formularioEditarCategoria($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias_editar', compact('categoria'));
    }

    public function actualizarCategoria(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:35|unique:categorias,nombre,' . $id,
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update(['nombre' => $request->nombre]);

        return redirect()->route('admin.categorias')->with('success', 'Categoría actualizada correctamente.');
    }



    // Metodo para ver pedidos
    public function verPedidos()
    {
        $pedidos = Pedido::with('usuario')->latest()->paginate(10);
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function confirmarPago($id)
    {
        $pedido = Pedido::findOrFail($id);

        if ($pedido->estado === 'pendiente_pago') {
            $pedido->estado = 'pago_confirmado';
            $pedido->save();

            foreach ($pedido->items as $item) {
                $producto = $item->producto;

                if ($producto && $producto->stock >= $item->cantidad) {
                    $producto->stock -= $item->cantidad;
                    $producto->save();
                } else {
                    // Opción: cancelar el proceso si hay falta de stock (seguridad adicional)
                    return back()->with('error', 'No hay suficiente stock para el producto: ' . $producto->nombre);
                }
            }

            return back()->with('success', 'Pago confirmado y boleta generada.');
        }



        return back()->with('info', 'Este pedido ya está confirmado.');
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
