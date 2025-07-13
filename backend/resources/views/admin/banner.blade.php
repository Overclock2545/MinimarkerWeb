@extends('layouts.adminplantilla')

@section('titulo', 'Editar Banner')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold mb-4 text-dark">🎯 Editar texto del banner publicitario</h2>

    {{-- ✅ Vista previa EXACTA del banner en el header --}}
    <div class="d-flex justify-content-center mb-4">
        <div class="flex-shrink-0" style="width: 380px;">
            <a href="#" class="d-flex align-items-center justify-content-center rounded-3 shadow-sm text-white fw-semibold text-decoration-none px-3"
               style="height: 56px; background: linear-gradient(90deg, #a78bfa, #f472b6); overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                <span class="text-truncate w-100 text-center" style="font-size: 1rem;" id="previewBanner">
                    {{ old('contenido', $banner->contenido ?? '') }}
                </span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- 📝 Edición del contenido --}}
    <form method="POST" action="{{ route('admin.banner.actualizar') }}">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="contenido" class="form-label fw-semibold">Nuevo texto del banner:</label>
            <textarea id="contenido" name="contenido" class="form-control rounded-3 shadow-sm" rows="3" required oninput="actualizarPreview()">{{ old('contenido', $banner->contenido ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-dark rounded-pill px-4 shadow-sm">
            <i class="bi bi-save me-1"></i> Guardar
        </button>
    </form>
</div>

<script>
    function actualizarPreview() {
        const texto = document.getElementById('contenido').value;
        document.getElementById('previewBanner').textContent = texto;
    }
</script>
@endsection
