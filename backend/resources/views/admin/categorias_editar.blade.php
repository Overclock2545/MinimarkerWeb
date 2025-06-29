@extends('layouts.adminplantilla')

@section('titulo', 'Editar Categoría')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">✏️ Editar Categoría</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error:</strong> {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.categorias.actualizar', $categoria->id) }}" class="row g-3">
        @csrf
        @method('PUT')

        <div class="col-md-6">
            <label for="nombre" class="form-label">Nombre de la categoría</label>
            <input type="text" name="nombre" id="nombre"
                   class="form-control @error('nombre') is-invalid @enderror"
                   value="{{ old('nombre', $categoria->nombre) }}" required>

            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">💾 Guardar Cambios</button>
            <a href="{{ route('admin.categorias') }}" class="btn btn-secondary ms-2">↩️ Cancelar</a>
        </div>
    </form>
</div>
@endsection
