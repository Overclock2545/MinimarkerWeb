<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PerfilController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => Redirect::to('/inicio'));

Route::get('/inicio', function () {
    $products = Product::with('categoria')->get();
    return view('home', compact('products'));
})->name('inicio');

Route::get('/producto/{id}', [ProductController::class, 'mostrar'])->name('producto.ver');
Route::get('/buscar', [ProductController::class, 'buscar'])->name('buscar.productos');
Route::get('/categorias/id/{id}', [CategoriaController::class, 'mostrarPorId'])->name('categorias.porId');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Usuarios Autenticados)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/perfil', fn() => view('perfil'))->name('perfil');
    Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');

    // Carrito
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/agregar/{product}', [CarritoController::class, 'add'])->name('carrito.agregar');
    Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'remove'])->name('carrito.eliminar');
    Route::post('/carrito/incrementar/{id}', [CarritoController::class, 'incrementar'])->name('carrito.incrementar');
    Route::post('/carrito/disminuir/{id}', [CarritoController::class, 'disminuir'])->name('carrito.disminuir');
    Route::post('/carrito/confirmar', [CarritoController::class, 'confirmarPedido'])->name('carrito.confirmar');

    // Favoritos
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos');
    Route::post('/favoritos/agregar/{productId}', [FavoritoController::class, 'agregar'])->name('favoritos.agregar');
    Route::delete('/favoritos/eliminar/{product_id}', [FavoritoController::class, 'eliminar'])->name('favoritos.eliminar');

    // Pedidos del cliente
    Route::get('/mis-pedidos', [PedidoController::class, 'misPedidos'])->name('pedidos');
    Route::get('/mis-pedidos/{id}/boleta', [PedidoController::class, 'descargarBoleta'])->name('cliente.boleta');
});

/*
|--------------------------------------------------------------------------
| Rutas para Administradores (Exclusivo)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verificarRol:admin'])->group(function () {
    // Stock y productos
    Route::get('/admin/stock', fn() => view('admin.stock'))->name('admin.stock');
    Route::get('/admin/productos', [AdminController::class, 'gestionarProductos'])->name('admin.productos.gestionar');
    Route::get('/admin/productos/nuevo', [AdminController::class, 'formularioNuevoProducto'])->name('admin.productos.nuevo');
    Route::post('/admin/productos', [AdminController::class, 'guardarNuevoProducto'])->name('admin.productos.guardar');
    Route::get('/admin/productos/{id}/editar', [AdminController::class, 'formularioEditarProducto'])->name('admin.productos.editar');
    Route::put('/admin/productos/{id}', [AdminController::class, 'actualizarProducto'])->name('admin.productos.actualizar');
    Route::delete('/admin/productos/{id}', [AdminController::class, 'eliminarProducto'])->name('admin.productos.eliminar');
    Route::delete('/admin/imagenes/{id}/eliminar', [AdminController::class, 'eliminarImagenAdicional'])->name('admin.imagen.eliminar');

    // Categorías
    Route::get('/admin/categorias', [AdminController::class, 'gestionarCategorias'])->name('admin.categorias');
    Route::post('/admin/categorias/guardar', [AdminController::class, 'guardarCategoria'])->name('admin.categorias.guardar');
    Route::delete('/admin/categorias/eliminar/{id}', [AdminController::class, 'eliminarCategoria'])->name('admin.categorias.eliminar');
    Route::get('/admin/categorias/{id}/editar', [AdminController::class, 'formularioEditarCategoria'])->name('admin.categorias.editar');
    Route::put('/admin/categorias/{id}', [AdminController::class, 'actualizarCategoria'])->name('admin.categorias.actualizar');

    // Análisis y ofertas
    Route::get('/admin/analisis', [AdminController::class, 'analisisVentas'])->name('admin.analisis');
    Route::get('/admin/ofertas', [AdminController::class, 'verOfertas'])->name('admin.ofertas');
    Route::post('/admin/ofertas/{producto}', [AdminController::class, 'actualizarOferta'])->name('admin.ofertas.actualizar');
    Route::post('/admin/ofertas/{id}/terminar', [AdminController::class, 'terminarOferta'])->name('admin.ofertas.terminar');
    // Usuarios
    Route::delete('/admin/usuarios/{id}', [AdminController::class, 'eliminarUsuario'])->name('admin.usuarios.eliminar');
    Route::put('/admin/usuarios/{id}', [AdminController::class, 'actualizarUsuario'])->name('admin.usuarios.actualizar');
});

/*
|--------------------------------------------------------------------------
| Rutas para Administradores y Encargados de Pedidos
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verificarRol:admin,encargado_pedidos'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.panel');

    // Pedidos
    Route::get('/admin/pedidos', [AdminController::class, 'verPedidos'])->name('admin.pedidos');
    Route::get('/admin/pedidos/curso', [AdminController::class, 'pedidosEnCurso'])->name('admin.pedidos.curso');
    Route::get('/admin/pedidos/historial', [AdminController::class, 'historialPedidos'])->name('admin.pedidos.historial');
    Route::post('/admin/pedido/confirmar/{id}', [AdminController::class, 'confirmarPedido'])->name('admin.pedido.confirmar');
    Route::post('/admin/pedido/entregar/{id}', [AdminController::class, 'entregarPedido'])->name('admin.pedido.entregar');

    // Usuarios (solo lectura)
    Route::get('/admin/usuarios', [AdminController::class, 'gestionarUsuarios'])->name('admin.usuarios');
    Route::get('/admin/usuarios/{id}', [AdminController::class, 'verUsuario'])->name('admin.usuarios.ver');
    Route::get('/admin/usuarios/{id}/editar', [AdminController::class, 'editarUsuario'])->name('admin.usuarios.editar');
    Route::get('/admin/usuarios/{id}/pedidos', [AdminController::class, 'verPedidosUsuario'])->name('admin.usuarios.pedidos');
    Route::get('/admin/usuarios/{id}/carrito', [AdminController::class, 'verCarrito'])->name('admin.usuarios.carrito');
    

});

/*
|--------------------------------------------------------------------------
| Autenticación (Breeze / Jetstream / Fortify)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
