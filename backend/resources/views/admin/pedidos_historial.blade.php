@extends('layouts.adminplantilla')

@section('titulo', 'Historial de pedidos')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center" style="color: #8b5cf6;">📜 Historial de pedidos entregados</h2>

    <!-- Filtros de búsqueda -->
    <form method="GET" action="{{ route('admin.pedidos.historial') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="codigo" value="{{ request('codigo') }}" class="form-control" placeholder="Buscar por código">
        </div>
        <div class="col-md-4">
            <input type="date" name="fecha" value="{{ request('fecha') }}" class="form-control">
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="{{ route('admin.pedidos.historial') }}" class="btn btn-outline-secondary">Limpiar</a>
        </div>
    </form>

    <!-- Tabla de resultados -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle shadow-sm">
            <thead class="table-light text-center">
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Boleta</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->codigo_pedido }}</td>
                        <td>{{ $pedido->usuario->name }}</td>
                        <td>S/ {{ number_format($pedido->total, 2) }}</td>
                        <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-secondary">📄 Ver boleta</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="alert alert-info m-0">
                                Aquí podrás ver el historial de los pedidos ya entregados. (Cuando haya alguno…)
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-3">
        {{ $pedidos->appends(request()->query())->links() }}
    </div>
</div>
@endsection
