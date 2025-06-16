<!-- resources/views/partials/header.blade.php -->
<header>
    <div class="logo">
      <img src="{{ asset('imagenes/logo.png') }}" alt="Logo" />
      <div class="logo-text">
        <h1>I LIKE YOU</h1>
        <span>(Importaciones)</span>
      </div>
    </div>
    <div class="right-section">
  @auth
    <div class="user-info">
      👤 {{ Auth::user()->name }}
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" style="margin-left: 10px;">Cerrar sesión</button>
      </form>
    </div>
  @else
    <div class="actions">
      <a href="{{ route('login') }}"><button class="login">Iniciar sesión</button></a>
      <a href="{{ route('register') }}"><button class="register">Registrarse</button></a>
    </div>
  @endauth
  <div class="cart">🛒</div>
</div>

  </header>
