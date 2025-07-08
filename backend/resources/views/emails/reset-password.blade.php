<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdf6ff;
            color: #4a226e;
            padding: 2rem;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border: 1px solid #e9d6f7;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 0 15px rgba(203, 159, 255, 0.2);
        }

        h1 {
            color: #7b4295;
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #e6ccff;
            color: #4a226e;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            margin: 2rem 0;
        }

        .footer {
            font-size: 0.9rem;
            color: #777;
            margin-top: 2rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>💜 I LIKE YOU</h1>
        <p>Hola <strong>{{ $name }}</strong>,</p>

        <p>Hemos recibido una solicitud para restablecer tu contraseña.</p>

        <p>Haz clic en el siguiente botón para continuar:</p>

        <div style="text-align: center;">
            <a href="{{ $url }}" class="btn">Restablecer contraseña</a>
        </div>

        <p>Si no solicitaste este cambio, puedes ignorar este correo.</p>

        <div class="footer">
            &copy; {{ date('Y') }} I LIKE YOU Importaciones<br>
            Tu tienda de confianza 💖
        </div>
    </div>
</body>
</html>
