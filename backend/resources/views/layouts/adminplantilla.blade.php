<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - @yield('titulo')</title>
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
