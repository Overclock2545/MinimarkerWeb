@extends('layouts.adminplantilla')

@section('titulo', 'Análisis de Ventas')

@section('content')
<h2 class="mb-4">📊 Análisis de Ventas</h2>

<!-- Filtros -->
<form method="GET" action="{{ route('admin.analisis') }}" class="row g-3 mb-4">
    <input type="hidden" name="orden" value="{{ request('orden', 'desc') }}">
    <div class="col-md-3">
    <label for="desde" class="form-label">Desde</label>
    <input type="date" id="desde" name="desde" class="form-control" value="{{ $desde }}">
  </div>
  <div class="col-md-3">
    <label for="hasta" class="form-label">Hasta</label>
    <input type="date" id="hasta" name="hasta" class="form-control" value="{{ $hasta }}">
  </div>
  <div class="col-md-3 align-self-end">
    <button type="submit" class="btn btn-primary w-100">🔍 Filtrar</button>
  </div>
</form>

<!-- Estadísticas -->
<div class="row mb-4">
  <div class="col-md-3">
    <div class="card text-white bg-primary shadow">
      <div class="card-body">
        <h6>Total de Ventas</h6>
        <h4>S/ {{ number_format($totalVentas, 2) }}</h4>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-white bg-success shadow">
      <div class="card-body">
        <h6>Productos Vendidos</h6>
        <h4>{{ $totalProductosVendidos }}</h4>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-white bg-info shadow">
      <div class="card-body">
        <h6>Pedidos Confirmados</h6>
        <h4>{{ $totalPedidos }}</h4>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-white bg-dark shadow">
      <div class="card-body">
        <h6>Clientes Únicos</h6>
        <h4>{{ $clientesUnicos }}</h4>
      </div>
    </div>
  </div>
</div>

<!-- Tabla de productos vendidos -->
<div class="card">
  <div class="card-header">
    🛒 Productos Vendidos
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped m-0">
        <thead class="table-light">
          <tr>
            <th>Producto</th>
            <th>
  Cantidad Vendida
  <a href="{{ route('admin.analisis', array_merge(request()->all(), ['orden' => request('orden') === 'asc' ? 'desc' : 'asc'])) }}"
     class="ms-1 text-decoration-none">
    @if(request('orden') === 'asc')
      ⬆️
    @else
      ⬇️
    @endif
  </a>
</th>

            <th>Precio Promedio</th>
            <th>Total Recaudado</th>
          </tr>
        </thead>
        <tbody>
          @forelse($productosVendidos as $producto)
            <tr>
              <td>{{ $producto['nombre'] }}</td>
              <td>{{ $producto['cantidad_total'] }}</td>
              <td>S/ {{ number_format($producto['precio_promedio'], 2) }}</td>
              <td>S/ {{ number_format($producto['suma_total'], 2) }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center text-muted">No se encontraron ventas en este periodo.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
