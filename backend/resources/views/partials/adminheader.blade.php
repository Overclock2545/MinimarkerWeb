<header class="admin-header">
    <a href="{{ url('/admin') }}" class="admin-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
        <div class="logo-text">
            <h1>I LIKE YOU</h1>
            <span>(Importaciones)</span>
        </div>
    </a>

    
    
    <h2 class="admin-title">Panel de Administración</h2>

    <!-- Botón para ir a la tienda -->
    <div class="admin-link ms-auto me-3">
        <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm">🏠 Vista de usuarios</a>
    </div>

    <div class="admin-user">
        👤 {{ Auth::user()->name }}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button>Cerrar sesión</button>
        </form>
    </div>
</header>
