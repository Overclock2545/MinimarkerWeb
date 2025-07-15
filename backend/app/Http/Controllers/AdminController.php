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
use Carbon\Carbon;
use App\Models\PedidoItem;
use App\Models\ImagenProducto;
use Illuminate\Support\Facades\Log;
use App\Models\Banner;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;






use App\Models\Category;

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
        $producto->precio_oferta = $request->precio_oferta;
        $producto->oferta_activa = $request->has('oferta_activa');
        $producto->fecha_fin_oferta = $request->fecha_fin_oferta;
        $producto->save();

        // Subir imagen principal del producto
if ($request->hasFile('imagen')) {
    $imagen = $request->file('imagen');

    // ✅ Subir a Cloudinary en carpeta "productos"
    $uploadResponse = Cloudinary::upload($imagen->getRealPath(), [
    'folder' => 'productos',
    'public_id' => (string) Str::uuid(),
    'overwrite' => true
    ]);


    $urlImagen = $uploadResponse->getSecurePath();  
    $producto->imagen = $urlImagen;
    $producto->save();


    // ❌ Eliminar la imagen anterior si era local (no URL externa)
    if ($producto->imagen && !Str::startsWith($producto->imagen, 'http')) {
        $rutaVieja = str_replace('storage/', '', $producto->imagen);
        Storage::disk('public')->delete($rutaVieja);
    }

    // ✅ Guardar URL en la base de datos
    $producto->imagen = $urlImagen;
    $producto->save();
}

// Subir imágenes adicionales
if ($request->hasFile('imagenes_adicionales')) {
    foreach ($request->file('imagenes_adicionales') as $imagenExtra) {
        $uploadResponse = Cloudinary::upload($imagen->getRealPath(), [
        'folder' => 'productos',
        'public_id' => (string) Str::uuid(),
        'overwrite' => true
]);


        $urlAdicional = $uploadResponse->getSecurePath();

        ImagenProducto::create([
            'product_id' => $producto->id,
            'ruta' => $urlAdicional,
        ]);
    }
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
        $producto->precio_oferta = $request->precio_oferta;
        $producto->precio_oferta = $request->precio_oferta;
        $producto->oferta_activa = $request->has('oferta_activa');
        $producto->fecha_fin_oferta = $request->fecha_fin_oferta;


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
        $pedidos = Pedido::with('usuario')
            ->where('estado', 'pendiente_pago') // ← FILTRAMOS SOLO LOS PENDIENTES
            ->latest()
            ->paginate(10);

        return view('admin.pedidos.index', compact('pedidos'));
    }


    public function confirmarPedido($id)
    {
        $pedido = Pedido::findOrFail($id);

        if ($pedido->estado !== 'pendiente_pago') {
            return back()->with('info', 'Este pedido ya fue procesado.');
        }

        // Validar stock antes de confirmar
        foreach ($pedido->items as $item) {
            $producto = $item->producto;
            if (!$producto || $producto->stock < $item->cantidad) {
                return back()->with('error', 'No hay suficiente stock para el producto: ' . ($producto->nombre ?? 'Producto eliminado'));
            }
        }

        // Descontar stock
        foreach ($pedido->items as $item) {
            $producto = $item->producto;
            if ($producto) {
                $producto->stock -= $item->cantidad;
                $producto->save();
            }
        }

        $pedido->estado = 'en_curso';
        $pedido->save();

        return back()->with('success', '✅ Pedido confirmado, stock actualizado y ahora está en curso.');
    }

    //metodo para ver pedidos en curso
    public function pedidosEnCurso()
    {
        $pedidos = Pedido::where('estado', 'en_curso')->paginate(10);
        return view('admin.pedidos_en_curso', compact('pedidos'));
    }
    //metodo para entregar pedidos
    public function entregarPedido($id)
    {
        $pedido = Pedido::findOrFail($id);

        if ($pedido->estado !== 'en_curso') {
            return back()->with('info', 'Este pedido no está en curso.');
        }

        $pedido->estado = 'entregado';
        $pedido->save();

        return back()->with('success', '📦 Pedido marcado como entregado.');
    }
    // metodo historial de pedidos entregados
    public function historialPedidos(Request $request)
{
    $query = Pedido::with('usuario')->where('estado', 'entregado');

    if ($request->filled('codigo')) {
        $query->where('codigo_pedido', 'like', '%' . $request->codigo . '%');
    }

    if ($request->filled('fecha')) {
        $query->whereDate('created_at', $request->fecha);
    }

    $pedidos = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('admin.pedidos_historial', compact('pedidos'));
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




    public function analisisVentas(Request $request)
    {
        $desde = $request->input('desde') ?? Carbon::now()->subMonth()->toDateString();
        $hasta = $request->input('hasta') ?? Carbon::now()->toDateString();

        // Filtrar pedidos confirmados por fecha
        $pedidos = Pedido::with('items.producto')
            ->where('estado', 'entregado')

            ->whereBetween('created_at', [$desde . ' 00:00:00', $hasta . ' 23:59:59'])
            ->get();

        // Agrupar productos vendidos
        $productos = [];

        foreach ($pedidos as $pedido) {
            foreach ($pedido->items as $item) {
                $id = $item->product_id;
                if (!isset($productos[$id])) {
                    $productos[$id] = [
                        'nombre' => $item->producto->nombre ?? 'Producto eliminado',
                        'cantidad_total' => 0,
                        'suma_total' => 0,
                        'precio_promedio' => 0,
                    ];
                }

                $productos[$id]['cantidad_total'] += $item->cantidad;
                $productos[$id]['suma_total'] += $item->subtotal;
            }
        }

        // Calcular precio promedio
        foreach ($productos as &$prod) {
            $prod['precio_promedio'] = $prod['cantidad_total'] > 0
                ? $prod['suma_total'] / $prod['cantidad_total']
                : 0;
        }
        $orden = $request->input('orden', 'desc'); // 'desc' por defecto
        $productos = collect($productos)
            ->sortBy($orden === 'asc' ? 'cantidad_total' : function ($item) {
                return -$item['cantidad_total'];
            })
            ->values()
            ->all();
        $totalVentas = $pedidos->sum('total');
        $totalPedidos = $pedidos->count();
        $totalProductosVendidos = array_sum(array_column($productos, 'cantidad_total'));
        $clientesUnicos = $pedidos->pluck('usuario_id')->unique()->count();

        return view('admin.analisis', [
            'desde' => $desde,
            'hasta' => $hasta,
            'productosVendidos' => $productos,
            'totalVentas' => $totalVentas,
            'totalPedidos' => $totalPedidos,
            'totalProductosVendidos' => $totalProductosVendidos,
            'clientesUnicos' => $clientesUnicos,
        ]);
    }
    //Ofertas
    public function verOfertas(Request $request)
{
    $query = Product::query();

    // Filtrar por código
    if ($request->filled('codigo')) {
        $query->where('id', $request->codigo);
    }

    // Filtrar por categoría
    if ($request->filled('categoria_id')) {
        $query->where('categoria_id', $request->categoria_id);
    }

    $productos = $query->get();
    $categorias = Categoria::all();

    return view('admin.ofertas', compact('productos', 'categorias'));
}

public function actualizarOferta(Request $request, $id)
{
    $producto = Product::findOrFail($id);

    $request->validate([
    'precio_oferta' => [
        'nullable',
        'numeric',
        'min:0',
        'regex:/^\d+(\.\d{1,2})?$/',
        function ($attribute, $value, $fail) use ($producto) {
            if ($value !== null && $value >= $producto->precio) {
                $fail('⚠️ El precio de oferta debe ser menor que el precio original del producto.');
            }
        },
    ],
], [
    'precio_oferta.numeric' => '⚠️ El precio de oferta debe ser un número válido.',
    'precio_oferta.min' => '⚠️ No se permiten valores negativos en el precio de oferta.',
    'precio_oferta.regex' => '⚠️ El precio de oferta solo puede tener hasta dos decimales.',
]);


    // Si la validación es correcta, actualizamos el precio de oferta
    $producto->precio_oferta = $request->input('precio_oferta');
    $producto->save();
    $producto->oferta_activa = $request->oferta_activa;
    $producto->fecha_fin_oferta = $request->fecha_fin_oferta;
    $producto->save();
    return back()->with('success', '✅ Precio de oferta actualizado correctamente.');
}
public function terminarOferta($id)
{
    $producto = Product::findOrFail($id);
    $producto->precio_oferta = null;
    $producto->save();

    return back()->with('success', '✅ Oferta eliminada correctamente.');
}

public function eliminarImagenAdicional($id)
{
    $imagen = ImagenProducto::findOrFail($id);

    if ($imagen->ruta) {
        $ruta = str_replace('storage/', '', $imagen->ruta);
        Storage::disk('public')->delete($ruta);
    }

    $imagen->delete();

    return back()->with('success', '🗑️ Imagen eliminada correctamente.');
}
public function verPedidosUsuario($id)
{
    $usuario = User::findOrFail($id);

    $query = Pedido::where('user_id', $id)->with(['items.product']);

    if (request('codigo')) {
        $query->where('codigo_pedido', 'like', '%' . request('codigo') . '%');
    }

    $pedidos = $query->get();

    return view('admin.pedidos_usuario', compact('usuario', 'pedidos'));
}
    public function editarBanner()
{
    $banner = Banner::first(); // suponiendo que hay solo uno
    return view('admin.banner', compact('banner'));
}

    public function actualizarBanner(Request $request)
{
    $request->validate([
        'contenido' => 'required|string',
    ]);

    // Suponiendo que solo hay un banner
    $banner = Banner::first();
    if (!$banner) {
        // Si no hay banner aún, creamos uno
        Banner::create([
            'contenido' => $request->input('contenido'),
        ]);
    } else {
        $banner->update([
            'contenido' => $request->input('contenido'),
        ]);
    }

    return redirect()->back()->with('success', 'El banner se actualizó correctamente.');
}







}
