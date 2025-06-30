<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - @yield('titulo')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    @include('partials.adminheader')

    <div class="admin-layout">
        @include('partials.adminsidebar')

        <main class="admin-main">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS (necesario para modales y componentes interactivos) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
