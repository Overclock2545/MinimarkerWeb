<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $landing->titulo ?? 'Título de la campaña' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background-color: {{ $landing->color_fondo ?? '#f8f9fa' }};
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
        }

        .logo-fixed {
            position: absolute;
            top: 20px;
            right: 20px;
            max-height: 60px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            z-index: 1030;
        }

        .hero {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
            overflow: hidden;
        }

        .hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .hero-text {
            position: relative;
            z-index: 1;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.55);
            padding: 2rem 3rem;
            border-radius: 16px;
            color: #fff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            max-width: 90%;
        }

        .hero-text h1 {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .hero-text p {
            font-size: 1.2rem;
            margin: 0;
        }

        .side-banner {
            position: absolute;
            top: 400px; /* altura de la imagen principal */
            width: 80px;
            height: calc(100% - 400px);
            background-size: cover;
            background-position: center;
            opacity: 0.12;
            z-index: 1;
        }

        .side-banner.left {
            left: 0;
            background-image: url('{{ asset('images/Bandera_Lateral.png') }}');
        }

        .side-banner.right {
            right: 0;
            background-image: url('{{ asset('images/Bandera_Lateral.png') }}');
        }

        .content {
            flex: 1;
            padding: 3rem 1.5rem;
            max-width: 960px;
            margin: auto;
            position: relative;
            z-index: 2;
        }

        .description {
            font-size: 1.15rem;
            line-height: 1.8;
            white-space: pre-line;
        }

        .btn-landing {
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            border-radius: 50px;
            font-weight: 600;
        }

        .video-wrapper iframe,
        .video-wrapper video {
            width: 100%;
            border-radius: 12px;
            margin: 2rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .imagen-secundaria {
            width: 100%;
            border-radius: 12px;
            margin-top: 2rem;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.06);
        }

        .contador {
            font-size: 1.2rem;
            font-weight: bold;
            color: #dc3545;
            margin-top: 1.5rem;
        }

        @media (max-width: 768px) {
            .hero-text {
                padding: 1rem 1.5rem;
            }

            .hero-text h1 {
                font-size: 2rem;
            }

            .hero-text p {
                font-size: 1rem;
            }

            .side-banner {
                display: none;
            }
        }
    </style>
</head>
<body>

    @if($landing->mostrar_logo ?? false)
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-fixed">
    @endif

    <div class="hero">
        <img src="{{ $landing->imagen ? asset('storage/' . $landing->imagen) : 'https://via.placeholder.com/1200x400?text=Imagen+de+campaña' }}" alt="Imagen de campaña">

        <div class="hero-text animate__animated animate__fadeInDown">
            <h1>{{ $landing->titulo }}</h1>
            @if(!empty($landing->subtitulo))
                <p class="animate__animated animate__fadeInUp animate__delay-1s">{{ $landing->subtitulo }}</p>
            @endif
        </div>
    </div>

    <!-- Banderas laterales -->
    <div class="side-banner left"></div>
    <div class="side-banner right"></div>

    <div class="content text-center animate__animated animate__fadeInUp animate__delay-1s">
        @if(($landing->mostrar_contador ?? false) && $landing->fecha_limite)
            <div id="contador" class="contador">
                <i class="bi bi-clock me-2"></i>
                Quedan: cargando...
            </div>
        @endif

        <p class="description">{!! nl2br(e($landing->descripcion)) !!}</p>

        @if(!empty($landing->video_url))
            <div class="video-wrapper">
                @if(Str::contains($landing->video_url, 'youtube'))
                    <iframe src="{{ $landing->video_url }}" frameborder="0" allowfullscreen></iframe>
                @else
                    <video src="{{ asset('storage/' . $landing->video_url) }}" controls></video>
                @endif
            </div>
        @endif

        @if(!empty($landing->imagen_secundaria))
            <img src="{{ asset('storage/' . $landing->imagen_secundaria) }}" class="imagen-secundaria" alt="Detalle adicional">
        @endif

        <div class="mt-4">
            <a href="{{ $landing->link_boton ?? url('/inicio') }}"
               class="btn btn-landing text-white shadow"
               style="background-color: {{ $landing->color_boton ?? '#0d6efd' }};">
                {{ $landing->boton ?? 'Ver más' }}
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @if(($landing->mostrar_contador ?? false) && $landing->fecha_limite)
        <script>
            const fechaLimite = new Date("{{ \Carbon\Carbon::parse($landing->fecha_limite)->format('Y-m-d H:i:s') }}").getTime();
            const contador = document.getElementById("contador");

            const intervalo = setInterval(() => {
                const ahora = new Date().getTime();
                const diferencia = fechaLimite - ahora;

                if (diferencia < 0) {
                    contador.textContent = "⛔ ¡La campaña ha terminado!";
                    clearInterval(intervalo);
                    return;
                }

                const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
                const horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));

                contador.textContent = `🕒 Quedan: ${dias} días, ${horas}h, ${minutos}min`;
            }, 1000);
        </script>
    @endif

</body>
</html>
