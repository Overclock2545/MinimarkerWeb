@extends('layouts.adminplantilla')

@section('title', 'Seleccionar Banner')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold text-center mb-4" style="color: #6b21a8;">Editar Banners</h2>

    <div class="d-flex justify-content-center gap-4">
        <a href="{{ route('admin.banner') }}" class="btn btn-lg btn-outline-primary shadow-sm rounded-pill px-4 py-2" style="background-color: #e9d5ff;">
            📰 Banner Publicitario
        </a>


        <a href="{{ route('admin.landing.editar') }}" class="btn btn-lg btn-outline-success shadow-sm rounded-pill px-4 py-2" style="background-color: #d9f99d;">
            🎯 Banner de Campaña
        </a>
    </div>
</div>
@endsection

