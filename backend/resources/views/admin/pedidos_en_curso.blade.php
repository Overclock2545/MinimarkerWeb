@extends('layouts.adminplantilla')

@section('titulo', 'Pedidos en curso')

@section('content')
<h2 class="mb-4">🚚 Pedidos en curso</h2>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Código</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->codigo_pedido }}</td>
                <td>{{ $pedido->usuario->name }}</td>
                <td>S/ {{ number_format($pedido->total, 2) }}</td>
                <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="#" class="btn btn-sm btn-secondary">📄 Ver boleta</a>

                    <!-- Botón que abre el modal -->
<button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#entregarPedidoModal{{ $pedido->id }}">
    📦 Marcar como entregado
</button>

<!-- Modal de confirmación -->
<div class="modal fade" id="entregarPedidoModal{{ $pedido->id }}" tabindex="-1" aria-labelledby="entregarPedidoLabel{{ $pedido->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="entregarPedidoLabel{{ $pedido->id }}">¿Confirmar entrega?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Confirmas que el pedido <strong>{{ $pedido->codigo_pedido }}</strong> fue entregado al cliente?
      </div>
      <div class="modal-footer">
        <form method="POST" action="{{ route('admin.pedido.entregar', $pedido->id) }}">
            @csrf
            <button type="submit" class="btn btn-success">Sí, entregar</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

                </td>
            </tr>
        @empty
            <tr><td colspan="5">Aqui estaran los pedidos en curso a ser entregados! (Cuando halla uno...).</td></tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">{{ $pedidos->links() }}</div>
@endsection
