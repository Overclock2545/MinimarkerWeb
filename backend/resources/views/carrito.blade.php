@extends('layouts.app')

@section('title', 'Carrito - I LIKE YOU')

@section('content')

  <div class="container" style="display: flex; min-height: calc(100vh - 70px);">
    <aside class="sidebar" style="width: 220px; background-color: #f88fa1; padding: 20px;">
      <h3>Opciones</h3>
      <a href="{{ route('inicio') }}">
        <button style="background-color: #fbbacb; border: none; padding: 10px; border-radius: 4px; cursor: pointer; margin-top: 10px;">
          ← Volver al catálogo
        </button>
      </a>
    </aside>

    <main style="flex: 1; padding: 20px; background-color: #fff;">
      <h2 style="color: #d9195b;">🛒 Tu Carrito</h2>

      @if($carrito->isEmpty())
        <p>No tienes productos en el carrito.</p>
      @else
        <table class="cart-table" style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr>
              <th style="background-color: #f88fa1; border: 1px solid #ccc; padding: 12px;">Producto</th>
              <th style="background-color: #f88fa1; border: 1px solid #ccc; padding: 12px;">Precio</th>
              <th style="background-color: #f88fa1; border: 1px solid #ccc; padding: 12px;">Cantidad</th>
              <th style="background-color: #f88fa1; border: 1px solid #ccc; padding: 12px;">Subtotal</th>
              <th style="background-color: #f88fa1; border: 1px solid #ccc; padding: 12px;">Acción</th>
            </tr>
          </thead>
          <tbody>
            @php $total = 0; @endphp
            @foreach($items as $item)
              @php 
                $subtotal = $item->product->precio * $item->quantity; 
                $total += $subtotal; 
              @endphp
              <tr>
                <td style="border: 1px solid #ccc; padding: 12px;">{{ $item->product->nombre }}</td>
                <td style="border: 1px solid #ccc; padding: 12px;">S/. {{ number_format($item->product->precio, 2) }}</td>
                <td style="border: 1px solid #ccc; padding: 12px;">{{ $item->quantity }}</td>
                <td style="border: 1px solid #ccc; padding: 12px;">S/. {{ number_format($subtotal, 2) }}</td>
                <td style="border: 1px solid #ccc; padding: 12px;">
                  <form method="POST" action="{{ route('carrito.remove', $item->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: none; border: none; font-size: 18px; cursor: pointer;">🗑️</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="cart-total" style="text-align: right; margin-top: 20px; font-size: 18px; font-weight: bold; color: #d9195b;">
          Total: S/. {{ number_format($total, 2) }}
        </div>

        <div class="actions" style="margin-top: 30px; display: flex; justify-content: space-between;">
          <a href="{{ route('inicio') }}" style="padding: 10px 20px; background-color: #f88fa1; color: #000; border-radius: 6px; text-decoration: none; font-weight: bold;">
            ← Seguir comprando
          </a>
          <a href="#" style="padding: 10px 20px; background-color: #f88fa1; color: #000; border-radius: 6px; text-decoration: none; font-weight: bold;">
            Proceder al pago
          </a>
        </div>
      @endif
    </main>
  </div>
@endsection



