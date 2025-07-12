@extends('layouts.adminplantilla')

@section('title', 'Pedidos de ' . $usuario->name)

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">📦 Pedidos de {{ $usuario->name }}</h2>
    <form method="GET" class="mb-4 d-flex justify-content-center">
    <input type="text" name="codigo" class="form-control w-50 me-2" placeholder="Buscar por código de pedido..." value="{{ request('codigo') }}">
    <button type="submit" class="btn btn-primary">🔍 Buscar</button>
</form>

    @forelse ($pedidos as $pedido)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between">
                <span><strong>Código:</strong> {{ $pedido->codigo_pedido }}</span>
                <span><strong>Total:</strong> S/ {{ number_format($pedido->total, 2) }}</span>
                <span><strong>Estado:</strong> {{ ucfirst($pedido->estado) }}</span>
            </div>
            <div class="card-body">
                <h6>Productos:</h6>
                <ul class="list-group list-group-flush">
                    @foreach ($pedido->items as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                {{ $item->product->nombre ?? 'Producto eliminado' }} 
                                (x{{ $item->cantidad }})
                            </div>
                            <div>
                                S/ {{ number_format($item->subtotal, 2) }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            Este usuario no tiene pedidos registrados.
        </div>
    @endforelse

    <div class="text-center">
        <a href="{{ route('admin.usuarios') }}" class="btn btn-secondary">⬅ Volver a usuarios</a>
    </div>
</div>
@endsection
