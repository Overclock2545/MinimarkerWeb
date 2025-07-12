@extends('layouts.adminplantilla')

@section('title', Auth::user()->rol === 'admin' ? 'Editar Usuario' : 'Datos del Usuario')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4" style="color: #9333ea;">
        {{ Auth::user()->rol === 'admin' ? '✏️ Editar Usuario' : '👤 Datos del Usuario' }}
    </h2>

    <div class="card shadow-lg">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.usuarios.actualizar', $usuario->id) }}">
                @csrf
                @method('PUT')

                @php
                    $disabled = Auth::user()->rol !== 'admin' ? 'disabled' : '';
                @endphp

                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" name="name" class="form-control" value="{{ $usuario->name }}" {{ $disabled }}>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" value="{{ $usuario->email }}" {{ $disabled }}>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol:</label>
                    <select name="rol" class="form-select" {{ $disabled }}>
                        <option value="cliente" {{ $usuario->rol == 'cliente' ? 'selected' : '' }}>Cliente</option>
                        <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="encargado_pedidos" {{ $usuario->rol == 'encargado_pedidos' ? 'selected' : '' }}>Encargado de Pedidos</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Celular:</label>
                    <input type="text" name="celular" class="form-control" value="{{ $usuario->celular }}" {{ $disabled }}>
                </div>

                <div class="mb-4">
                    <label class="form-label">DNI:</label>
                    <input type="text" name="documento_identidad" class="form-control" value="{{ $usuario->documento_identidad }}" {{ $disabled }}>
                </div>

                @if(Auth::user()->rol === 'admin')
                    <div class="text-center">
                        <button type="submit" class="btn btn-success px-4">💾 Guardar Cambios</button>
                        <a href="{{ route('admin.usuarios') }}" class="btn btn-secondary ms-2">↩️ Volver</a>
                    </div>
                @else
                    <div class="text-center">
                        <a href="{{ route('admin.usuarios') }}" class="btn btn-secondary">↩️ Volver</a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
