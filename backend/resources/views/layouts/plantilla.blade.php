<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'I LIKE YOU')</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>

  @include('partials.header')

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2 col-lg-1 col-xl-2 p-0">
        @include('partials.sidebar')
      </div>
      <main class="col-md-9 col-lg-10 col-xl-10 py-3" style="margin-left: -11px;">
        @yield('content')
      </main>
    </div>
  </div>

  <!-- Modal: Iniciar sesión -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow">
        <div class="modal-header" style="background-color: #f3e8ff;">
          <h5 class="modal-title" id="loginModalLabel">Iniciar sesión</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
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
            <div class="d-flex justify-content-between align-items-center mb-2">
              <button type="submit" class="btn btn-primary">Ingresar</button>
              <a href="#" onclick="abrirModalRecuperar()" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
            </div>
          </form>

          <hr class="my-4">
          <div class="text-center">
            <p class="text-muted mb-2">¿Aún no tienes una cuenta?</p>
            <button class="btn btn-outline-primary rounded-pill px-4 fw-semibold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">
              <i class="bi bi-person-plus-fill me-1"></i> Regístrate gratis
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal: Registro -->
  <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow">
        <div class="modal-header" style="background-color: #f3e8ff;">
          <h5 class="modal-title" id="registerModalLabel">Crear una cuenta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
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
              <label for="password" class="form-label">Contraseña (mínimo 8 caracteres)</label>
              <input id="password" type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
              <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrarme</button>
          </form>

          <hr class="my-4">
          <div class="text-center">
            <p class="text-muted mb-2">¿Ya tienes una cuenta?</p>
            <button class="btn btn-outline-secondary rounded-pill px-4 fw-semibold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">
              <i class="bi bi-box-arrow-in-right me-1"></i> Inicia sesión
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal: Recuperar contraseña -->
  <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow">
        <div class="modal-header" style="background-color: #f3e8ff;">
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

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function abrirModalRecuperar() {
      const loginModalEl = document.getElementById('loginModal');
      const loginModal = bootstrap.Modal.getInstance(loginModalEl);
      if (loginModal) loginModal.hide();

      loginModalEl.addEventListener('hidden.bs.modal', function () {
        const forgotModal = new bootstrap.Modal(document.getElementById('forgotPasswordModal'));
        forgotModal.show();
      }, { once: true });
    }

    // Prevención del bug de fondo oscuro al cerrar múltiples modales
    document.addEventListener('hidden.bs.modal', function () {
      if (document.querySelectorAll('.modal.show').length > 0) {
        document.body.classList.add('modal-open');
      }
    });
  </script>
</body>
</html>
