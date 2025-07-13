<aside class="p-3 shadow-lg border-end h-100" style="background-color: #d9b3ff; min-height: 100vh;">
    <h5 class="text-center mb-4 text-dark fw-bold" style="color: #4c1d95;">Panel de Gestión</h5>

    @php
        use Illuminate\Support\Facades\Auth;
        $rol = Auth::user()->rol;
    @endphp

    <nav class="d-grid gap-2 px-2">

        {{-- Solo para admin --}}
        @if($rol === 'admin')
            <a href="{{ route('admin.stock') }}" class="btn btn-sm text-start text-dark shadow-sm fw-semibold" style="background-color: #ecd9ff;">
                <i class="bi bi-tools me-2"></i> Alterar Stock
            </a>
        @endif

        <a href="{{ route('admin.pedidos') }}" class="btn btn-sm text-start text-dark shadow-sm fw-semibold" style="background-color: #f0d9ff;">
            <i class="bi bi-clock-history me-2"></i> Pedidos Pendientes
        </a>

        <a href="{{ route('admin.pedidos.curso') }}" class="btn btn-sm text-start text-dark shadow-sm fw-semibold" style="background-color: #e6ccff;">
            <i class="bi bi-truck-front-fill me-2"></i> Pedidos en curso
        </a>

        <a href="{{ route('admin.pedidos.historial') }}" class="btn btn-sm text-start text-dark shadow-sm fw-semibold" style="background-color: #f3e0ff;">
            <i class="bi bi-archive-fill me-2"></i> Historial de pedidos
        </a>

        <a href="/admin/usuarios" class="btn btn-sm text-start text-dark shadow-sm fw-semibold" style="background-color: #eed9f7;">
            <i class="bi bi-people-fill me-2"></i> Administrar Usuarios
        </a>

        @if($rol === 'admin')
            <a href="{{ route('admin.analisis') }}" class="btn btn-sm text-start text-dark shadow-sm fw-semibold" style="background-color: #e5ccf9;">
                <i class="bi bi-graph-up-arrow me-2"></i> Análisis de Ventas
            </a>

            {{-- Ofertas y marketing (submenú) --}}
<div class="d-grid gap-2">
    <button class="btn btn-sm text-start text-dark" style="background-color: #f5e1ff;" type="button" data-bs-toggle="collapse" data-bs-target="#submenuMarketing">
        <i class="bi bi-tags-fill me-2"></i> Ofertas y marketing
    </button>
    <div class="collapse ms-3" id="submenuMarketing">
        <a href="{{ route('admin.ofertas') }}" class="btn btn-sm text-start text-dark" style="background-color: #fbefff;">
            <i class="bi bi-ui-checks-grid me-2"></i> Gestionar Ofertas
        </a>
        <a href="{{ route('admin.banner') }}" class="btn btn-sm text-start text-dark" style="background-color: #fbefff;">
            <i class="bi bi-easel2-fill me-2"></i> Editar Banner
        </a>
    </div>
</div>

        @endif

    </nav>
</aside>
