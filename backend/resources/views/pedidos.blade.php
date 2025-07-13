@extends('layouts.plantilla')

@section('titulo', 'Mis Pedidos')

@section('content')

<h2 class="text-center mb-4 py-2 px-3 rounded-3 shadow-sm fw-semibold" style="background: linear-gradient(90deg, #a855f7, #ec4899); color: white;">
    <i class="bi bi-box-seam-fill me-2"></i> Mis Pedidos
</h2>


@if($pedidos->isEmpty())
    <div class="alert alert-info text-center">Aún no tienes pedidos registrados.</div>
@else
    <div class="table-responsive mx-auto" style="max-width: 95%;">
        <table class="table table-hover align-middle shadow-sm rounded text-center">
            <thead class="table-light">
                <tr>
                    <th>Código</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Boleta</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->codigo_pedido }}</td>
                        <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                        <td><strong>S/ {{ number_format($pedido->total, 2) }}</strong></td>
                        <td>
                            @switch($pedido->estado)
                                @case('pendiente_pago')
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-hourglass-split me-1"></i>Pago pendiente
                                    </span>
                                    @break
                                @case('en_curso')
                                    <span class="badge bg-info text-dark">
                                        <i class="bi bi-truck me-1"></i>En curso
                                    </span>
                                    @break
                                @case('entregado')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle-fill me-1"></i>Entregado
                                    </span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">Desconocido</span>
                            @endswitch
                        </td>
                        <td>
                            @if ($pedido->estado === 'pago_confirmado')
                                <a href="{{ route('cliente.boleta', $pedido->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-file-earmark-arrow-down me-1"></i>Boleta
                                </a>
                            @else
                                <span class="text-muted">--</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalDetalles{{ $pedido->id }}">
                                <i class="bi bi-eye-fill me-1"></i>Ver
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modalDetalles{{ $pedido->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $pedido->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title" id="modalLabel{{ $pedido->id }}">
                                                <i class="bi bi-receipt-cutoff me-1"></i>Detalles del pedido {{ $pedido->codigo_pedido }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                                            @if($pedido->items->isEmpty())
                                                <div class="alert alert-warning">No hay artículos en este pedido.</div>
                                            @else
                                                <table class="table table-sm table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Producto</th>
                                                            <th>Cantidad</th>
                                                            <th>Precio unitario</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($pedido->items as $item)
                                                            <tr>
                                                                <td>{{ $item->producto->nombre ?? 'Producto eliminado' }}</td>
                                                                <td>{{ $item->cantidad }}</td>
                                                                <td>S/ {{ number_format($item->precio_unitario, 2) }}</td>
                                                                <td>S/ {{ number_format($item->subtotal, 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif

                                            <div class="text-end mt-3">
                                                <strong>Total del pedido: S/ {{ number_format($pedido->total, 2) }}</strong>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $pedidos->links() }}
    </div>
@endif

@endsection
