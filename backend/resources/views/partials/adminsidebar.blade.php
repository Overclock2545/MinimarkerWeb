<aside class="admin-sidebar p-3" style="background-color: #d9b3ff; min-height: 100vh;">
    <nav class="d-flex flex-column gap-3">
        <a href="{{ route('admin.stock') }}" class="btn btn-sm text-start text-dark" style="background-color: #ecd9ff;">
            <i class="bi bi-tools me-2"></i> Alterar Stock
        </a>

        <a href="{{ route('admin.pedidos') }}" class="btn btn-sm text-start text-dark" style="background-color: #f0d9ff;">
            <i class="bi bi-clock-history me-2"></i> Pedidos Pendientes
        </a>

        <a href="{{ route('admin.pedidos.curso') }}" class="btn btn-sm text-start text-dark" style="background-color: #e6ccff;">
            <i class="bi bi-truck-front-fill me-2"></i> Pedidos en curso
        </a>

        <a href="{{ route('admin.pedidos.historial') }}" class="btn btn-sm text-start text-dark" style="background-color: #f3e0ff;">
            <i class="bi bi-archive-fill me-2"></i> Historial de pedidos
        </a>

        <a href="/admin/usuarios" class="btn btn-sm text-start text-dark" style="background-color: #eed9f7;">
            <i class="bi bi-people-fill me-2"></i> Administrar Usuarios
        </a>

        <a href="{{ route('admin.analisis') }}" class="btn btn-sm text-start text-dark" style="background-color: #e5ccf9;">
            <i class="bi bi-graph-up-arrow me-2"></i> Análisis de Ventas
        </a>
        <a href="{{ route('admin.ofertas') }}" class="btn btn-sm text-start text-dark" style="background-color: #f5e1ff;">
             <i class="bi bi-tags-fill me-2"></i> Ofertas y marketing
        </a>

    </nav>
</aside>
