@extends('layouts.plantilla')
@section('titulo', 'Métricas internas · B2 Solutions')
@section('contenido')
<section class="metrics-hero"><div class="wrap"><span class="eyebrow">Métricas del canal / DEMOSTRACIÓN</span><h1>El pulso de <em>tu canal.</em></h1><p>Explora la actividad registrada y la experiencia de las MYPE en un solo lugar.</p><div class="metrics-note">Datos de demostración. No representan ventas, conversiones ni renovaciones reales.</div></div></section>
<section class="wrap metrics-page">
    <div class="metrics-heading"><div><span class="section-number">RESUMEN GENERAL</span><h2>Tu canal en cifras</h2><p>Indicadores calculados a partir de los registros propios.</p></div><a class="text-link" href="{{ route('catalogo') }}">Explorar catálogo ↗</a></div>
    <div class="metric-kpis">
        <article><span class="metric-icon">▤</span><small>SOLICITUDES</small><strong>{{ number_format($totalSolicitudes) }}</strong><p>Solicitudes registradas</p></article>
        <article><span class="metric-icon">↗</span><small>REFERIDOS</small><strong>{{ number_format($totalReferidos) }}</strong><p>Solicitudes con referencia</p></article>
        <article><span class="metric-icon">☎</span><small>LLAMADAS</small><strong>{{ number_format($totalLlamadas) }}</strong><p>Preferencias registradas</p></article>
        <article><span class="metric-icon">★</span><small>SATISFACCIÓN</small><strong>{{ $promedio !== null ? number_format($promedio, 1) : '—' }}<small> / 5</small></strong><p>{{ $encuestas->sum('cantidad') }} respuestas</p></article>
    </div>
    <div class="metrics-charts">
        <article class="metric-panel trend-panel"><div class="metric-panel-head"><div><span class="section-number">ACTIVIDAD</span><h2>Solicitudes por fecha</h2><p>Últimos 30 días, incluida la fecha actual.</p></div><span class="metric-badge">30 días</span></div>
        @php($maxFecha = max(1, $porFecha->max() ?? 0))
        <div class="trend-chart" role="img" aria-label="Solicitudes por día en los últimos 30 días. Los valores diarios se indican en cada barra.">
        @foreach($porFecha as $fecha => $cantidad)<div class="trend-column" title="{{ $fecha }}: {{ $cantidad }} solicitudes" aria-label="{{ $fecha }}: {{ $cantidad }} solicitudes"><span style="height:{{ $cantidad ? max(4, round($cantidad / $maxFecha * 100)) : 0 }}%"></span></div>@endforeach</div>
        <div class="chart-axis"><span>{{ $porFecha->keys()->first() }}</span><span>Hoy · {{ $porFecha->keys()->last() }}</span></div>
        <details class="chart-details"><summary>Ver datos diarios</summary><div class="chart-values">@foreach($porFecha as $fecha => $cantidad)<span>{{ $fecha }}: <strong>{{ $cantidad }}</strong></span>@endforeach</div></details></article>
        <article class="metric-panel"><span class="section-number">PROCEDENCIA</span><h2>Solicitudes por origen</h2><p>De dónde llegó cada solicitud.</p>@php($maxOrigen = max(1, $porOrigen->max() ?? 0))
        @forelse($porOrigen as $origen => $cantidad)<div class="bar-row"><div><span>{{ $origen === 'web' ? 'Sitio web' : ($origen === 'referido' ? 'Referido' : $origen) }}</span><strong>{{ $cantidad }}</strong></div><div class="bar-track"><span style="width:{{ round($cantidad / $maxOrigen * 100) }}%"></span></div></div>@empty<p>Sin solicitudes registradas.</p>@endforelse</article>
        <article class="metric-panel"><span class="section-number">INTERÉS</span><h2>Ofertas por categoría</h2><p>Líneas de oferta incluidas en solicitudes, no ventas.</p>@php($maxServicio = max(1, max($porServicio ?: [0])))
        @forelse($porServicio as $servicio => $cantidad)<div class="bar-row"><div><span>{{ $servicio }}</span><strong>{{ $cantidad }}</strong></div><div class="bar-track"><span style="width:{{ round($cantidad / $maxServicio * 100) }}%"></span></div></div>@empty<p>Sin ofertas registradas.</p>@endforelse</article>
        <article class="metric-panel"><span class="section-number">EXPERIENCIA</span><h2>Valoraciones del canal</h2><p>Distribución de las respuestas recibidas.</p>@php($maxEncuesta = max(1, $encuestas->max('cantidad') ?? 0))
        @foreach(range(5, 1) as $estrellas) @php($cantidad = $encuestas->firstWhere('valoracion', $estrellas)->cantidad ?? 0)<div class="bar-row"><div><span>{{ $estrellas }} / 5</span><strong>{{ $cantidad }}</strong></div><div class="bar-track"><span style="width:{{ round($cantidad / $maxEncuesta * 100) }}%"></span></div></div>@endforeach</article>
    </div>
    <div class="metrics-heading records-heading"><div><span class="section-number">ACTIVIDAD DEL CANAL</span><h2>Registros de demostración</h2><p>Consulta los registros sin mostrar datos personales.</p></div></div>
    @foreach([
        ['id'=>'solicitudes','titulo'=>'Solicitudes recientes','paginador'=>$solicitudesPagina,'tipo'=>'solicitud'],
        ['id'=>'llamadas','titulo'=>'Preferencias de llamada','paginador'=>$llamadasPagina,'tipo'=>'llamada'],
        ['id'=>'encuestas','titulo'=>'Respuestas de satisfacción','paginador'=>$encuestasPagina,'tipo'=>'encuesta'],
    ] as $lista)
    <article class="metric-panel records-panel" id="{{ $lista['id'] }}"><div class="metric-panel-head"><h2>{{ $lista['titulo'] }}</h2><span class="metric-badge">{{ $lista['paginador']->total() }} registros</span></div>
        <div class="records-table-wrap"><table class="records-table"><thead><tr><th>Código</th><th>Fecha</th><th>{{ $lista['tipo'] === 'encuesta' ? 'Valoración' : ($lista['tipo'] === 'llamada' ? 'Procedencia' : 'Origen') }}</th></tr></thead><tbody>
        @forelse($lista['paginador'] as $registro)<tr><td>{{ $registro->codigo }}</td><td>{{ \Carbon\Carbon::parse($registro->created_at)->format('d/m/Y H:i') }}</td><td>@if($lista['tipo'] === 'encuesta'){{ $registro->valoracion }} / 5 @elseif($lista['tipo'] === 'llamada'){{ $registro->procedencia === 'enlace_propuesta' ? 'Enlace de propuesta' : $registro->procedencia }}@else{{ $registro->origen === 'referido' ? 'Referido' : ($registro->origen === 'web' ? 'Sitio web' : $registro->origen) }}@endif</td></tr>@empty<tr><td colspan="3">No hay registros todavía.</td></tr>@endforelse
        </tbody></table></div>
        <nav class="records-pagination" aria-label="Paginación: {{ $lista['titulo'] }}"><span>Página {{ $lista['paginador']->currentPage() }} de {{ $lista['paginador']->lastPage() }}</span><div>@if($lista['paginador']->onFirstPage())<span aria-disabled="true">Anterior</span>@else<a href="{{ $lista['paginador']->appends(request()->except($lista['id']))->previousPageUrl() }}#{{ $lista['id'] }}">← Anterior</a>@endif @if($lista['paginador']->hasMorePages())<a href="{{ $lista['paginador']->appends(request()->except($lista['id']))->nextPageUrl() }}#{{ $lista['id'] }}">Siguiente →</a>@else<span aria-disabled="true">Siguiente</span>@endif</div></nav>
    </article>
    @endforeach
</section>
@endsection
