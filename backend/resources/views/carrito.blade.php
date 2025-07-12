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
    <h2 class="fw-bold" style="font-size: 2.2rem; color: #333;">
        🛒 <span style="border-bottom: 3px solid #000; padding-bottom: 5px;">Tu Carrito</span>
    </h2>
</div>

@if($carrito->isEmpty())
    <p style="text-align: center; font-size: 18px;">Tu carrito está vacío.</p>
@else
    <div style="display: flex; flex-direction: column; gap: 20px;">
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

            <div style="display: flex; justify-content: space-between; align-items: center; background-color: #fff0f5; padding: 15px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <a href="{{ route('producto.ver', $producto->id) }}">
                        <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/80' }}" alt="{{ $producto->nombre }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                    </a>

                    <div>
                        <a href="{{ route('producto.ver', $producto->id) }}" style="font-weight: bold; text-decoration: none; color: #000;">
                            {{ $producto->nombre }}
                            @if($producto->stock == 0)
                                <span class="badge bg-secondary ms-2">Sin existencias</span>
                            @endif
                        </a>

                        {{-- Precio --}}
                        @if($enOferta)
                            <div>
                                <span class="text-success fw-bold">S/. {{ number_format($producto->precio_oferta, 2) }}</span>
                                <small class="text-muted text-decoration-line-through">S/. {{ number_format($producto->precio, 2) }}</small>
                                <span class="badge bg-success ms-1">¡En oferta!</span>
                            </div>
                        @else
                            <div class="text-dark">Precio: S/. {{ number_format($producto->precio, 2) }}</div>
                        @endif

                        {{-- Cantidad y stock --}}
                        @if($producto->stock > 0)
                            <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px; flex-wrap: wrap;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <form action="{{ route('carrito.disminuir', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" style="background-color: #ddd; border: none; padding: 5px 10px;">-</button>
                                    </form>

                                    <span>{{ $item->cantidad }}</span>

                                    <form action="{{ route('carrito.incrementar', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" style="background-color: #ddd; border: none; padding: 5px 10px;">+</button>
                                    </form>
                                </div>

                                <span class="text-muted small">({{ $producto->stock }} existencias)</span>
                            </div>

                            <div>Cantidad: {{ $item->cantidad }}</div>
                            <div>Subtotal: S/. {{ number_format($subtotal, 2) }}</div>
                        @else
                            <div class="text-muted mt-2">No disponible actualmente. Elimina este producto para poder continuar con la compra.</div>
                        @endif
                    </div>
                </div>
                <form method="POST" action="{{ route('carrito.eliminar', $item->id) }}">
                    @csrf
                    <button type="submit" style="background-color: #ff5c5c; color: white; padding: 8px 14px; border: none; border-radius: 4px;">Eliminar</button>
                </form>
            </div>
        @endforeach

        <form action="{{ route('carrito.confirmar') }}" method="POST" style="text-align: center; margin-top: 20px;">
            @csrf
            <button class="btn btn-success">✅ Confirmar y Coordinar por WhatsApp</button>
        </form>

        <div style="text-align: right; font-size: 20px; font-weight: bold; margin-top: 20px;">
            Total: S/. {{ number_format($total, 2) }}
        </div>
    </div>
@endif

@endsection
