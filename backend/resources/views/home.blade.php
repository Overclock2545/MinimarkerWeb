@extends('layouts.plantilla')

@section('title', 'I LIKE YOU - Inicio')

@section('content')
  <div class="products-title">{{ $titulo ?? ($producto->nombre ?? 'GRANDES OFERTAS') }}</div>

  @isset($producto)
    {{-- Mostrar producto individual --}}
    <div style="display: flex; gap: 40px; flex-wrap: wrap;">
      <div style="flex: 1; min-width: 300px;">
        <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/350' }}" alt="{{ $producto->nombre }}" style="width: 100%; max-width: 400px; border-radius: 6px;">
        <div style="font-size: 22px; margin: 10px 0;">{{ $producto->nombre }}</div>
        <div style="font-size: 18px;"><strong>S/. {{ $producto->precio }}</strong></div>
        <div style="margin-top: 10px;">Categoría: {{ $producto->categoria->nombre ?? 'Sin categoría' }}</div>

        <div style="margin-top: 20px; display: flex; align-items: center; gap: 10px;">
          <button>-</button>
          <input type="number" value="1" min="1" style="width: 50px; text-align: center;">
          <button>+</button>
        </div>

        <button style="margin-top: 15px; background-color: #222; color: white; padding: 10px; border: none; border-radius: 4px;">Agregar al carrito 🛒</button>
        <button style="margin-top: 10px; background-color: #fbbacb; border: none; padding: 10px; border-radius: 4px;">Agregar a favoritos ⭐</button>
      </div>

      <div style="flex: 2; min-width: 300px;">
        <h3>Descripción:</h3>
        <p style="max-height: 300px; overflow-y: auto;">
          {{ $producto->descripcion ?? 'Este producto no tiene una descripción.' }}
        </p>
      </div>
    </div>
  @else
    {{-- Mostrar lista de productos --}}
    <div class="products">
      @foreach($products as $product)
        <a href="{{ route('producto.ver', $product->id) }}" style="text-decoration: none; color: inherit;">
          <div class="product-card">
            <img src="{{ $product->imagen ?? 'https://via.placeholder.com/150' }}" alt="{{ $product->nombre }}">
            <div>
              {{ $product->nombre }}<br>
              <strong>S/. {{ $product->precio }}</strong><br>
              <small>
                Categoría: {{ $product->categoria->nombre ?? 'Sin categoría' }}
              </small>
            </div>
             @auth
       <form method="POST" action="{{ route('carrito.agregar', $product->id) }}" class="card-footer">
      @csrf
      <button type="submit" class="add-to-cart-btn">Agregar al carrito 🛒</button>
    </form>
    @endauth
          </div>
        </a>
      @endforeach
    </div>
  @endisset
@endsection
