@extends('layouts.plantilla')

@section('titulo', 'Mis Pedidos')

@section('content')
<h2 class="mb-4">📦 Mis Pedidos</h2>

@if($pedidos->isEmpty())
    <p>No tienes pedidos registrados.</p>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Boleta</th>
                <th>Más detalles</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->codigo_pedido }}</td>
                    <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                    <td>S/ {{ number_format($pedido->total, 2) }}</td>
                    <td>
                        @if ($pedido->estado === 'pago_confirmado')
                            <span class="badge bg-success">Pago confirmado</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendiente de pago</span>
                        @endif
                    </td>
                    <td>
                        @if ($pedido->estado === 'pago_confirmado')
                            <a href="{{ route('cliente.boleta', $pedido->id) }}" class="btn btn-sm btn-outline-primary">
                                📄 Descargar boleta
                            </a>
                        @else
                            <span class="text-muted">--</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalDetalles{{ $pedido->id }}">
        🔍 Ver detalles
                   </button>

                      <!-- Modal -->
                    <div class="modal fade" id="modalDetalles{{ $pedido->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $pedido->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel{{ $pedido->id }}">Detalles del pedido {{ $pedido->codigo_pedido }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                    <p><strong>Código de pedido:</strong> {{ $pedido->codigo_pedido }}</p>

                    @if($pedido->items->isEmpty())
                    <p>No hay artículos en este pedido.</p>
                     @else
                    <table class="table table-sm">
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

  <div class="text-end">
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

    <div class="mt-3">
        {{ $pedidos->links() }}
    </div>
@endif
@endsection
