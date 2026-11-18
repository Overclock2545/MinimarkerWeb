@extends('layouts.plantilla')
@section('titulo', 'Tu propuesta · B2 Solutions')
@section('contenido')
<section class="page-head proposal-head"><div class="wrap">
    <span class="eyebrow dark">TU PROPUESTA DE DEMOSTRACIÓN</span>
    <h1>Tu solicitud está <em>lista.</em></h1>
    <p>Revisa tu selección y decide cómo continuar. Puedes volver a esta página con tu enlace privado.</p>
    <div class="notice">✳ Los precios son estimados de demostración. Este registro no representa una venta ni una activación.</div>
    @if(session('contacto_exito'))<div class="notice" role="status">{{ session('contacto_exito') }}</div>@endif
    @if(session('encuesta_exito'))<div class="notice" role="status">{{ session('encuesta_exito') }}</div>@endif
    @if($errors->any())<div class="form-errors" role="alert"><strong>Revisa la información:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
</div></section>
<section class="wrap proposal-layout">
    <div class="proposal-main">
        <div class="quote-confirmation proposal-card">
            <div class="proposal-code"><div><span class="section-number">CÓDIGO DE SOLICITUD</span><h2>{{ $solicitud->codigo }}</h2></div><span>DEMO</span></div>
            <p>Registrada el {{ $solicitud->created_at->format('d/m/Y H:i') }}.</p>
            <div class="proposal-save"><div><strong>Guarda tu enlace privado</strong><p>Te permite volver a esta propuesta desde otra sesión. Compártelo solo con quien deba verla.</p></div><label class="sr-only" for="proposal-link">Enlace privado de la propuesta</label><div class="copy-row"><input id="proposal-link" readonly value="{{ route('cotizacion.propuesta', $token) }}"><button type="button" data-copy-target="proposal-link">Copiar enlace</button></div><span class="copy-feedback" role="status" aria-live="polite" data-copy-feedback="proposal-link"></span></div>
            <div class="detail-features"><h3>Tu selección</h3>@foreach($solicitud->ofertas as $oferta)<div><span>{{ $oferta['categoria'] }} · {{ $oferta['nombre'] }} × {{ $oferta['cantidad'] }}</span><strong>@if($oferta['precio_centimos'] !== null) S/ {{ number_format(($oferta['precio_centimos'] * $oferta['cantidad']) / 100, 2) }} / {{ $oferta['periodo'] }} @else Precio por definir @endif</strong></div>@endforeach</div>
            <div class="cart-summary"><div><span>Importes referenciales</span><p>Montos separados por periodicidad.</p></div><div><p>Mensual <strong>S/ {{ number_format($solicitud->total_mensual_centimos / 100, 2) }} / mes</strong></p><p>Pago único <strong>S/ {{ number_format($solicitud->total_unico_centimos / 100, 2) }}</strong></p></div></div>
            @if(collect($solicitud->ofertas)->contains(fn ($item) => $item['precio_centimos'] === null))<p>Hay ofertas sin precio definido; los importes mostrados son parciales.</p>@endif
        </div>
        @if($solicitud->codigo_referido)<div class="quote-confirmation proposal-card" id="referir"><span class="section-number">COMPARTE LA EXPERIENCIA</span><h2>Invita a otro negocio</h2><p>Si una nueva solicitud se registra desde este enlace, conservará tu referencia de demostración.</p><label for="referral-link">Enlace de referido</label><div class="copy-row"><input id="referral-link" readonly value="{{ route('continuidad.referido', $solicitud->codigo_referido) }}"><button type="button" data-copy-target="referral-link">Copiar enlace</button></div><span class="copy-feedback" role="status" aria-live="polite" data-copy-feedback="referral-link"></span></div>@endif
        <form method="post" action="{{ route('continuidad.encuesta', $token) }}" class="quote-form survey-form" id="encuesta">@csrf<span class="section-number">TU EXPERIENCIA</span><h2>¿Cómo fue usar el canal?</h2><p>Tu respuesta ayuda a evaluar esta demostración.</p><label for="valoracion">Valoración <span>*</span></label><select id="valoracion" name="valoracion" required><option value="">Selecciona una opción</option>@for($i=1; $i<=5; $i++)<option value="{{ $i }}">{{ $i }} / 5</option>@endfor</select><label for="comentario">Comentario opcional</label><textarea id="comentario" name="comentario" maxlength="500" rows="3" placeholder="No incluyas datos personales"></textarea><button class="btn btn-dark" type="submit">Guardar respuesta</button></form>
    </div>
    <aside class="proposal-actions" id="contacto"><span class="section-number">EL SIGUIENTE PASO</span><h2>¿Cómo quieres continuar?</h2><p>Elige una opción para esta demostración. No se envían mensajes ni se realizan llamadas automáticamente.</p>
        @if($whatsapp)<a class="proposal-action primary" href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer"><span class="action-icon">↗</span><span><strong>Abrir WhatsApp</strong><small>Revisa el mensaje antes de enviarlo.</small></span><b>↗</b></a>@else<div class="proposal-action unavailable"><span class="action-icon">↗</span><span><strong>WhatsApp</strong><small>Número de prueba pendiente de configuración.</small></span></div>@endif
        <form method="post" action="{{ route('continuidad.contacto', $token) }}">@csrf<input type="hidden" name="preferencia" value="llamada"><button class="proposal-action" type="submit"><span class="action-icon">⌕</span><span><strong>Prefiero una llamada</strong><small>Registra tu preferencia de demostración.</small></span><b>→</b></button></form>
        <div class="proposal-side-note">✳ La llamada no se realizará automáticamente.</div><a class="text-link" href="{{ route('catalogo') }}">← Volver al catálogo</a>
    </aside>
</section>
@endsection
