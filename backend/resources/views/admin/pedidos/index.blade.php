@extends('layouts.adminplantilla')

@section('titulo', 'Pedidos')

@section('content')
<h2 class="mb-4">📦 Lista de Pedidos</h2>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>Código</th>
            <th>Cliente</th>
            <th>Total (S/.)</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Acción</th>
            <th>Detalles</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->codigo_pedido}}</td>
                <td>{{ $pedido->usuario->name}}</td>
                <td>{{ number_format($pedido->total, 2) }}</td>
                <td>
                    @if ($pedido->estado === 'pendiente_pago')
                        <span class="badge bg-warning text-dark">Pendiente</span>
                    @else
                        <span class="badge bg-success">Confirmado</span>
                    @endif
                </td>
                <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                <td>
                    @if ($pedido->estado === 'pendiente_pago')
                        <form method="POST" action="{{ route('admin.pedido.confirmar', $pedido->id) }}">
                            @csrf
                            <button class="btn btn-sm btn-primary">✅ Confirmar pago</button>
                        </form>
                    @else
                        <a href="#" class="btn btn-sm btn-secondary">📄 Ver boleta</a>
                    @endif
                </td>
                <td>
                    <!-- Botón para abrir el modal -->
<button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modalDetalles{{ $pedido->id }}">
    🔍 Ver detalles
</button>

<!-- Modal -->
<div class="modal fade" id="modalDetalles{{ $pedido->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $pedido->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel{{ $pedido->id }}">Detalles del pedido {{ $pedido->codigo_pedido }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p><strong>Cliente:</strong> {{ $pedido->usuario->name }}</p>
        <p><strong>Código:</strong> {{ $pedido->codigo_pedido }}</p>
        <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>

        @if($pedido->items->isEmpty())
          <p>No hay artículos en este pedido.</p>
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
        @empty
            <tr>
                <td colspan="6">No hay pedidos registrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $pedidos->links() }}
</div>
@endsection
