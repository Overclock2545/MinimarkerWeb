@extends('layouts.adminplantilla')

@section('title', 'Editar Usuario')

@section('content')
    <h2>Editar Usuario: {{ $usuario->name }}</h2>

    <form method="POST" action="{{ route('admin.usuarios.actualizar', $usuario->id)
 }}">
        @csrf
        @method('PUT')

        <label>Nombre:</label>
        <input type="text" name="name" value="{{ $usuario->name }}" required>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $usuario->email }}" required>

        <label>Rol:</label>
        <select name="rol">
            <option value="cliente" {{ $usuario->rol == 'cliente' ? 'selected' : '' }}>Cliente</option>
            <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
        </select>

        <label>Celular:</label>
        <input type="text" name="celular" value="{{ $usuario->celular }}">

        <label>DNI:</label>
        <input type="text" name="documento_identidad" value="{{ $usuario->documento_identidad }}">

        <button type="submit">Guardar Cambios</button>
    </form>
@endsection
