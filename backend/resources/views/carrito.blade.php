@extends('layouts.plantilla')

@section('title', 'Tu Carrito de Compras')

@section('content')
  <div class="products-title">🛒 Tu Carrito</div>

  @if($carrito->isEmpty())
    <p style="text-align: center; font-size: 18px;">Tu carrito está vacío.</p>
  @else
    <div style="display: flex; flex-direction: column; gap: 20px;">
      @php $total = 0; @endphp
      @foreach($carrito as $item)
        @php
          $producto = $item->product;
          $subtotal = $producto->precio * $item->cantidad;
          $total += $subtotal;
        @endphp

        <div style="display: flex; justify-content: space-between; align-items: center; background-color: #fff0f5; padding: 15px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
          <div style="display: flex; align-items: center; gap: 15px;">
            <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/80' }}" alt="{{ $producto->nombre }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
            <div>
              <div style="font-weight: bold;">{{ $producto->nombre }}</div>
              <div>Precio: S/. {{ number_format($producto->precio, 2) }}</div>
              <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px;">

              {{-- Disminuir --}}
              <form action="{{ route('carrito.disminuir', $item->id) }}" method="POST" style="display:inline;">
              @csrf
              <button type="submit" style="background-color: #ddd; border: none; padding: 5px 10px;">-</button>
              </form>

              <span>{{ $item->cantidad }}</span>

              {{-- Aumentar --}}
              <form action="{{ route('carrito.incrementar', $item->id) }}" method="POST" style="display:inline;">
              @csrf
              <button type="submit" style="background-color: #ddd; border: none; padding: 5px 10px;">+</button>
  </form>
</div>

              <div>Cantidad: {{ $item->cantidad }}</div>
              <div>Subtotal: S/. {{ number_format($subtotal, 2) }}</div>
            </div>
          </div>
          <form method="POST" action="{{ route('carrito.eliminar', $item->id) }}">
            @csrf
            <button type="submit" style="background-color: #ff5c5c; color: white; padding: 8px 14px; border: none; border-radius: 4px;">Eliminar</button>
          </form>
        </div>
      @endforeach

      <div style="text-align: right; font-size: 20px; font-weight: bold; margin-top: 20px;">
        Total: S/. {{ number_format($total, 2) }}
      </div>
    </div>
  @endif
@endsection
