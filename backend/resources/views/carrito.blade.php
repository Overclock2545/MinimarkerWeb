@extends('layouts.plantilla')

@section('title', 'Tu Carrito de Compras')

@section('content')

@if (session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
@endif

<div class="text-center my-4">
    <h2 class="fw-bold display-6 text-purple">
        🛒 Tu Carrito de Compras
    </h2>
</div>

@if($carrito->isEmpty())
    <div class="text-center mt-5">
        <p class="fs-5 text-muted">Tu carrito está vacío.</p>
        <i class="bi bi-cart-x" style="font-size: 3rem; color: #aaa;"></i>
    </div>
@else
    <div class="container">
        @php $total = 0; @endphp
        @foreach($carrito as $item)
            @php
                $producto = $item->product;
                $enOferta = $producto->oferta_activa &&
                            is_numeric($producto->precio_oferta) &&
                            (!$producto->fecha_fin_oferta || \Carbon\Carbon::parse($producto->fecha_fin_oferta)->gte(now()));
                $precioUnitario = $enOferta ? $producto->precio_oferta : $producto->precio;
                $subtotal = $precioUnitario * $item->cantidad;
                $total += $subtotal;
            @endphp

            <div class="card shadow-sm mb-4 border-0" style="background-color: #fef6ff;">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center gap-4 flex-wrap">
                        <a href="{{ route('producto.ver', $producto->id) }}">
                            <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/80' }}"
                                 alt="{{ $producto->nombre }}"
                                 class="rounded shadow-sm"
                                 style="width: 80px; height: 80px; object-fit: cover;">
                        </a>
                        <div>
                            <h5 class="mb-1">
                                <a href="{{ route('producto.ver', $producto->id) }}" class="text-dark text-decoration-none fw-bold">
                                    {{ $producto->nombre }}
                                </a>
                                @if($producto->stock == 0)
                                    <span class="badge bg-secondary ms-2">Sin existencias</span>
                                @endif
                            </h5>

                            @if($enOferta)
                                <div>
                                    <span class="text-success fw-bold">S/. {{ number_format($producto->precio_oferta, 2) }}</span>
                                    <small class="text-muted text-decoration-line-through">S/. {{ number_format($producto->precio, 2) }}</small>
                                    <span class="badge bg-success">Oferta</span>
                                </div>
                            @else
                                <div class="text-dark">Precio: S/. {{ number_format($producto->precio, 2) }}</div>
                            @endif

                            @if($producto->stock > 0)
                                <div class="mt-2 d-flex align-items-center gap-2 flex-wrap">
<form action="{{ route('carrito.disminuir', $item->id) }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-outline-secondary btn-sm"
        @if($item->cantidad <= 1) disabled @endif>−</button>
</form>


                                    <span>{{ $item->cantidad }}</span>

                                    <form action="{{ route('carrito.incrementar', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-secondary btn-sm">+</button>
                                    </form>

                                    <span class="text-muted small">({{ $producto->stock }} en stock)</span>
                                </div>

                                <div class="mt-2">Subtotal: <strong>S/. {{ number_format($subtotal, 2) }}</strong></div>
                            @else
                                <div class="text-muted mt-2">No disponible. Elimina este producto para continuar con la compra.</div>
                            @endif
                        </div>
                    </div>

                    <form method="POST" action="{{ route('carrito.eliminar', $item->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">🗑 Eliminar</button>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="text-end fs-4 fw-bold text-dark mb-4">
            Total: S/. {{ number_format($total, 2) }}
        </div>

        <div class="text-center">
            <form id="confirmarPedidoForm" action="{{ route('carrito.confirmar') }}" method="POST">
                @csrf
                <button type="button" class="btn btn-success btn-lg px-4" data-bs-toggle="modal" data-bs-target="#confirmarPedidoModal">
                    ✅ Confirmar y Coordinar por WhatsApp
                </button>
            </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="confirmarPedidoModal" tabindex="-1" aria-labelledby="confirmarPedidoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="confirmarPedidoLabel">¿Confirmar Pedido?</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        El pedido será generado y se te guiará con un asesor vía <strong>WhatsApp</strong> para confirmar el pedido, acordar el pago y coordinar la entrega.
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" form="confirmarPedidoForm">Ir a confirmar pedido</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endif

@endsection
