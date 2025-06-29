@extends('layouts.adminplantilla')

@section('titulo', 'Gestionar Categorías')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">🏷️ Gestionar Categorías</h2>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Agregar nueva categoría --}}
    <form method="POST" action="{{ route('admin.categorias.guardar') }}" class="row g-3 mb-4">
        @csrf
        <div class="col-md-6">
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                   placeholder="Nueva categoría" value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-success w-100">➕ Agregar</button>
        </div>
    </form>

    {{-- Lista de categorías --}}
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th style="width: 120px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categorias as $categoria)
                <tr>
                    <td>{{ $categoria->id }}</td>
                    <td>{{ $categoria->nombre }}</td>
                    <td>
                        {{-- Editar --}}
                        <a href="{{ route('admin.categorias.editar', $categoria->id) }}" class="btn btn-sm btn-warning">✏️</a>
                        {{-- Eliminar --}}
                        <form action="{{ route('admin.categorias.eliminar', $categoria->id) }}" method="POST" 
                              onsubmit="return confirm('¿Eliminar esta categoría?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">🗑️</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No hay categorías registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
