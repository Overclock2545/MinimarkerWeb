@extends('layouts.app')

@section('content')
  <div class="container" style="display: flex">
    <!-- Sidebar -->
    <aside class="sidebar" style="width: 200px; background-color: #f88fa1; padding: 20px 10px; display: flex; flex-direction: column; gap: 10px; color: #000;">
      <h3>Nuestro catálogo</h3>
      <input type="text" placeholder="Buscar" style="width: 100%; padding: 6px; border: none; border-radius: 4px;" />
      <button>🔍</button>
      <button>Escolar</button>
      <button>Hogar</button>
      <button>Oficina</button>
      <button>Accesorios</button>
      <button>Moda</button>
      <div class="social" style="display: flex; justify-content: space-around; margin-top: 20px; font-size: 20px;">
        <span>📷</span>
        <span>🎵</span>
        <span>📘</span>
      </div>
    </aside>

    <!-- Productos de la categoría -->
    <main style="flex-grow: 1; padding: 20px;">
      <div class="products-title" style="text-align: center; font-size: 24px; margin-bottom: 20px;">
        {{ $titulo }}
      </div>

      <div class="products" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        @foreach ($productos as $producto)
          <div class="product-card" style="background-color: white; border-radius: 6px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; font-size: 18px;">
            <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/150' }}" alt="{{ $producto->nombre }}" style="width: 100%; height: 200px; object-fit: cover; background-color: #eee; border-radius: 4px; margin-bottom: 8px;">
            <div>{{ $producto->nombre }}<br><strong>S/. {{ $producto->precio }}</strong></div>
          </div>
        @endforeach
      </div>
    </main>
  </div>
@endsection
