@extends('layouts.plantilla')

@section('titulo', 'Mis Favoritos')

@section('content')
<div class="products-title text-center mb-4">⭐ MIS FAVORITOS ⭐</div>

@if ($favoritos->isEmpty())
  <p style="text-align: center;">No tienes productos en tu lista de favoritos.</p>
@else
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
    @foreach($favoritos as $favorito)
      @if ($favorito->producto)
        @php $product = $favorito->producto; @endphp
        <div class="col">
          <div class="card product-card h-100 position-relative">
            <a href="{{ route('producto.ver', $product->id) }}" class="text-decoration-none text-dark">
              <img src="{{ $product->imagen ?? 'https://via.placeholder.com/150' }}"
                   alt="{{ $product->nombre }}"
                   class="card-img-top"
                   style="height: 250px; object-fit: contain;">
              <div class="card-body text-center">
                <h6 class="mb-1">{{ $product->nombre }}</h6>
                <p class="mb-1 text-success"><strong>S/. {{ $product->precio }}</strong></p>
                <small class="text-muted">Categoría: {{ $product->categoria->nombre ?? 'Sin categoría' }}</small>
              </div>
            </a>

            <div class="product-actions p-2">
              <form method="POST" action="{{ route('carrito.agregar', $product->id) }}" class="mb-2">
                @csrf
                <button type="submit" class="btn btn-dark w-100">🛒 Agregar al carrito</button>
              </form>
              <form method="POST" action="{{ route('favoritos.eliminar', $product->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger w-100">❌ Quitar de favoritos</button>
              </form>
            </div>
          </div>
        </div>
      @else
        <p style="color: red;">⚠️ Un producto de tu lista fue eliminado.</p>
      @endif
    @endforeach
  </div>
@endif
@endsection
