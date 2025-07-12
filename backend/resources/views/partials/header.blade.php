<header class="navbar navbar-expand-lg shadow-sm px-4 py-3" style="background-color: #f3e8ff;">
    <a href="{{ url('/inicio') }}" class="d-flex align-items-center text-decoration-none me-auto">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="48" height="48" class="me-2 rounded shadow-sm" style="object-fit: cover;">
        <div>
            <h5 class="mb-0 fw-bold" style="color: #7b4295;">I LIKE YOU</h5>
            <small class="text-muted" style="font-size: 0.75rem;">(Importaciones)</small>
        </div>
    </a>

    <div class="d-flex align-items-center gap-3">
        @auth
            @if(in_array(Auth::user()->rol, ['admin', 'encargado_pedidos']))
                <a href="{{ url('/admin') }}" class="btn btn-sm btn-outline-dark rounded-pill fw-semibold" style="background-color: #d6c4f0;">
                    🛠️ Panel de Administración
                </a>
            @endif

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('perfil') }}" class="text-dark text-decoration-none d-flex align-items-center gap-1">
                    <i class="bi bi-person-circle fs-5" style="color: #7b4295;"></i>
                    <span>{{ Auth::user()->name }}</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-secondary rounded-pill fw-semibold">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        @else
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary rounded-pill fw-semibold" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Iniciar sesión
                </button>

                <button class="btn btn-sm btn-primary rounded-pill fw-semibold" style="background-color: #e4c5f5; border-color: #e4c5f5;" data-bs-toggle="modal" data-bs-target="#registerModal">
                    Registrarse
                </button>
            </div>
        @endauth

        <a href="{{ route('carrito') }}" class="btn btn-sm position-relative text-dark">
            <i class="bi bi-cart-fill fs-5" style="color: #b68df1;"></i>
        </a>
    </div>
</header>
