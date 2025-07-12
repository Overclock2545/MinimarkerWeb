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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    


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
<!-- Modal de inicio de sesión -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background-color: #f3e8ff;">
        <h5 class="modal-title" id="loginModalLabel">Iniciar sesión</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <!-- Formulario de login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input id="email" type="email" class="form-control" name="email" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>

            <div class="form-check mb-3">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label class="form-check-label" for="remember_me">Recuérdame</label>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary">Ingresar</button>
                @if (Route::has('password.request'))
                    <a href="#" onclick="abrirModalRecuperar()" class="text-decoration-none">
    ¿Olvidaste tu contraseña?
</a>





                @endif
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal de registro -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background-color: #f3e8ff;">
        <h5 class="modal-title" id="registerModalLabel">Crear una cuenta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <!-- Modal: Recuperar contraseña -->




        <!-- Formulario de registro -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nombre completo</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Registrarme</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal: Olvidé mi contraseña -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forgotPasswordLabel">🔒 Recuperar contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="modal-body">
          <p class="mb-2">Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.</p>
          <div class="mb-3">
            <label for="forgotEmail" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="forgotEmail" name="email" required autofocus>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">📩 Enviar enlace</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
    function abrirModalRecuperar() {
        // Cierra el modal de login correctamente
        const loginModalEl = document.getElementById('loginModal');
        const loginModal = bootstrap.Modal.getInstance(loginModalEl);
        if (loginModal) {
            loginModal.hide();
        }

        // Espera que termine de cerrarse y luego abre el de recuperación
        loginModalEl.addEventListener('hidden.bs.modal', function () {
            const forgotModalEl = document.getElementById('forgotPasswordModal');
            const forgotModal = new bootstrap.Modal(forgotModalEl);
            forgotModal.show();
        }, { once: true });
    }

    // 🔧 Solución para el botón "Cancelar" del modal de recuperación
    document.addEventListener('DOMContentLoaded', function () {
        const forgotModalEl = document.getElementById('forgotPasswordModal');
        forgotModalEl.addEventListener('hidden.bs.modal', function () {
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
        });
    });
</script>



</body>


</html>
