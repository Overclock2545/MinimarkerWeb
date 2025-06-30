<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - @yield('titulo')</title>
    <!-- llamado a bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

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

</body>
</html>
