@extends('layouts.adminplantilla')


@section('titulo', 'Gestionar Productos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>📦 Gestionar Productos</h2>
</div>

{{-- Buscador --}}
<form method="GET" action="{{ route('admin.productos.gestionar') }}" class="row g-2 mb-4">
    <div class="col-auto">
        <input type="text" name="q" value="{{ $busqueda }}" class="form-control" placeholder="Buscar por nombre o ID...">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">🔍 Buscar</button>
    </div>
</form>

{{-- Tabla de productos --}}
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio (S/.)</th>
                <th>Stock</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                    <td>{{ $producto->precio }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>
                        <div class="d-flex gap-1 justify-content-center flex-wrap">

                            {{-- Editar producto --}}
                            <a href="{{ route('admin.productos.editar', $producto->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil-square"></i>
                            </a>


                            {{-- Aumentar stock --}}
                            <form action="#" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-primary" title="Aumentar">➕</button>
                            </form>

                            {{-- Disminuir stock --}}
                            <form action="#" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-warning" title="Disminuir">➖</button>
                            </form>

                            {{-- Eliminar producto --}}
                            <form action="#" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Eliminar">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No se encontraron productos.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Paginación --}}
<div class="d-flex justify-content-center mt-4">
    {{ $productos->links() }}
</div>
@endsection
