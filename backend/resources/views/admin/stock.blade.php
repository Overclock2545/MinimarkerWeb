@extends('layouts.adminplantilla')

@section('titulo', 'Alterar Stock')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">🛠️ ALTERAR STOCK</h2>

    <div class="row justify-content-center">
        {{-- Gestionar Productos --}}
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm card-hover border-0">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam fs-1 mb-2"></i>
                    <h5 class="card-title">Gestionar Productos</h5>
                    <p class="card-text">Buscar, editar, aumentar/disminuir stock o eliminar productos.</p>
                    <a href="{{ route('admin.productos.gestionar') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        {{-- Agregar Producto --}}
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm card-hover border-0">
                <div class="card-body text-center">
                    <i class="bi bi-plus-square fs-1 mb-2"></i>
                    <h5 class="card-title">Agregar Producto</h5>
                    <p class="card-text">Registra un nuevo producto al catálogo.</p>
                    <a href="{{ route('admin.productos.nuevo') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        {{-- Gestionar Categorías --}}
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm card-hover border-0">
                <div class="card-body text-center">
                    <i class="bi bi-tags fs-1 mb-2"></i>
                    <h5 class="card-title">Gestionar Categorías</h5>
                    <p class="card-text">Crea, edita o elimina categorías del sistema.</p>
                    <a href="{{ route('admin.categorias') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
