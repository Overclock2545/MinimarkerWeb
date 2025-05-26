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
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1000;
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
  margin-top: 70px; /* Debe ser igual o mayor que el alto del header */
}


 .sidebar {
  position: sticky;
  top: 80px; /* La misma altura que el header */
  left: 0;
  width: 200px;
  height: calc(100vh - 80px); /* Altura de la pantalla menos el header */
  overflow-y: auto;
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
  margin-left: 8px; /* Ancho de la sidebar */
  margin-top: 8px; /* Altura del header */
  padding: 20px;
  flex-grow: 1;
  height: calc(100vh - 80px);
  overflow-y: auto;
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
 <div class="logo" id="logo-click" style="cursor: pointer; display: flex; align-items: center; gap: 10px;">
  <img src="https://via.placeholder.com/60" alt="Logo" />
  <div class="logo-text">
    <h1 style="margin: 0;">I LIKE YOU</h1>
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
  <h3 style="text-align: center;">Nuestro catálogo</h3>

  <!-- Contenedor centrado -->
  <div style="display: flex; justify-content: center; gap: 5px; margin-bottom: 10px;">
    <input type="text" placeholder="Buscar" style="flex: 1;" />
    <button>🔍</button>
  </div>

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
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
         <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
        <div class="product-card"></div>
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
  
// Recargar página al hacer clic en el logo
  document.getElementById('logo-click').addEventListener('click', function () {
    location.reload();
  });
  </script>

</body>
</html>
