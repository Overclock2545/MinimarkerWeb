@extends('layouts.plantilla')
@section('titulo', 'Catálogo · B2 Solutions')
@section('contenido')
<section class="page-head"><div class="wrap"><div class="breadcrumbs"><a href="{{ route('inicio') }}">Inicio</a> / Catálogo</div><div class="page-head-grid"><div><span class="eyebrow dark">CONOCE TUS OPCIONES</span><h1>Elige cómo <em>conectar.</em></h1></div><p>Explora alternativas de demostración para tu negocio. Elige una categoría y compara lo que más te importa.</p></div><div class="notice"><b>✳</b> Información de demostración. Los precios y características son referenciales.</div></div></section>
<section class="wrap catalog"><div class="catalog-toolbar"><div class="filters" aria-label="Categorías"><a class="{{ $activa === 'todas' ? 'selected' : '' }}" href="{{ route('catalogo') }}">Todas <span>09</span></a>@foreach($categorias as $key => $categoria)<a class="{{ $activa === $key ? 'selected' : '' }}" href="{{ route('catalogo', ['categoria'=>$key]) }}">{{ $categoria['nombre'] }} <span>03</span></a>@endforeach</div><a class="compare-link" href="{{ route('comparar') }}">Ir al comparador <span>↗</span></a></div>
@foreach($categorias as $key => $categoria)
@if($activa === 'todas' || $activa === $key)
<div class="catalog-section"><div class="catalog-heading"><div><span class="section-number">{{ $categoria['numero'] }} / CATEGORÍA</span><h2>{{ $categoria['nombre'] }}</h2><p>{{ $categoria['descripcion'] }}</p></div><span class="heading-icon">{{ $categoria['icono'] }}</span></div><div class="offer-grid">
@foreach($categoria['ofertas'] as $oferta)
<article class="offer-card"><div class="offer-top"><span>{{ strtoupper($categoria['nombre']) }}</span><span>INFORMACIÓN DE DEMOSTRACIÓN</span></div><h3>{{ $oferta['nombre'] }}</h3><p>{{ $oferta['descripcion'] }}</p><div class="price"><small>S/</small> {{ number_format($oferta['precio'], 2) }} <span>/ {{ $oferta['periodo'] }}</span></div><div class="offer-rule"></div><ul>@foreach($oferta['valores'] as $valor)<li><span>✓</span> {{ $valor }}</li>@endforeach</ul><div class="card-actions"><a href="{{ route('catalogo.detalle', $oferta['id']) }}">Ver detalle <span>↗</span></a><button type="button" data-add="{{ $oferta['id'] }}" data-category="{{ $key }}" data-name="{{ $oferta['nombre'] }}" aria-pressed="false">+ Comparar</button></div><button class="cart-add" type="button" data-cart-add="{{ $oferta['id'] }}">+ Añadir al carrito</button></article>
@endforeach
</div></div>@endif @endforeach
</section>
@endsection
