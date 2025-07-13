@extends('layouts.plantilla')

@section('titulo', 'Mi Perfil')

@section('content')
<div class="container mt-4 mb-5">
    <h2 class="text-center mb-4 py-3 px-3 rounded-3 shadow-sm" style="background: linear-gradient(90deg, #d8b4fe, #fbcfe8); color: #4c1d95;">
        <i class="bi bi-person-circle me-2"></i> Mi Perfil
    </h2>

    @if (session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('perfil.actualizar') }}">
        @csrf
        @method('PUT')

        <div class="card shadow border-0 rounded-4">
            <div class="card-body p-4">
                <div class="row mb-3">
                    <label class="col-md-4 fw-semibold text-muted">Nombre:</label>
                    <div class="col-md-8">
                        <input type="text" name="name" class="form-control rounded-3" value="{{ Auth::user()->name }}" disabled>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 fw-semibold text-muted">Correo electrónico:</label>
                    <div class="col-md-8">
                        <input type="email" name="email" class="form-control rounded-3" value="{{ Auth::user()->email }}" disabled>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 fw-semibold text-muted">Número celular:</label>
                    <div class="col-md-8">
                        <input type="text" name="celular" class="form-control rounded-3" value="{{ Auth::user()->celular }}" disabled>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-md-4 fw-semibold text-muted">Documento de identidad:</label>
                    <div class="col-md-8">
                        <input type="text" name="documento_identidad" class="form-control rounded-3" value="{{ Auth::user()->documento_identidad }}" disabled>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <a href="{{ route('favoritos') }}" class="btn btn-danger w-100 rounded-pill fw-semibold text-white btn-icon">
                            <i class="bi bi-heart-fill me-2"></i> Ver Favoritos
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('pedidos') }}" class="btn btn-primary w-100 rounded-pill fw-semibold text-white btn-icon">
                            <i class="bi bi-box-seam me-2"></i> Ver Mis Pedidos
                        </a>
                    </div>
                </div>

                <div class="text-end">
                    <button type="button" id="btn-editar" class="btn btn-primary rounded-pill fw-semibold me-2 btn-icon">
                        <i class="bi bi-pencil-fill me-1"></i> Editar
                    </button>
                    <button type="submit" id="btn-guardar" class="btn btn-success rounded-pill fw-semibold me-2 d-none btn-icon">
                        <i class="bi bi-save-fill me-1"></i> Guardar
                    </button>
                    <button type="button" id="btn-cancelar" class="btn btn-secondary rounded-pill fw-semibold d-none btn-icon">
                        <i class="bi bi-x-circle-fill me-1"></i> Cancelar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.btn-icon {
    transition: all 0.3s ease;
}

.btn-icon:hover {
    background-color: transparent !important;
    color: #000 !important;
    border: 2px solid currentColor !important;
}
</style>

<script>
    const btnEditar = document.getElementById('btn-editar');
    const btnGuardar = document.getElementById('btn-guardar');
    const btnCancelar = document.getElementById('btn-cancelar');
    const inputs = document.querySelectorAll('input');

    const valoresOriginales = {};
    inputs.forEach(input => {
        valoresOriginales[input.name] = input.value;
    });

    btnEditar.addEventListener('click', () => {
        inputs.forEach(input => input.disabled = false);
        btnEditar.classList.add('d-none');
        btnGuardar.classList.remove('d-none');
        btnCancelar.classList.remove('d-none');
    });

    btnCancelar.addEventListener('click', () => {
        inputs.forEach(input => {
            input.value = valoresOriginales[input.name];
            input.disabled = true;
        });
        btnGuardar.classList.add('d-none');
        btnCancelar.classList.add('d-none');
        btnEditar.classList.remove('d-none');
    });
</script>
@endsection
