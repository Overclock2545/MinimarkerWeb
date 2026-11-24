@extends('layouts.plantilla')
@section('titulo', 'Ingresar · B2 Solutions')
@section('contenido')
<section class="page-head"><div class="wrap"><span class="eyebrow dark">TU CUENTA B2</span><h1>Bienvenido <em>de nuevo.</em></h1><p>Ingresa para continuar. Los administradores pueden consultar las métricas del canal.</p></div></section>
<section class="wrap account-section"><form class="quote-form account-form" action="{{ route('acceso') }}" method="post">@csrf<h2>Ingresar</h2>
@if($errors->any())<div class="form-errors" role="alert">{{ $errors->first() }}</div>@endif
<label for="email">Correo electrónico</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username">
<label for="password">Contraseña</label><input id="password" name="password" type="password" required autocomplete="current-password">
<button class="btn btn-dark" type="submit">Ingresar →</button><p>¿Aún no tienes cuenta? <a class="text-link" href="{{ route('cuenta.crear') }}">Crear cuenta de usuario</a></p></form></section>
@endsection
