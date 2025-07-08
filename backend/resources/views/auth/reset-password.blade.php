@extends('layouts.plantilla')

@section('title', 'Restablecer contraseña')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow" style="border: 1px solid #e0ccff;">
                <div class="card-header text-center" style="background-color: #f3e8ff;">
                    <h4 class="mb-0" style="color: #7b4295;">🔒 Restablecer contraseña</h4>
                </div>

                <div class="card-body" style="background-color: #fdf6ff;">
                    <form id="resetForm" method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email (solo visual) -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input id="email" type="email" class="form-control" name="email"
                                   value="{{ old('email', $request->email) }}" readonly>
                        </div>

                        <!-- Nueva contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva contraseña</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmación -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botón con modal -->
                        <div class="d-grid">
                            <button type="button" class="btn" style="background-color: #e0ccff; color: #4a226e;"
                                    data-bs-toggle="modal" data-bs-target="#confirmModal">
                                💾 Guardar nueva contraseña
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center" style="background-color: #f3e8ff;">
                    <small class="text-muted">I LIKE YOU Importaciones 💜</small>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #f3e8ff;">
        <h5 class="modal-title" id="confirmModalLabel">¿Confirmar cambio?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas restablecer tu contraseña?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn" style="background-color: #e6ccff; color: #4a226e;"
                onclick="document.getElementById('resetForm').submit();">
            ✅ Confirmar y guardar
        </button>
      </div>
    </div>
  </div>
</div>
@endsection
