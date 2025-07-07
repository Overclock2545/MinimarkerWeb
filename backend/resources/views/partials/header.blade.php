<header class="navbar navbar-expand-lg border-0 px-4 py-3" style="background-color: #f3e8ff;">
    <a href="{{ url('/inicio') }}" class="d-flex align-items-center text-decoration-none me-auto">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="50" class="me-2">
        <div>
            <h5 class="mb-0" style="color: #7b4295;">I LIKE YOU</h5>
            <small class="text-muted" style="font-size: 0.75rem;">(Importaciones)</small>
        </div>
    </a>

    <div class="d-flex align-items-center gap-3">
        @auth
        @if(Auth::user()->rol === 'admin')
    <a href="{{ url('/admin') }}" class="btn btn-sm btn-outline-dark" style="background-color: #d6c4f0;">
        🛠️ Panel de Administración
    </a>
@endif

            @auth

        <a href="{{ route('pedidos') }}" class="btn btn-sm" style="background-color: #e0ccff; color: #4b2765;" data-bs-toggle="tooltip" title="Ver tus pedidos">
    📦 Mis Pedidos
        </a>

@endauth

            <div class="d-flex align-items-center gap-2">
                <span class="text-dark">
                    <i class="bi bi-person-circle" style="color: #7b4295;"></i> {{ Auth::user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-secondary">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        @else
            <div class="d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
                    Iniciar sesión
                </a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-primary" style="background-color: #e4c5f5; border-color: #e4c5f5;">
                    Registrarse
                </a>
            </div>
        @endauth

        <a href="{{ route('favoritos') }}" class="btn btn-sm text-dark">
            <i class="bi bi-star-fill" style="color: #ff9edb;"></i>
        </a>
        <a href="{{ route('carrito') }}" class="btn btn-sm text-dark">
            <i class="bi bi-cart-fill" style="color: #b68df1;"></i>
        </a>

        
    </div>
</header>

