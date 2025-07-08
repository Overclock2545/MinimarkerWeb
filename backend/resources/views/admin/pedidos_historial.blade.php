@extends('layouts.adminplantilla')

@section('titulo', 'Historial de pedidos')

@section('content')
<h2 class="mb-4">📜 Historial de pedidos entregados</h2>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Código</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Boleta</th>
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
                </td>

            </tr>
        @empty
            <tr><td colspan="4">Aqui podras ver el historial de los pedidos ya entregados! (Cuando halla uno...).</td></tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">{{ $pedidos->links() }}</div>
@endsection
