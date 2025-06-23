@extends('layouts.adminplantilla')

@section('title', 'Administrar Usuarios')

@section('content')
    <h2>Lista de Usuarios</h2>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->rol }}</td>
                    <td>
                     <a href="{{ route('admin.usuarios.editar', $usuario->id) }}">Editar</a>


 |
                       <a href="{{ route('admin.usuarios.carrito', $usuario->id) }}">🛒 Ver Carrito</a>
 |
                      <form action="{{ route('admin.usuarios.eliminar', $usuario->id) }}" method="POST">


                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('¿Estás seguro de eliminar este usuario?')">🗑 Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
