<!DOCTYPE html>



<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>I LIKE YOU - Inicio</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #010101;
      color: #333;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      background-color: #fbbacb;
      border-bottom: 1px solid #000;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
    }

    .logo-text h1 {
      margin: 0;
      font-size: 24px;
    }

    .logo-text span {
      font-size: 13px;
      color: #555;
    }

    .right-section {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .actions button {
      padding: 8px 14px;
      border: none;
      border-radius: 4px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }

    .actions .login {
      background-color: #fff;
      color: #333;
    }

    .actions .login:hover {
      background-color: #ddd;
    }

    .actions .register {
      background-color: #333;
      color: #fff;
    }
.user-info {
  display: flex;
  align-items: center;
  gap: 10px;
}
.user-info button {
  background-color: #333;
  color: white;
  border: none;
  padding: 6px 10px;
  border-radius: 4px;
  cursor: pointer;
}

    .actions .register:hover {
      background-color: #222;
    }

    .cart {
      font-size: 24px;
      cursor: pointer;
    }

    .container {
      display: flex;
      min-height: calc(100vh - 70px);
    }

    .sidebar {
      width: 220px;
      background-color: #f88fa1;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .sidebar h3 {
      margin-top: 0;
    }

    .sidebar input[type="text"] {
      width: 100%;
      padding: 6px 10px;
      border: none;
      border-radius: 4px;
      margin-bottom: 10px;
    }

    .sidebar button {
      background-color: #fbbacb;
      border: none;
      padding: 10px;
      border-radius: 4px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .sidebar button:hover {
      background-color: #fba0bc;
    }

    .social {
      display: flex;
      justify-content: space-between;
      font-size: 22px;
      margin-top: auto;
    }

    main {
      flex: 1;
      padding: 20px;
      background-color: #fff;
    }

    .products-title {
      text-align: center;
      font-size: 26px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #d9195b;
    }

    .products {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      gap: 20px;
    }

    .product-card {
      background-color: #fff;
      border-radius: 6px;
      padding: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: transform 0.2s;
    }

    .product-card:hover {
      transform: translateY(-4px);
    }

    .product-card img {
      width: 100%;
      height: 140px;
      object-fit: cover;
      border-radius: 4px;
      margin-bottom: 10px;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-around;
        padding: 10px;
      }

      .sidebar button,
      .sidebar input {
        width: 45%;
        margin: 5px 0;
      }

      main {
        padding: 10px;
      }
    }
  </style>
</head>
<body>

  <header>
    <a href="{{ url('/inicio') }}" style="text-decoration: none; color: inherit;">
  <div class="logo">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" />
    <div class="logo-text">
      <h1>I LIKE YOU</h1>
      <span>(Importaciones)</span>
    </div>
  </div>
</a>

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

  <div class="container">
    <aside class="sidebar">
      <h3>Nuestro catálogo</h3>
      <form action="{{ route('buscar.productos') }}" method="GET" style="display: flex; gap: 5px; flex-direction: column;">
  <input type="text" name="query" placeholder="Buscar..." required>

  <button type="submit">🔍 Buscar</button>
</form>

      <a href="{{ url('/categorias/id/10') }}"><button>Accesorios Varios</button></a>
<a href="{{ url('/categorias/id/5') }}"><button>Artículos de Belleza</button></a>
<a href="{{ url('/categorias/id/1') }}"><button>Carteras y Morrales</button></a>
<a href="{{ url('/categorias/id/12') }}"><button>Cartucheras y Monederos</button></a>
<a href="{{ url('/categorias/id/7') }}"><button>Llaveros</button></a>
<a href="{{ url('/categorias/id/3') }}"><button>Mochilas</button></a>
<a href="{{ url('/categorias/id/4') }}"><button>Papelería Kawaii</button></a>
<a href="{{ url('/categorias/id/9') }}"><button>Prendas y Calzados</button></a>
<a href="{{ url('/categorias/id/11') }}"><button>Servicios</button></a>
<a href="{{ url('/categorias/id/8') }}"><button>Tomatodos y Tazas</button></a>
<a href="{{ url('/categorias/id/13') }}"><button>Utensilios de Cocina</button></a>


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


</body>
</html>

