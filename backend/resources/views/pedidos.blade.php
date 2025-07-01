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
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $pedidos->links() }}
    </div>
@endif
@endsection
