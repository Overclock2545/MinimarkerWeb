@extends('layouts.adminplantilla')

@section('titulo', 'Editar Producto')

@section('content')
<div class="container mt-4">
    <h2>✏️ Editar Producto</h2>

    {{-- FORMULARIO COMPLETO --}}
    <form action="{{ route('admin.productos.actualizar', $producto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- DATOS PRINCIPALES --}}
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

        {{-- IMAGEN PRINCIPAL --}}
        <hr>
        <h5 class="mt-4">🖼 Imagen Principal</h5>
        <div class="mb-3">
            <img src="{{ asset($producto->imagen) }}" alt="Imagen actual" width="150" class="mb-2 rounded">
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Cambiar imagen principal:</label>
            <input type="file" name="imagen" id="imagen" class="form-control">
        </div>

        {{-- SUBIR NUEVAS IMÁGENES ADICIONALES --}}
        <hr>
        <h5 class="mt-4">📸 Imágenes adicionales</h5>
        <div class="mb-3">
            <label for="imagenes_adicionales" class="form-label">Subir nuevas imágenes (puedes subir varias):</label>
            <input type="file" name="imagenes_adicionales[]" id="imagenes_adicionales" class="form-control" multiple>
            <small class="text-muted">Formato recomendado: JPG, PNG. Tamaño recomendado: 800x800 px</small>
        </div>

        {{-- BOTONES --}}
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">💾 Guardar Cambios</button>

            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarEliminar" style="margin-left: 10px;">
                🗑 Eliminar Producto
            </button>
        </div>
    </form>

    {{-- IMÁGENES ADICIONALES YA SUBIDAS --}}
    @if($producto->imagenes && $producto->imagenes->count())
    <div class="mt-4">
        <label class="form-label">Imágenes adicionales actuales:</label>
        <div class="d-flex flex-wrap gap-3">
            @foreach($producto->imagenes as $img)
                <div style="position: relative;">
                    <img src="{{ asset($img->ruta) }}" alt="Imagen adicional" width="100" class="rounded">
                    <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0"
                            data-bs-toggle="modal" data-bs-target="#confirmarEliminarImagen{{ $img->id }}">
                        ✖
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="confirmarEliminarImagen{{ $img->id }}" tabindex="-1" aria-labelledby="confirmarEliminarImagenLabel{{ $img->id }}" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Eliminar Imagen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">¿Estás seguro de eliminar esta imagen adicional?</div>
                          <div class="modal-footer">
                            <form action="{{ route('admin.imagen.eliminar', $img->id) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                              <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

{{-- MODAL PARA ELIMINAR PRODUCTO --}}
<div class="modal fade" id="confirmarEliminar" tabindex="-1" aria-labelledby="confirmarEliminarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar eliminación</h5>
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
