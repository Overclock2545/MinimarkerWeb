<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>I LIKE YOU</title>

    <!-- Estilos rápidos para mostrar catálogo -->
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

        .products-title {
            text-align: center;
            font-size: 24px;
            margin-top: 20px;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
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
            object-fit: cover;
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
        <div>
            @auth
                <strong>Bienvenido, {{ Auth::user()->name }}</strong>
            @endauth
        </div>
    </header>

    <div>
        @yield('content')
    </div>
</body>
</html>
