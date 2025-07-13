@extends('layouts.plantilla')

@section('content')
<div class="container mt-5">
    <h4 class="fw-bold mb-3">🔐 Verificar cuenta</h4>
    

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('verificar.codigo.enviar') }}">
        @csrf
        <div class="mb-3">
            <label for="codigo" class="form-label">Código de verificación</label>
            <input type="text" class="form-control" id="codigo" name="codigo" required>
        </div>
        <button type="submit" class="btn btn-primary">Verificar</button>
    </form>
</div>
@endsection
