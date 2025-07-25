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
                    <th scope="col">Foto de Entrega</th>
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
                        <td>
                            @if($pedido->foto_entrega)
                                <button class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#fotoEntregaModal{{ $pedido->id }}">
                                    <i class="bi bi-image me-1"></i> Ver foto
                                </button>

                                <!-- Modal de imagen -->
                                <div class="modal fade" id="fotoEntregaModal{{ $pedido->id }}" tabindex="-1" aria-labelledby="fotoEntregaLabel{{ $pedido->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="fotoEntregaLabel{{ $pedido->id }}">📸 Foto de entrega - Pedido {{ $pedido->codigo_pedido }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset($pedido->foto_entrega) }}" alt="Foto de entrega" class="img-fluid rounded shadow mb-3">
                                                <br>
                                                <a href="{{ asset($pedido->foto_entrega) }}" download class="btn btn-success">
                                                    <i class="bi bi-download me-1"></i> Descargar imagen
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">Sin foto</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
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
