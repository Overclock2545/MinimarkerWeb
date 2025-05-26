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
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
    }

    .product-card {
      background-color: white;
      border-radius: 6px;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      text-align: center;
      font-size: 18px;
    }

    .product-card img {
      width: 100%;
      height: 200px;
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
    <div class="cart">🛒</div>
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

    <main id="main-content">
      <div class="products-title">GRANDES OFERTAS</div>
      <div class="products">
        <!-- 18 productos -->
        <div class="product-card"><img alt="Producto" /><div>Producto 1<br><strong>S/. 10</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 2<br><strong>S/. 12</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 3<br><strong>S/. 15</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 4<br><strong>S/. 18</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 5<br><strong>S/. 20</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 6<br><strong>S/. 22</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 7<br><strong>S/. 25</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 8<br><strong>S/. 28</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 9<br><strong>S/. 30</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 10<br><strong>S/. 32</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 11<br><strong>S/. 34</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 12<br><strong>S/. 36</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 13<br><strong>S/. 38</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 14<br><strong>S/. 40</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 15<br><strong>S/. 42</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 16<br><strong>S/. 45</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 17<br><strong>S/. 48</strong></div></div>
        <div class="product-card"><img alt="Producto" /><div>Producto 18<br><strong>S/. 50</strong></div></div>
      </div>
    </main>
  </div>
<script>
  // Botón REGISTRARSE
  document.querySelector('.register').addEventListener('click', function () {
    const main = document.getElementById('main-content');
    main.innerHTML = `
      <h2 style="text-align: center;">Registro de nuevo usuario</h2>
      <div style="margin: 30px auto; max-width: 400px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Registre un email" style="width: 100%; margin: 10px 0; padding: 12px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;" />
        
        <label for="password">Contraseña</label>
        <input type="password" id="password" placeholder="Cree una contraseña" style="width: 100%; margin: 10px 0; padding: 12px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;" />
        
        <button style="background-color: #333; color: white; padding: 12px; width: 100%; font-size: 16px; border: none; border-radius: 5px; cursor: pointer;">Registrarse</button>
      </div>
    `;
  });
  // Botón INICIAR SESIÓN
  document.querySelector('.login').addEventListener('click', function () {
    const main = document.getElementById('main-content');
    main.innerHTML = `
      <h2 style="text-align: center;">Inicio de sesión</h2>
      <form style="max-width: 500px; margin: auto; display: flex; flex-direction: column; gap: 10px; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.2);">
        <label>Email
          <input type="email" placeholder="Ingrese su email" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" />
        </label>
        <label>Contraseña
          <input type="password" placeholder="Ingrese contraseña" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" />
        </label>
        <button type="submit" style="background-color: #333; padding: 10px; border: none; border-radius: 4px; color: white;">Iniciar sesión</button>
        <small><a href="#" style="text-align: right; display: block; margin-top: 5px; color: #666;">¿Olvidaste tu contraseña?</a></small>
      </form>
    `;
  });
</script>

</body>
</html>
