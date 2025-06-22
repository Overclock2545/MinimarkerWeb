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

        

        <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST" style="margin-top: 15px;">
  @csrf
  <input type="hidden" name="cantidad" value="1" id="cantidad-input">
<div style="margin-top: 20px; display: flex; align-items: center; gap: 10px;">
    <button type="button" onclick="cambiarCantidad(-1)">-</button>
    <input type="number" id="cantidad" value="1" min="1" style="width: 50px; text-align: center;" readonly>
    <button type="button" onclick="cambiarCantidad(1)">+</button>
  </div>

  <button type="submit" style="margin-top: 15px; background-color: #222; color: white; padding: 10px; border: none; border-radius: 4px;">
    Agregar al carrito 🛒
  </button>
</form>

<script>
  function cambiarCantidad(cambio) {
    const inputVisible = document.getElementById('cantidad');
    const inputOculto = document.getElementById('cantidad-input');
    let valor = parseInt(inputVisible.value) || 1;
    valor += cambio;
    if (valor < 1) valor = 1;
    inputVisible.value = valor;
    inputOculto.value = valor;
  }
</script>

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
                            <form method="POST" action="{{ route('favoritos.agregar', $product->id) }}">
              @csrf
              <button type="submit" class="fav-btn"> ❤ </button>
              </form>
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
