@extends('layouts.adminplantilla')

@section('titulo', 'Pedidos en curso')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">🚚 Pedidos en Curso</h2>
        <p class="text-muted">Pedidos que han sido confirmados y están en camino a su destino.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    @if (session('info'))
        <div class="alert alert-info shadow-sm">{{ session('info') }}</div>
    @endif

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-bordered align-middle text-center table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pedidos as $pedido)
                    <tr>
                        <td class="fw-semibold">{{ $pedido->codigo_pedido }}</td>
                        <td>{{ $pedido->usuario->name }}</td>
                        <td>S/ {{ number_format($pedido->total, 2) }}</td>
                        <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                        <td class="d-flex flex-column align-items-center gap-2">

                            <!-- Ver boleta -->
                            <a href="{{ route('boleta.descargar', $pedido->id) }}" class="btn btn-outline-primary btn-sm shadow-sm" target="_blank">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Ver boleta
                            </a>

                            <!-- Formulario para subir foto de entrega -->
                            <form id="form-entrega-{{ $pedido->id }}" method="POST" action="{{ route('admin.pedido.entregar', $pedido->id) }}" enctype="multipart/form-data" class="w-100">
                                @csrf

                                <div class="mb-2">
                                    <input type="file" name="foto_entrega" id="foto_entrega_{{ $pedido->id }}" class="form-control form-control-sm" accept="image/*" required onchange="validarImagen({{ $pedido->id }})">
                                    <small class="text-muted">📷 Sube una foto como prueba de entrega</small>
                                </div>

                                <!-- Botón para confirmar entrega -->
                                <button type="button" id="btnConfirmarEntrega_{{ $pedido->id }}" class="btn btn-success btn-sm shadow-sm w-100" data-bs-toggle="modal" data-bs-target="#entregarPedidoModal{{ $pedido->id }}" disabled>
                                    <i class="bi bi-box-seam me-1"></i> Marcar entregado
                                </button>

                                <!-- Modal de confirmación -->
                                <div class="modal fade" id="entregarPedidoModal{{ $pedido->id }}" tabindex="-1" aria-labelledby="entregarPedidoLabel{{ $pedido->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="entregarPedidoLabel{{ $pedido->id }}">Confirmar entrega</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro que el pedido <strong>{{ $pedido->codigo_pedido }}</strong> fue entregado al cliente?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">✅ Sí, entregar</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="alert alert-info m-0 text-center">
                                🕐 Aún no hay pedidos en curso. Aquí aparecerán los que estén listos para entregar.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        {{ $pedidos->links() }}
    </div>
</div>

<!-- Script para validar carga de imagen -->
<script>
    function validarImagen(pedidoId) {
        const input = document.getElementById(`foto_entrega_${pedidoId}`);
        const boton = document.getElementById(`btnConfirmarEntrega_${pedidoId}`);
        boton.disabled = !input.files.length;
    }
</script>
@endsection
