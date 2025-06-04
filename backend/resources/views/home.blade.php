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
    <div class="logo">
      <img src="https://via.placeholder.com/60" alt="Logo" />
      <div class="logo-text">
        <h1>I LIKE YOU</h1>
        <span>(Importaciones)</span>
      </div>
    </div>
    <div class="right-section">
      <div class="actions">
        <button class="login">Iniciar sesión</button>
        <button class="register">Registrarse</button>
      </div>
      <div class="cart">🛒</div>
    </div>
  </header>

  <div class="container">
    <aside class="sidebar">
      <h3>Nuestro catálogo</h3>
      <input type="text" placeholder="Buscar..." />
      <button>🔍 Buscar</button>
      <button>Ropa</button>
      <button>Accesorios</button>
      <button>Regalos</button>
      <button>Nuevos</button>
      <button>Ofertas</button>
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
      </div>
    </main>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      fetch("http://localhost:8000/api/productos")
        .then(res => res.json())
        .then(data => {
          const container = document.querySelector(".products");
          container.innerHTML = "";
          data.forEach(p => {
            container.innerHTML += `
              <div class="product-card">
                <img src="${p.imagen || 'https://via.placeholder.com/150'}" alt="${p.nombre}" />
                <div>${p.nombre}<br><strong>S/. ${p.precio}</strong></div>
              </div>`;
          });
        });
    });
  </script>

</body>
</html>
