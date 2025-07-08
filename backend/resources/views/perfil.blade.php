@extends('layouts.plantilla')

@section('titulo', 'Mi Perfil')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">👤 Mi Perfil</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('perfil.actualizar') }}">
        @csrf
        @method('PUT')

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="row mb-3">
                    <label class="col-md-4 fw-bold">Nombre:</label>
                    <div class="col-md-8">
                        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" disabled>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 fw-bold">Correo electrónico:</label>
                    <div class="col-md-8">
                        <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 fw-bold">Número celular:</label>
                    <div class="col-md-8">
                        <input type="text" name="celular" class="form-control" value="{{ Auth::user()->celular }}" disabled>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 fw-bold">Documento de identidad:</label>
                    <div class="col-md-8">
                        <input type="text" name="documento_identidad" class="form-control" value="{{ Auth::user()->documento_identidad }}" disabled>
                    </div>
                </div>
                <div class="row mb-4">
               <div class="col-md-6">
                 <a href="{{ route('favoritos') }}" class="btn btn-outline-warning w-100">
            ⭐ Ver Favoritos
                </a>
                </div>
                 <div class="col-md-6">
                <a href="{{ route('pedidos') }}" class="btn btn-outline-primary w-100">
            📦 Ver Mis Pedidos
             </a>
             </div>
            </div>

                <div class="text-end">
                    <button type="button" id="btn-editar" class="btn btn-primary">✏️ Editar</button>
                    <button type="submit" id="btn-guardar" class="btn btn-success d-none">💾 Guardar cambios</button>
                    <button type="button" id="btn-cancelar" class="btn btn-secondary d-none">❌ Cancelar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const btnEditar = document.getElementById('btn-editar');
    const btnGuardar = document.getElementById('btn-guardar');
    const btnCancelar = document.getElementById('btn-cancelar');
    const inputs = document.querySelectorAll('input');

    // Guardamos los valores originales
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
        // Restauramos valores originales y deshabilitamos
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
