@extends('layouts.adminplantilla')

@section('titulo', 'Editar Producto')

@section('content')
<div class="container mt-4">
    <h2>✏️ Editar Producto</h2>

    <form action="{{ route('admin.productos.actualizar', $producto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoría:</label>
            <select name="categoria_id" id="categoria_id" class="form-select">
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio:</label>
            <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="{{ old('precio', $producto->precio) }}" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock:</label>
            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $producto->stock) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen actual:</label><br>
            <img src="{{ asset($producto->imagen) }}" alt="Imagen actual" width="150" class="mb-2 rounded">
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Cambiar imagen: (Recomendable tamaño: Ancho: 800 px  
Alto: 800 px
            )</label>
            <input type="file" name="imagen" id="imagen" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">💾 Guardar Cambios</button>

        <!-- Botón para abrir el modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarEliminar" style="margin-left: 10px;">
            🗑 Eliminar Producto
        </button>
    </form>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmarEliminar" tabindex="-1" aria-labelledby="confirmarEliminarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmarEliminarLabel">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de eliminar este producto? Esta acción no se puede deshacer.
      </div>
      <div class="modal-footer">
        <form action="{{ route('admin.productos.eliminar', $producto->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Sí, eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
