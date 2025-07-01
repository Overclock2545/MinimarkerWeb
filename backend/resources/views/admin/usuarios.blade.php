@extends('layouts.adminplantilla')

@section('title', 'Administrar Usuarios')

@section('content')

<div class="container mt-4"> <h2 class="mb-4 text-center" style="color: #a855f7;">👥 Lista de Usuarios</h2>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle shadow-sm">
        <thead class="table-light">
            <tr class="text-center">
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr class="text-center">
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        <span class="badge bg-{{ $usuario->rol === 'admin' ? 'warning text-dark' : 'secondary' }}">
                            {{ ucfirst($usuario->rol) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.usuarios.editar', $usuario->id) }}" class="btn btn-outline-primary btn-sm mb-1">✏️ Editar</a>

                        <a href="{{ route('admin.usuarios.carrito', $usuario->id) }}" class="btn btn-outline-info btn-sm mb-1">🛒 Ver Carrito</a>

                        <!-- Botón que activa el modal -->
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarEliminarModal{{ $usuario->id }}">
                            🗑 Eliminar
                        </button>

                        <!-- Modal de confirmación -->
                        <div class="modal fade" id="confirmarEliminarModal{{ $usuario->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $usuario->id }}" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="modalLabel{{ $usuario->id }}">Confirmar eliminación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                              </div>
                              <div class="modal-body">
                                ¿Estás seguro de eliminar al usuario <strong>{{ $usuario->name }}</strong>? Esta acción no se puede deshacer.
                              </div>
                              <div class="modal-footer">
                                <form action="{{ route('admin.usuarios.eliminar', $usuario->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Fin del modal -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div> @endsection