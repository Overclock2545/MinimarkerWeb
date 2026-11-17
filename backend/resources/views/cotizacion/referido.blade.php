@extends('layouts.plantilla')
@section('titulo', 'Referencia · B2 Solutions')
@section('contenido')
<section class="page-head"><div class="wrap"><span class="eyebrow dark">REFERENCIA DE DEMOSTRACIÓN</span><h1>Conoce opciones para <em>tu negocio.</em></h1><p>Explora el catálogo y registra una solicitud de prueba. Esta referencia se conservará durante la navegación en esta pestaña.</p><div class="notice">Información y precios ficticios para fines académicos.</div><div class="actions"><a class="btn btn-dark" href="{{ route('catalogo') }}">Explorar catálogo →</a></div><noscript>Activa JavaScript para conservar la referencia durante la navegación.</noscript></div></section>
<script id="referral-code" type="application/json">@json($codigo)</script><script src="{{ asset('js/referido.js') }}" defer></script>
@endsection
