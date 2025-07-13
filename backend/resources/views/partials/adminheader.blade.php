<header class="d-flex align-items-center justify-content-between px-4 py-3 shadow-sm" style="background-color: #dcd2f5;">
    <!-- Logo -->
    <a href="{{ url('/admin') }}" class="d-flex align-items-center text-decoration-none text-dark">
        <div class="d-flex align-items-center p-2 px-3 rounded-4 shadow-sm me-3" style="background: linear-gradient(135deg, #c4b5fd, #f3cfe3);">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" width="50" height="50" class="me-2 rounded-circle border border-white shadow-sm" style="object-fit: cover;">
            <div>
                <h5 class="mb-0 fw-bold" style="color: #3b0764;">I LIKE YOU</h5>
                <small class="text-muted">(Importaciones)</small>
            </div>
        </div>
    </a>

    <!-- Panel de Administración (centrado) -->
    <div class="flex-grow-1 text-center">
        <h5 class="mb-0 fw-semibold" style="color: #4c1d95;">
            <i class="bi bi-kanban-fill me-1"></i> Panel de Administración
        </h5>
    </div>

    <!-- Botones -->
    <div class="d-flex align-items-center gap-3">
        <a href="{{ url('/') }}" class="btn btn-sm shadow-sm fw-semibold" style="background-color: #d8b4fe; color: #3b0764;">
            <i class="bi bi-house-door-fill me-1"></i> Vista usuario
        </a>

        <span class="text-dark">
            <i class="bi bi-person-fill me-1"></i> {{ Auth::user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button class="btn btn-sm shadow-sm fw-semibold" style="background-color: #f5c2e7; color: #571536;">
                <i class="bi bi-box-arrow-right me-1"></i> Cerrar sesión
            </button>
        </form>
    </div>
</header>
