@extends('layouts.adminplantilla')

@section('titulo', 'Ofertas de Productos')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">🏷️ Gestión de Ofertas</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->has('precio_oferta'))
        <div class="alert alert-danger">
            ⚠️ El precio de oferta debe cumplir con todas estas condiciones:
            <ul class="mb-0">
                <li>Debe ser un número positivo.</li>
                <li>No puede tener más de dos decimales.</li>
                <li>Debe ser menor que el precio original.</li>
            </ul>
        </div>
    @endif

    <form method="GET" action="{{ route('admin.ofertas') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="codigo" class="form-control" placeholder="Buscar por código" value="{{ request('codigo') }}">
        </div>
        <div class="col-md-3">
            <select name="categoria_id" class="form-select">
                <option value="">-- Todas las categorías --</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">🔍 Filtrar</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.ofertas') }}" class="btn btn-secondary w-100">🔄 Limpiar</a>
        </div>
    </form>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
    <tr>
        <th class="text-center">Imagen</th>
        <th class="text-center">Código</th>
        <th class="text-center">Nombre</th>
        <th class="text-center">Precio normal</th>
        <th class="text-center">Precio oferta y fecha de expiración</th>
        <th class="text-center">Actualizar</th>
    </tr>
</thead>

        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>
                        <img src="{{ asset($producto->imagen) }}" alt="{{ $producto->nombre }}"
     style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #ccc;">

                    </td>
                    <td>{{ $producto->id }}</td>
                    <td>
                        {{ $producto->nombre }}
                        @if($producto->precio_oferta)
                            <span class="badge bg-success ms-2">En oferta</span>
                        @endif
                    </td>
                    <td>S/. {{ number_format($producto->precio, 2) }}</td>
                    <td>
                        <form id="form-oferta-{{ $producto->id }}" action="{{ route('admin.ofertas.actualizar', $producto->id) }}" method="POST" class="d-flex">
                            @csrf
                            <input type="number" name="precio_oferta" step="0.01" class="form-control form-control-sm" style="width: 100px;" 
                                value="{{ $producto->precio_oferta }}" placeholder="Sin oferta">
                                <input type="hidden" name="oferta_activa" value="1">
<input type="date" name="fecha_fin_oferta"
       class="form-control form-control-sm ms-2"
       style="width: 160px;"
       value="{{ $producto->fecha_fin_oferta ? \Carbon\Carbon::parse($producto->fecha_fin_oferta)->toDateString() : '' }}">


                        </form>
                    </td>
                    <td class="text-nowrap">
    <!-- Botón GUARDAR -->
    <button class="btn btn-sm btn-success me-1" data-bs-toggle="modal" data-bs-target="#confirmarModalGuardar{{ $producto->id }}">
        💾 Guardar
    </button>

    <!-- Botón TERMINAR OFERTA -->
    @if($producto->precio_oferta)
        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarModalTerminar{{ $producto->id }}">
            🗑️ Terminar oferta
        </button>
    @else
        <button class="btn btn-sm btn-secondary" disabled>
            🗑️ Terminar oferta
        </button>
    @endif
</td>

                </tr>

                <!-- Modal Guardar -->
                <div class="modal fade" id="confirmarModalGuardar{{ $producto->id }}" tabindex="-1" aria-labelledby="modalGuardarLabel{{ $producto->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalGuardarLabel{{ $producto->id }}">Confirmar cambio</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de que deseas actualizar el precio de oferta de este producto?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-success" onclick="document.getElementById('form-oferta-{{ $producto->id }}').submit()">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Terminar -->
                <div class="modal fade" id="confirmarModalTerminar{{ $producto->id }}" tabindex="-1" aria-labelledby="modalTerminarLabel{{ $producto->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTerminarLabel{{ $producto->id }}">Terminar oferta</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de que deseas eliminar esta oferta?
                            </div>
                            <div class="modal-footer">
                                <form id="form-terminar-{{ $producto->id }}" action="{{ route('admin.ofertas.terminar', $producto->id) }}" method="POST">
                                    @csrf
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </tbody>
    </table>
</div>
@endsection
