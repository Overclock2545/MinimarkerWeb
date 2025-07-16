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
  <div class="col-md-3">
    <label for="categoria" class="form-label">Categoría</label>
    <select name="categoria" class="form-select">
      <option value="">Todas</option>
      @foreach($categorias as $cat)
        <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
          {{ $cat->nombre }}
        </option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3 align-self-end">
    <button type="submit" class="btn btn-primary w-100">🔍 Filtrar</button>
  </div>
</form>

<!-- Estadísticas principales -->
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

<!-- Métricas adicionales -->
<div class="row mb-4">
  <div class="col-md-3">
    <div class="card text-white bg-warning shadow">
      <div class="card-body">
        <h6>Ticket Promedio</h6>
        <h4>S/ {{ number_format($ticketPromedio, 2) }}</h4>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-white bg-secondary shadow">
      <div class="card-body">
        <h6>Crecimiento</h6>
        <h4>{{ $variacionVentas >= 0 ? '+' : '' }}{{ number_format($variacionVentas, 2) }}%</h4>
      </div>
    </div>
  </div>
</div>

<!-- Productos más vendidos -->
<div class="card mb-4">
  <div class="card-header">
    🔝 Top 5 Productos Más Vendidos
  </div>
  <div class="card-body">
    @if(count($productosTop))
      <ul class="mb-0">
        @foreach($productosTop as $p)
          <li>{{ $p['nombre'] }} - {{ $p['cantidad_total'] }} vendidos</li>
        @endforeach
      </ul>
    @else
      <p class="text-muted">No hay productos más vendidos en este rango.</p>
    @endif
  </div>
</div>

<!-- Alertas de Bajo Stock (colapsable) -->
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span class="text-danger fw-bold">⚠️ Productos con Bajo Stock</span>
    <button class="btn btn-sm btn-outline-danger" type="button" data-bs-toggle="collapse" data-bs-target="#bajoStockCollapse">
      Ver / Ocultar
    </button>
  </div>
  <div id="bajoStockCollapse" class="collapse">
    <div class="card-body">
      @if(count($productosBajoStock))
        <ul class="mb-0">
          @foreach($productosBajoStock as $prod)
            <li>{{ $prod->nombre }} (Stock: {{ $prod->stock }})</li>
          @endforeach
        </ul>
      @else
        <p class="text-muted">No hay productos con bajo stock.</p>
      @endif
    </div>
  </div>
</div>


<!-- Tabla de productos vendidos -->
<div class="card">
  <div class="card-header">
    🛒 Detalle de Productos Vendidos
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
            <th>Total Recaudado</th>
          </tr>
        </thead>
        <tbody>
          @forelse($productosVendidos as $producto)
            <tr>
              <td>{{ $producto['nombre'] }}</td>
              <td>{{ $producto['cantidad_total'] }}</td>
              <td>S/ {{ number_format($producto['suma_total'], 2) }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="text-center text-muted">No se encontraron ventas en este periodo.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
