@extends('layouts.adminplantilla')

@section('titulo', 'Historial de pedidos')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-purple">📜 Historial de Pedidos Entregados</h2>
        <p class="text-muted">Consulta los pedidos finalizados por los clientes</p>
    </div>

    <!-- Filtros -->
    <form method="GET" action="{{ route('admin.pedidos.historial') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="codigo" value="{{ request('codigo') }}" class="form-control shadow-sm" placeholder="🔍 Buscar por código">
        </div>
        <div class="col-md-4">
            <input type="date" name="fecha" value="{{ request('fecha') }}" class="form-control shadow-sm">
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                <i class="bi bi-search me-1"></i> Buscar
            </button>
            <a href="{{ route('admin.pedidos.historial') }}" class="btn btn-outline-secondary w-100 shadow-sm">
                <i class="bi bi-x-circle me-1"></i> Limpiar
            </a>
        </div>
    </form>

    <!-- Tabla de pedidos -->
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered align-middle text-center table-hover bg-white">
            <thead class="table-light text-dark">
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Total</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Boleta</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pedidos as $pedido)
                    <tr>
                        <td class="fw-semibold">{{ $pedido->codigo_pedido }}</td>
                        <td>{{ $pedido->usuario->name }}</td>
                        <td>S/ {{ number_format($pedido->total, 2) }}</td>
                        <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('boleta.descargar', $pedido->id) }}" target="_blank" class="btn btn-sm btn-outline-primary shadow-sm">
                                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Ver boleta
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="alert alert-warning m-0">
                                No se han encontrado pedidos entregados aún.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        {{ $pedidos->appends(request()->query())->links() }}
    </div>
</div>
@endsection
