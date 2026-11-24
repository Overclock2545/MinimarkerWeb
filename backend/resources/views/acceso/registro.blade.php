@extends('layouts.plantilla')
@section('titulo', 'Crear cuenta · B2 Solutions')
@section('contenido')
<section class="page-head"><div class="wrap"><span class="eyebrow dark">TU CUENTA B2</span><h1>Conecta con <em>tu negocio.</em></h1><p>Crea una cuenta de usuario para acceder a la experiencia comercial de demostración.</p></div></section>
<section class="wrap account-section"><form class="quote-form account-form" action="{{ route('cuenta.crear') }}" method="post">@csrf<h2>Crear cuenta</h2>
@if($errors->any())<div class="form-errors" role="alert"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<label for="name">Nombre</label><input id="name" name="name" value="{{ old('name') }}" required maxlength="100" autocomplete="name">
<label for="email">Correo electrónico</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
<label for="password">Contraseña</label><input id="password" name="password" type="password" required minlength="10" autocomplete="new-password"><small>Al menos 10 caracteres.</small>
<label for="password_confirmation">Repetir contraseña</label><input id="password_confirmation" name="password_confirmation" type="password" required minlength="10" autocomplete="new-password">
<button class="btn btn-dark" type="submit">Crear cuenta →</button><p>¿Ya tienes cuenta? <a class="text-link" href="{{ route('acceso') }}">Ingresar</a></p></form></section>
@endsection
