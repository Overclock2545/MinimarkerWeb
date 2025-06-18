<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'I LIKE YOU')</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>
    {{-- HEADER --}}
    @include('partials.header')
    
    <div class="container">
        {{-- SIDEBAR --}}
        @include('partials.sidebar')

        {{-- CONTENIDO PRINCIPAL --}}
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
