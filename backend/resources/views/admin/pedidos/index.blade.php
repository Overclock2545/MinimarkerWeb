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
