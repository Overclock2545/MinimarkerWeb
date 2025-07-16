<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $landing->titulo ?? 'Título de la campaña' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: {{ $landing->color_fondo ?? '#ffffff' }};
            color: #212529;
            font-family: 'Segoe UI', sans-serif;
            position: relative;
        }

        .logo-fixed {
            position: absolute;
            top: 20px;
            right: 20px;
            max-height: 48px;
            opacity: 0.85;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 50%;
            background: #fff;
        }

        .hero img {
            width: 100%;
            height: auto;
            aspect-ratio: 1200 / 360;
            object-fit: cover;
            display: block;
            border-bottom: 2px solid #eee;
        }

        .content {
            max-width: 880px;
            margin: 0 auto;
            padding: 3rem 1.5rem;
        }

        .title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 2rem;
        }

        .description {
            font-size: 1.1rem;
            line-height: 1.8;
            white-space: pre-line;
            margin-bottom: 2.5rem;
        }

        .btn-landing {
            padding: 0.75rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            border: none;
        }

        .video-wrapper iframe,
        .video-wrapper video {
            width: 100%;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .imagen-secundaria {
            width: 100%;
            height: auto;
            max-height: 180px;
            object-fit: cover;
            border-radius: 12px;
            margin-top: 2rem;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.06);
        }

        .contador {
            font-size: 1.15rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            color: #b91c1c;
        }

        @media (max-width: 768px) {
            .title {
                font-size: 2rem;
            }
            .description {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    @if($landing->mostrar_logo ?? false)
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-fixed">
    @endif

    <div class="hero">
        <img src="{{ $landing->imagen ? asset('storage/' . $landing->imagen) : 'https://via.placeholder.com/1200x360?text=Imagen+de+campaña' }}" alt="Imagen de campaña">
    </div>

    <div class="content text-center">
        <h1 class="title">{{ $landing->titulo }}</h1>

        @if(!empty($landing->subtitulo))
            <p class="subtitle">{{ $landing->subtitulo }}</p>
        @endif

        @if(($landing->mostrar_contador ?? false) && $landing->fecha_limite)
            <div id="contador" class="contador">Quedan: cargando...</div>
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

        <div class="text-center mt-4">
            <a href="{{ $landing->link_boton ?? url('/inicio') }}"
               class="btn btn-landing text-white shadow"
               style="background-color: {{ $landing->color_boton ?? '#111827' }};">
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
                    contador.textContent = "¡La campaña ha terminado!";
                    clearInterval(intervalo);
                    return;
                }

                const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
                const horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));

                contador.textContent = `Quedan: ${dias} días, ${horas}h, ${minutos}min`;
            }, 1000);
        </script>
    @endif

</body>
</html>
