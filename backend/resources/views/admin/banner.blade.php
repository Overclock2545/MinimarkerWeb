@extends('layouts.adminplantilla')

@section('titulo', 'Editar Banner')

@section('content')
    <div class="container">
        <h2 class="mb-4 fw-bold">🎯 Editar texto del banner publicitario</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.banner.actualizar') }}">
    @csrf
    @method('PUT')

    <textarea name="contenido" class="form-control" rows="4" required>{{ old('contenido', $banner->contenido ?? '') }}</textarea>

    <button type="submit" class="btn btn-primary mt-2">Guardar</button>
</form>

    </div>
@endsection
