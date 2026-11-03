<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Explora y compara ofertas de conectividad de demostración para tu negocio.">
    <title>@yield('titulo', 'B2 Solutions · Conectividad para tu negocio')</title>
    <link rel="stylesheet" href="{{ asset('css/b2.css') }}">
    <script src="{{ asset('js/b2.js') }}" defer></script>
    <script src="{{ asset('js/carrito-b2.js') }}" defer></script>
</head>
<body>
<a class="skip" href="#contenido">Saltar al contenido</a>
<div class="demo-bar">ENTORNO DEMOSTRATIVO <span>·</span> Todas las ofertas y precios son referenciales</div>
@include('partials.header')
<main id="contenido">@yield('contenido')</main>
<footer><div class="wrap footer-inner"><div><a class="brand footer-brand" href="{{ route('inicio') }}"><span class="brand-mark">b<span>2</span><i>.</i></span><span class="brand-name">solutions<small>CONECTAMOS NEGOCIOS</small></span></a><p>Conectividad para las ideas que mueven tu negocio.</p></div><div><strong>Explora</strong><a href="{{ route('catalogo') }}">Catálogo de servicios</a><a href="{{ route('comparar') }}">Comparador</a></div><div><strong>Sobre esta experiencia</strong><p>Proyecto académico de demostración.<br>Precios y características referenciales.</p></div></div><div class="wrap footer-bottom">B2 SOLUTIONS <span>·</span> CANAL COMERCIAL WEB PARA MYPE <span> / </span> DEMOSTRACIÓN</div></footer>
<div id="aviso" class="toast" role="status" aria-live="polite"></div>
</body></html>
