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
        @if(in_array(Auth::user()->rol, ['admin', 'encargado_pedidos']))

    <a href="{{ url('/admin') }}" class="btn btn-sm btn-outline-dark" style="background-color: #d6c4f0;">
        🛠️ Panel de Administración
        

    </a>
@endif

            @auth
@endauth

            <div class="d-flex align-items-center gap-2">

        <a href="{{ route('perfil') }}" class="perfil-hover text-dark text-decoration-none" id="linkPerfil">
        <i class="bi bi-person-circle" style="color: #7b4295;"></i>
        <span id="perfilNombre">{{ Auth::user()->name }}</span>
        </a>




    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-sm btn-outline-secondary">
            Cerrar sesión
        </button>
    </form>
</div>

        @else
            <div class="d-flex gap-2">
                <!-- Botón que abre el modal de inicio de sesión -->
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
            Iniciar sesión
            </button>

                <!-- Botón que abre el modal de registro -->
        <button class="btn btn-sm btn-primary" style="background-color: #e4c5f5; border-color: #e4c5f5;" data-bs-toggle="modal" data-bs-target="#registerModal">
            Registrarse
        </button>

            </div>
        @endauth

        <a href="{{ route('carrito') }}" class="btn btn-sm text-dark">
            <i class="bi bi-cart-fill" style="color: #b68df1;"></i>
        </a>

        
    </div>
</header>
