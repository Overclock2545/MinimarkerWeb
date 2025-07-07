<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'I LIKE YOU')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">


</head>
<body>
    @include('partials.header')

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar-->
        <div class="col-md-2 col-lg-1 col-xl-2 p-0">
            @include('partials.sidebar')
        </div>

        <!-- Contenido principal -->
<main class="col-md-9 col-lg-10 col-xl-10 py-3" style="margin-left: -11px;">
            @yield('content')
        </main>
    </div>
</div>
</body>


</html>
