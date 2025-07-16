<aside class="p-3 shadow-lg border-end h-100" style="background-color: #eae4f4; min-height: 100vh;">
    <h5 class="text-center mb-4 fw-bold" style="color: #3c096c;">Panel de Gestión</h5>

    @php
        use Illuminate\Support\Facades\Auth;
        $rol = Auth::user()->rol;
    @endphp

    <nav class="d-grid gap-3 px-2">

        @if($rol === 'admin')
            <a href="{{ route('admin.stock') }}" class="btn text-start fw-semibold text-dark shadow-sm border" style="background-color: #d8c7ef; border-color: #c4b3df;">
                <i class="bi bi-tools me-2"></i> Alterar Stock
            </a>
        @endif

        <a href="{{ route('admin.pedidos') }}" class="btn text-start fw-semibold text-dark shadow-sm border" style="background-color: #ddc7f0; border-color: #cbb3df;">
            <i class="bi bi-clock-history me-2"></i> Pedidos Pendientes
        </a>

        <a href="{{ route('admin.pedidos.curso') }}" class="btn text-start fw-semibold text-dark shadow-sm border" style="background-color: #dac4ed; border-color: #bda8d7;">
            <i class="bi bi-truck-front-fill me-2"></i> Pedidos en curso
        </a>

        <a href="{{ route('admin.pedidos.historial') }}" class="btn text-start fw-semibold text-dark shadow-sm border" style="background-color: #e2cff7; border-color: #d3bde7;">
            <i class="bi bi-archive-fill me-2"></i> Historial de pedidos
        </a>

        <a href="/admin/usuarios" class="btn text-start fw-semibold text-dark shadow-sm border" style="background-color: #d8c8eb; border-color: #bfaed5;">
            <i class="bi bi-people-fill me-2"></i> Administrar Usuarios
        </a>

        @if($rol === 'admin')
            <a href="{{ route('admin.analisis') }}" class="btn text-start fw-semibold text-dark shadow-sm border" style="background-color: #d6c6ec; border-color: #bbaad3;">
                <i class="bi bi-graph-up-arrow me-2"></i> Análisis de Ventas
            </a>

            <div class="d-grid gap-2">
                <button class="btn text-start fw-semibold text-dark shadow-sm border" style="background-color: #e0d0f4; border-color: #c6b4db;" type="button" data-bs-toggle="collapse" data-bs-target="#submenuMarketing">
                    <i class="bi bi-tags-fill me-2"></i> Ofertas y marketing
                </button>
                <div class="collapse ms-3" id="submenuMarketing">
                    <a href="{{ route('admin.ofertas') }}" class="btn btn-sm text-start text-dark fw-semibold shadow-sm border" style="background-color: #f2e4fb; border-color: #d9cae3;">
                        <i class="bi bi-ui-checks-grid me-2"></i> Gestionar Ofertas
                    </a>
                    <a href="{{ route('admin.banner.selector') }}" class="btn btn-sm text-start text-dark fw-semibold shadow-sm border" style="background-color: #f2e4fb; border-color: #d9cae3;">
                    <i class="bi bi-easel2-fill me-2"></i> Editar Banners
                    </a>

                </div>
            </div>
        @endif

    </nav>
</aside>
