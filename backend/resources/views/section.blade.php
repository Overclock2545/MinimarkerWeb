@extends('layouts.app') {{-- si tienes un layout base --}}

@section('content')
  <main>
    <div class="products-title">{{ $titulo }}</div>
    <div class="products">
      @foreach ($productos as $producto)
        <div class="product-card">
          <img src="{{ $producto['imagen'] ?? 'https://via.placeholder.com/150' }}" alt="{{ $producto['nombre'] }}">
          <div>{{ $producto['nombre'] }}<br><strong>S/. {{ $producto['precio'] }}</strong></div>
        </div>
      @endforeach
    </div>
  </main>
@endsection
