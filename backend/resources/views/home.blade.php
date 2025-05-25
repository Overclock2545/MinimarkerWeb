<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>I LIKE YOU - Inicio</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #ffe6ea;
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
    }

    .logo-text {
      line-height: 1.2;
    }

    .logo-text h1 {
      font-size: 24px;
      margin: 0;
    }

    .logo-text span {
      font-size: 14px;
    }

    .actions button {
      margin: 0 5px;
      padding: 8px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .actions .login {
      background-color: #eee;
    }

    .actions .register {
      background-color: #333;
      color: white;
    }

    .cart {
      font-size: 24px;
    }

    .container {
      display: flex;
    }

    .sidebar {
      width: 200px;
      background-color: #f88fa1;
      padding: 20px 10px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      color: #000;
    }

    .sidebar input[type="text"] {
      width: 100%;
      padding: 6px;
      border: none;
      border-radius: 4px;
    }

    .sidebar button {
      background-color: #fbbacb;
      border: none;
      padding: 10px;
      border-radius: 4px;
      cursor: pointer;
    }

    .social {
      display: flex;
      justify-content: space-around;
      margin-top: 20px;
      font-size: 20px;
    }

    main {
      flex-grow: 1;
      padding: 20px;
    }

    .products-title {
      text-align: center;
      font-size: 24px;
      margin-bottom: 20px;
    }

    .products {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      gap: 20px;
    }

    .product-card {
      background-color: white;
      border-radius: 6px;
      padding: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      text-align: center;
    }

    .product-card img {
      width: 100%;
      height: 120px;
      background-color: #eee;
      border-radius: 4px;
      margin-bottom: 8px;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
      <img src="https://via.placeholder.com/60" alt="Logo" />
      <div class="logo-text">
        <h1>I LIKE YOU</h1>
        <span>(Importaciones)</span>
      </div>
    </div>
    <div class="actions">
      <button class="login">Iniciar sesión</button>
      <button class="register">Registrarse</button>
    </div>
    <div class="cart">
      🛒
    </div>
  </header>

  <div class="container">
    <aside class="sidebar">
      <h3>Nuestro catálogo</h3>
      <input type="text" placeholder="Buscar" />
      <button>🔍</button>
      <button>Sección</button>
      <button>Sección</button>
      <button>Sección</button>
      <button>Sección</button>
      <button>Sección</button>
      <button>Sección</button>
      <div class="social">
        <span>📷</span>
        <span>🎵</span>
        <span>📘</span>
      </div>
    </aside>

    <main>
      <div class="products-title">GRANDES OFERTAS</div>
      <div class="products">
        <div class="product-card">
          <img alt="Producto" />
          <div>Producto<br><strong>S/.</strong></div>
        </div>
        <div class="product-card">
          <img alt="Producto" />
          <div>Producto<br><strong>S/.</strong></div>
        </div>
        <div class="product-card">
          <img alt="Producto" />
          <div>Producto<br><strong>S/.</strong></div>
        </div>
        <div class="product-card">
          <img alt="Producto" />
          <div>Producto<br><strong>S/.</strong></div>
        </div>
        <div class="product-card">
          <img alt="Producto" />
          <div>Producto<br><strong>S/.</strong></div>
        </div>
        <div class="product-card">
          <img alt="Producto" />
          <div>Producto<br><strong>S/.</strong></div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>