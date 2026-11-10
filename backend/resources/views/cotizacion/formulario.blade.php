@extends('layouts.plantilla')
@section('titulo', 'Solicitar cotización · B2 Solutions')
@section('contenido')
<section class="page-head"><div class="wrap"><div class="breadcrumbs"><a href="{{ route('inicio') }}">Inicio</a> / <a href="{{ route('carrito') }}">Carrito</a> / Cotización</div><span class="eyebrow dark">SOLICITUD EMPRESARIAL</span><h1>Cuéntanos sobre <em>tu negocio.</em></h1><p>Completa tus datos y revisa las ofertas seleccionadas. Esta solicitud es parte de una demostración académica.</p><div class="notice">✳ Usa datos ficticios. Los precios y servicios son referenciales.</div></div></section>
<section class="wrap cotizacion"><div class="cotizacion-grid"><form action="{{ route('cotizacion.guardar') }}" method="post" class="quote-form" id="quote-form">@csrf
    <span class="section-number">01 / DATOS DE LA EMPRESA</span><h2>Información de contacto</h2>
    @if($errors->any())<div class="form-errors" role="alert"><strong>Revisa la información:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <label for="ruc">RUC <span>*</span></label><input id="ruc" name="ruc" inputmode="numeric" pattern="[0-9]{11}" maxlength="11" value="{{ old('ruc') }}" required placeholder="11 dígitos"><small>Solo números. Usa un RUC ficticio para la demostración.</small>
    <label for="razon_social">Razón social <span>*</span></label><input id="razon_social" name="razon_social" maxlength="160" value="{{ old('razon_social') }}" required placeholder="Nombre de la empresa">
    <label for="contacto">Nombre de contacto <span>*</span></label><input id="contacto" name="contacto" maxlength="120" value="{{ old('contacto') }}" required placeholder="Nombre y apellido">
    <label for="telefono">Teléfono <span>*</span></label><input id="telefono" name="telefono" inputmode="numeric" pattern="[0-9]{9,15}" maxlength="15" value="{{ old('telefono') }}" required placeholder="Entre 9 y 15 dígitos">
    <div id="quote-items-fields"></div><p class="quote-disclaimer">Al enviar se registrará una solicitud de demostración en la base propia. No se envían mensajes ni se realiza una compra.</p><button class="btn btn-dark" id="quote-submit" type="submit" disabled>Registrar solicitud ↗</button><noscript><p>Activa JavaScript para transferir tu selección del carrito.</p></noscript>
</form><aside class="quote-summary"><span class="section-number">02 / TU SELECCIÓN</span><h2>Resumen referencial</h2><div id="quote-summary" aria-live="polite"><p>Selecciona al menos una oferta en el carrito.</p><a class="text-link" href="{{ route('catalogo') }}">Explorar catálogo →</a></div><p class="quote-disclaimer">Los montos son estimados y no representan una oferta comercial vigente.</p><a class="text-link" href="{{ route('carrito') }}">Editar selección →</a></aside></div></section>
<script id="quote-catalog" type="application/json">@json($categorias, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)</script>
<script id="quote-old-items" type="application/json">@json(old('ofertas', []), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)</script>
<script src="{{ asset('js/cotizacion.js') }}" defer></script>
@endsection
