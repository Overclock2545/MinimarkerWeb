<header class="d-flex align-items-center justify-content-between px-4 py-3" style="background-color: #d9b3ff;">
    <!-- Logo -->
    <a href="{{ url('/admin') }}" class="d-flex align-items-center text-decoration-none text-dark">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="50" height="50" class="me-2 rounded-circle border border-white">
        <div>
            <h5 class="mb-0 fw-bold">I LIKE YOU</h5>
            <small class="text-muted">(Importaciones)</small>
        </div>
    </a>

    <!-- Panel de Administración (centrado) -->
    <div class="flex-grow-1 text-center">
        <h5 class="mb-0 text-dark fw-semibold">
            <i class="bi bi-kanban-fill me-1"></i> Panel de Administración
        </h5>
    </div>

    <!-- Botón Vista Usuario y usuario -->
    <div class="d-flex align-items-center gap-3">
        <a href="{{ url('/') }}" class="btn btn-sm" style="background-color: #e6ccff; color: #4a226e;">
            <i class="bi bi-house-door-fill me-1"></i> Vista de usuarios
        </a>

        <span class="text-dark">
            <i class="bi bi-person-fill me-1"></i> {{ Auth::user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button class="btn btn-sm" style="background-color: #f3d6ff; color: #4a226e;">
                <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
            </button>
        </form>
    </div>
</header>
