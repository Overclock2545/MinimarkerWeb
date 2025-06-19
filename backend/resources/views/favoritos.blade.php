@extends('layouts.plantilla')

@section('titulo', 'Mis Favoritos')

@section('content')
<div class="products-title">⭐ MIS FAVORITOS ⭐</div>

@if ($favoritos->isEmpty())
  <p style="text-align: center;">No tienes productos en tu lista de favoritos.</p>
@else
  <div class="products">
    @foreach($favoritos as $favorito)
      @php
        $product = $favorito->producto;
      @endphp
      <div class="product-card">
        <img src="{{ $product->imagen ?? 'https://via.placeholder.com/150' }}" alt="{{ $product->nombre }}">
        <div>
          {{ $product->nombre }}<br>
          <strong>S/. {{ $product->precio }}</strong><br>
          <small>
            Categoría: {{ $product->categoria->nombre ?? 'Sin categoría' }}
          </small>
        </div>

        <form action="{{ route('favoritos.eliminar', $product->id) }}" method="POST" style="margin-top: 10px;">
          @csrf
          @method('DELETE')
          <button style="padding: 6px 12px; background-color: #d9195b; color: white; border: none; border-radius: 4px;">
            ❌ Quitar de favoritos
          </button>
        </form>
      </div>
    @endforeach
  </div>
@endif
@endsection
