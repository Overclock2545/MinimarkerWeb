@extends('layouts.adminplantilla')

@section('title', 'Pedidos de ' . $usuario->name)

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary">📦 Pedidos de {{ $usuario->name }}</h2>

    <form method="GET" class="mb-4 d-flex justify-content-center">
        <input type="text" name="codigo" class="form-control w-50 me-2" placeholder="Buscar por código de pedido..." value="{{ request('codigo') }}">
        <button type="submit" class="btn btn-outline-primary">🔍 Buscar</button>
    </form>

    @forelse ($pedidos as $pedido)
        <div class="card mb-4 shadow-sm border border-primary-subtle">
            <div class="card-header bg-light d-flex justify-content-between flex-wrap">
                <span><strong>Código:</strong> {{ $pedido->codigo_pedido }}</span>
                <span><strong>Total:</strong> S/ {{ number_format($pedido->total, 2) }}</span>
                <span><strong>Estado:</strong> 
                    <span class="badge bg-{{ $pedido->estado == 'entregado' ? 'success' : ($pedido->estado == 'en_curso' ? 'warning' : 'secondary') }}">
                        {{ ucfirst($pedido->estado) }}
                    </span>
                </span>
            </div>
            <div class="card-body">
                <h6 class="text-muted mb-2">🧾 Productos</h6>
                <ul class="list-group list-group-flush">
                    @foreach ($pedido->items as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                {{ $item->product->nombre ?? 'Producto eliminado' }} 
                                <span class="text-muted">(x{{ $item->cantidad }})</span>
                            </div>
                            <div>
                                S/ {{ number_format($item->subtotal, 2) }}
                            </div>
                        </li>
                    @endforeach
                </ul>

                @if(in_array($pedido->estado, ['en_curso', 'entregado']))
                    <div class="text-end mt-3">
                        <a href="{{ route('boleta.descargar', $pedido->id) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                            📄 Ver boleta
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            Este usuario no tiene pedidos registrados.
        </div>
    @endforelse

    <div class="text-center mt-4">
        <a href="{{ route('admin.usuarios') }}" class="btn btn-outline-secondary">⬅ Volver a usuarios</a>
    </div>
</div>
@endsection
