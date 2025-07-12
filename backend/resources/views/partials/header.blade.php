<header class="navbar navbar-expand-lg shadow-sm px-4 py-3" style="background-color: #f3e8ff;">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap">
        {{-- Logo y nombre --}}
        <a href="{{ url('/inicio') }}" class="d-flex align-items-center text-decoration-none me-3">
            <div class="d-flex align-items-center p-2 px-3 rounded-4 shadow-sm" style="background: linear-gradient(135deg, #d8b4fe, #fbcfe8);">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="56" height="56" class="me-3 rounded-circle border border-white shadow" style="object-fit: cover;">
                <div>
                    <h4 class="mb-0 fw-bold" style="color: #4c1d95;">I LIKE YOU</h4>
                    <small class="text-dark" style="font-size: 0.8rem;">(Importaciones)</small>
                </div>
            </div>
        </a>

        {{-- Baner de publicidad --}}
        <div class="flex-grow-1 d-none d-md-block me-3">
            <div class="bg-white border border-purple-200 rounded-3 shadow-sm py-2 px-4 text-center" style="min-height: 60px;">
                <span class="text-muted fw-semibold">📢 Baner de publicidad</span>
            </div>
        </div>

        {{-- Botones de sesión y carrito --}}
        <div class="d-flex align-items-center gap-3">
            @auth
                @if(in_array(Auth::user()->rol, ['admin', 'encargado_pedidos']))
                    <a href="{{ url('/admin') }}" class="btn btn-sm btn-outline-dark rounded-pill fw-semibold" style="background-color: #d6c4f0;">
                        🛠️ Panel de Administración
                    </a>
                @endif

                <div class="d-flex align-items-center gap-2">
<a href="{{ route('perfil') }}" class="d-flex align-items-center gap-2 bg-white rounded-pill shadow-sm px-3 py-1 text-decoration-none" style="border: 1px solid #e0d7ff;">
    <i class="bi bi-person-circle fs-4" style="color: #7c3aed;"></i>
    <span class="fw-semibold text-dark" style="max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
        {{ Auth::user()->name }}
    </span>
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

<a href="{{ route('carrito') }}" class="btn btn-light rounded-circle position-relative shadow-sm p-2" style="width: 48px; height: 48px;">
    <i class="bi bi-cart-fill fs-4" style="color: #7c3aed;"></i>
</a>

        </div>
    </div>
</header>
