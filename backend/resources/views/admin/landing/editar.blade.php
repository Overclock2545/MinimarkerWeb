@extends('layouts.adminplantilla')

@section('title', 'Editar Banner de Campaña')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-center" style="color: #6b21a8;">Editar Banner de Campaña</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        {{-- Formulario --}}
        <div class="col-md-6">
            <form method="POST" action="{{ route('admin.landing.actualizar') }}" enctype="multipart/form-data" id="landingForm">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Título grande</label>
                    <input type="text" class="form-control" name="titulo" value="{{ old('titulo', $landing->titulo) }}" id="tituloInput" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Subtítulo (opcional)</label>
                    <input type="text" class="form-control" name="subtitulo" value="{{ old('subtitulo', $landing->subtitulo) }}" id="subtituloInput">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Descripción de campaña</label>
                    <textarea class="form-control" name="descripcion" rows="5" id="descripcionInput" required>{{ old('descripcion', $landing->descripcion) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Texto del botón</label>
                    <input type="text" class="form-control" name="boton" value="{{ old('boton', $landing->boton) }}" id="botonInput" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Enlace del botón</label>
                    <input type="text" class="form-control" name="link_boton" value="{{ old('link_boton', $landing->link_boton) }}" id="linkInput">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Color del botón</label>
                    <input type="color" class="form-control form-control-color" name="color_boton" value="{{ old('color_boton', $landing->color_boton ?? '#111827') }}" id="colorBotonInput">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Color de fondo</label>
                    <input type="color" class="form-control form-control-color" name="color_fondo" value="{{ old('color_fondo', $landing->color_fondo ?? '#ffffff') }}" id="colorFondoInput">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Imagen horizontal (principal)</label>
                    <input type="file" class="form-control" name="imagen" accept="image/*" id="imagenInput">
                    @if($landing->imagen)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $landing->imagen) }}" id="previewImageTag" class="img-fluid rounded shadow" style="max-height: 120px;">
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Imagen secundaria (opcional)</label>
                    <input type="file" class="form-control" name="imagen_secundaria" accept="image/*" id="imagenSecundariaInput">
                    @if($landing->imagen_secundaria)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $landing->imagen_secundaria) }}" id="previewSecundariaTag" class="img-fluid rounded shadow" style="max-height: 120px;">
                        </div>
                    @endif
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="mostrar_logo" value="1" id="logoSwitch" {{ $landing->mostrar_logo ? 'checked' : '' }}>
                    <label class="form-check-label" for="logoSwitch">Mostrar logo en landing</label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="mostrar_contador" value="1" id="contadorSwitch" {{ $landing->mostrar_contador ? 'checked' : '' }}>
                    <label class="form-check-label" for="contadorSwitch">Mostrar contador regresivo</label>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Fecha límite de campaña</label>
                    <input type="date" class="form-control" name="fecha_limite" value="{{ old('fecha_limite', $landing->fecha_limite) }}">
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="estado" value="1" id="estadoSwitch" {{ $landing->estado ? 'checked' : '' }}>
                    <label class="form-check-label" for="estadoSwitch">Landing activa</label>
                </div>

                <button type="submit" class="btn btn-success fw-semibold px-4">Guardar cambios</button>
            </form>
        </div>

        {{-- Vista previa en vivo --}}
        <div class="col-md-6">
            <div class="border rounded shadow-sm p-4" id="previewBox" style="background-color: {{ $landing->color_fondo ?? '#f9fafb' }};">
                <h5 class="text-muted mb-3 text-center">Vista previa en tiempo real</h5>

                <div class="text-center mb-3">
                    <img src="{{ asset('storage/' . $landing->imagen) }}" id="previewImage" class="img-fluid rounded shadow" style="max-height: 180px;">
                </div>

                <h2 class="text-center fw-bold" id="previewTitulo">{{ $landing->titulo }}</h2>
                <h5 class="text-center text-muted mb-3" id="previewSubtitulo">{{ $landing->subtitulo }}</h5>
                <p class="text-center" id="previewDescripcion" style="white-space: pre-line;">{{ $landing->descripcion }}</p>

                <div class="text-center mb-3">
                    <img src="{{ asset('storage/' . $landing->imagen_secundaria) }}" id="previewSecundaria" class="img-fluid rounded shadow" style="max-height: 150px;">
                </div>

                <div class="text-center">
                    <a href="#" class="btn rounded-pill text-white fw-semibold" id="previewBoton" style="background-color: {{ $landing->color_boton }};">
                        {{ $landing->boton }}
                    </a>
                </div>

                <div class="text-center mt-3">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#vistaModal">Ampliar vista</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal de vista ampliada --}}
<div class="modal fade" id="vistaModal" tabindex="-1" aria-labelledby="vistaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Vista ampliada de la landing</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="border rounded p-4" id="modalPreview" style="background-color: {{ $landing->color_fondo ?? '#ffffff' }};">
            <div class="text-center mb-3">
                <img src="{{ asset('storage/' . $landing->imagen) }}" id="modalImage" class="img-fluid rounded shadow" style="max-height: 200px;">
            </div>
            <h2 class="text-center fw-bold" id="modalTitulo">{{ $landing->titulo }}</h2>
            <h5 class="text-center text-muted" id="modalSubtitulo">{{ $landing->subtitulo }}</h5>
            <p class="text-center" id="modalDescripcion" style="white-space: pre-line;">{{ $landing->descripcion }}</p>
            <div class="text-center mb-3">
                <img src="{{ asset('storage/' . $landing->imagen_secundaria) }}" id="modalSecundaria" class="img-fluid rounded shadow" style="max-height: 150px;">
            </div>
            <div class="text-center">
                <a href="#" class="btn rounded-pill text-white fw-semibold" id="modalBoton" style="background-color: {{ $landing->color_boton }};">
                    {{ $landing->boton }}
                </a>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Scripts --}}
<script>
    function updatePreview() {
        document.getElementById('previewTitulo').textContent = titulo.value;
        document.getElementById('previewSubtitulo').textContent = subtitulo.value;
        document.getElementById('previewDescripcion').textContent = descripcion.value;
        document.getElementById('previewBoton').textContent = boton.value;
        document.getElementById('previewBoton').style.backgroundColor = colorBoton.value;
        document.getElementById('previewBox').style.backgroundColor = colorFondo.value;

        // Modal
        document.getElementById('modalTitulo').textContent = titulo.value;
        document.getElementById('modalSubtitulo').textContent = subtitulo.value;
        document.getElementById('modalDescripcion').textContent = descripcion.value;
        document.getElementById('modalBoton').textContent = boton.value;
        document.getElementById('modalBoton').style.backgroundColor = colorBoton.value;
        document.getElementById('modalPreview').style.backgroundColor = colorFondo.value;
    }

    const titulo = document.getElementById('tituloInput');
    const subtitulo = document.getElementById('subtituloInput');
    const descripcion = document.getElementById('descripcionInput');
    const boton = document.getElementById('botonInput');
    const colorBoton = document.getElementById('colorBotonInput');
    const colorFondo = document.getElementById('colorFondoInput');

    titulo.addEventListener('input', updatePreview);
    subtitulo.addEventListener('input', updatePreview);
    descripcion.addEventListener('input', updatePreview);
    boton.addEventListener('input', updatePreview);
    colorBoton.addEventListener('input', updatePreview);
    colorFondo.addEventListener('input', updatePreview);

    // Imagen principal
    document.getElementById('imagenInput').addEventListener('change', e => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e2 => {
                document.getElementById('previewImage').src = e2.target.result;
                document.getElementById('modalImage').src = e2.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Imagen secundaria
    document.getElementById('imagenSecundariaInput').addEventListener('change', e => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e2 => {
                document.getElementById('previewSecundaria').src = e2.target.result;
                document.getElementById('modalSecundaria').src = e2.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
