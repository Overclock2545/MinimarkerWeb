@extends('layouts.plantilla')

@section('content')
  <div class="products-title">Panel de Administración</div>

  @if(session('success'))
    <div style="color: green; margin-bottom: 10px;">
      {{ session('success') }}
    </div>
  @endif

  <table style="width: 100%; border-collapse: collapse;">
    <thead>
      <tr style="background-color: #f88fa1;">
        <th>Producto</th>
        <th>Stock</th>
        <th>Agregar Stock</th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $product)
        <tr style="border-bottom: 1px solid #ccc;">
          <td>{{ $product->nombre }}</td>
          <td>{{ $product->stock }}</td>
          <td>
            <form action="{{ route('admin.agregar.stock') }}" method="POST" style="display: flex; gap: 5px; align-items: center;">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <input type="number" name="cantidad" value="1" min="1" style="width: 60px;">
              <button type="submit" style="padding: 5px 10px;">➕ Agregar</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
