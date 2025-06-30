@extends('layouts.adminplantilla')

@section('titulo', 'Agregar Nuevo Producto')

@section('content')
<div class="container mt-4">
    <h2>➕ Agregar Nuevo Producto</h2>

    <form action="{{ route('admin.productos.guardar') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del producto</label>
            <input type="text" name="nombre" id="nombre" 
                   class="form-control @error('nombre') is-invalid @enderror" 
                   value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Categoría --}}
        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoría</label>
            <select name="categoria_id" id="categoria_id" 
                    class="form-select @error('categoria_id') is-invalid @enderror" required>
                <option value="">Selecciona una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Precio --}}
        <div class="mb-3">
            <label for="precio" class="form-label">Precio (S/.)</label>
            <input type="number" step="0.01" name="precio" id="precio" 
                   class="form-control @error('precio') is-invalid @enderror" 
                   value="{{ old('precio') }}" required>
            @error('precio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Stock --}}
        <div class="mb-3">
            <label for="stock" class="form-label">Stock inicial</label>
            <input type="number" name="stock" id="stock" 
                   class="form-control @error('stock') is-invalid @enderror" 
                   value="{{ old('stock') }}" required>
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3"
                      class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Imagen --}}
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen del producto</label>
            <input type="file" name="imagen" id="imagen" 
                   class="form-control @error('imagen') is-invalid @enderror">
            @error('imagen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Botones --}}
        <button type="submit" class="btn btn-success">Guardar Producto</button>
        <a href="{{ route('admin.productos.gestionar') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
