<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>I LIKE YOU - Inicio</title>
  <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <div class="logo-text">
                <h1>I LIKE YOU</h1>
                <span>(Importaciones)</span>
            </div>
        </div>

        <div class="right-section">
            @auth
                <div class="user-info">
                    <span>{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Cerrar sesión</button>
                    </form>
                </div>
                <a href="{{ route('carrito') }}" class="cart">🛒</a>
            @else
                <div class="actions">
                    <a href="{{ route('login') }}"><button class="login">Iniciar sesión</button></a>
                    <a href="{{ route('register') }}"><button class="register">Registrarse</button></a>
                </div>
            @endauth
        </div>
    </header>

  <div class="container">
    <aside class="sidebar">
      <h3>Nuestro catálogo</h3>
      <input type="text" placeholder="Buscar..." />
      <button>🔍 Buscar</button>
      <a href="{{ url('/categorias/id/101') }}"><button>Escolar</button></a>

      <div class="social">
        <span>📷</span>
        <span>🎵</span>
        <span>📘</span>
      </div>
    </aside>

   <main>
  <div class="products-title">{{ $titulo ?? ($producto->nombre ?? 'GRANDES OFERTAS') }}</div>

  @isset($producto)
    {{-- Mostrar producto individual --}}
    <div style="display: flex; gap: 40px; flex-wrap: wrap;">
      <div style="flex: 1; min-width: 300px;">
        <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/350' }}" alt="{{ $producto->nombre }}" style="width: 100%; max-width: 400px; border-radius: 6px;">
        <div style="font-size: 22px; margin: 10px 0;">{{ $producto->nombre }}</div>
        <div style="font-size: 18px;"><strong>S/. {{ $producto->precio }}</strong></div>
        <div style="margin-top: 10px;">Categoría: {{ $producto->categoria->nombre ?? 'Sin categoría' }}</div>

        <div style="margin-top: 20px; display: flex; align-items: center; gap: 10px;">
          <button>-</button>
          <input type="number" value="1" min="1" style="width: 50px; text-align: center;">
          <button>+</button>
        </div>

        <button style="margin-top: 15px; background-color: #222; color: white; padding: 10px; border: none; border-radius: 4px;">Agregar al carrito 🛒</button>
        <button style="margin-top: 10px; background-color: #fbbacb; border: none; padding: 10px; border-radius: 4px;">Agregar a favoritos ⭐</button>
      </div>

      <div style="flex: 2; min-width: 300px;">
        <h3>Descripción:</h3>
        <p style="max-height: 300px; overflow-y: auto;">
          {{ $producto->descripcion ?? 'Este producto no tiene una descripción.' }}
        </p>
      </div>
    </div>
  @else
    {{-- Mostrar lista de productos --}}
    <div class="products">
      @foreach($products as $product)
        <a href="{{ route('producto.ver', $product->id) }}" style="text-decoration: none; color: inherit;">
  <div class="product-card">
    <img src="{{ $product->imagen ?? 'https://via.placeholder.com/150' }}" alt="{{ $product->nombre }}">
    <div>
      {{ $product->nombre }}<br>
      <strong>S/. {{ $product->precio }}</strong><br>
      <small>
        Categoría: {{ $product->categoria->nombre ?? 'Sin categoría' }}
      </small>
    </div>
  </div>
</a>

      @endforeach
    </div>
  @endisset
</main>




  </div>
</main>
  </div>

</body>
</html>

