<?php

namespace App\Http\Controllers;

use App\Models\SolicitudCotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ContinuidadController extends Controller
{
    private function solicitud(string $token): SolicitudCotizacion
    {
        abort_unless(preg_match('/\A[a-f0-9]{64}\z/', $token), 404);
        return SolicitudCotizacion::where('token_hash', hash('sha256', $token))->firstOrFail();
    }

    public function contacto(Request $request, string $token)
    {
        $solicitud = $this->solicitud($token);
        $datos = $request->validate(['preferencia' => ['required', 'in:llamada']]);
        try {
            DB::table('solicitudes_contacto_demo')->insert([
                'solicitud_id' => $solicitud->id, 'preferencia' => $datos['preferencia'],
                'procedencia' => 'enlace_propuesta', 'ejecutivo_demo' => $solicitud->ejecutivo_demo,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        } catch (Throwable $e) {
            Log::error('No se pudo guardar la preferencia de contacto.', ['exception_class' => get_class($e)]);
            return back()->withErrors(['contacto' => 'No fue posible registrar la preferencia. Inténtalo nuevamente.']);
        }
        return back()->with('contacto_exito', 'Preferencia de llamada registrada para la demostración. No se realizará una llamada automática.');
    }

    public function encuesta(Request $request, string $token)
    {
        $solicitud = $this->solicitud($token);
        $datos = $request->validate(['valoracion' => ['required', 'integer', 'between:1,5'], 'comentario' => ['nullable', 'string', 'max:500']]);
        try {
            DB::table('encuestas_demo')->upsert([[
                'solicitud_id' => $solicitud->id, 'valoracion' => $datos['valoracion'],
                'comentario' => $datos['comentario'] ?? null, 'created_at' => now(), 'updated_at' => now(),
            ]], ['solicitud_id'], ['valoracion', 'comentario', 'updated_at']);
        } catch (Throwable $e) {
            Log::error('No se pudo guardar la encuesta.', ['exception_class' => get_class($e)]);
            return back()->withErrors(['encuesta' => 'No fue posible guardar la encuesta. Inténtalo nuevamente.']);
        }
        return back()->with('encuesta_exito', 'Gracias. Tu respuesta de demostración quedó registrada.');
    }

    public function referido(string $codigo)
    {
        abort_unless(preg_match('/\A[a-f0-9]{32}\z/', $codigo), 404);
        abort_unless(SolicitudCotizacion::where('codigo_referido', $codigo)->exists(), 404);
        return response()->view('cotizacion.referido', compact('codigo'))
            ->header('Cache-Control', 'no-store, private')->header('Referrer-Policy', 'no-referrer')->header('X-Robots-Tag', 'noindex, nofollow');
    }

    public function metricas(Request $request)
    {
        $usuario = auth('b2')->user();
        if ($usuario && $usuario->rol !== 'admin') abort(403, 'Esta sección es solo para administradores.');
        if (!$usuario) {
            $clave = config('continuidad.metricas_clave');
            if (!is_string($clave) || strlen($clave) < 16) abort(503, 'Configura una clave de métricas de al menos 16 caracteres.');
            if ($request->getUser() !== 'admin' || !hash_equals($clave, (string) $request->getPassword())) {
                return response('Autenticación requerida.', 401, ['WWW-Authenticate' => 'Basic realm="Métricas B2"', 'Cache-Control' => 'no-store']);
            }
        }
        $totalSolicitudes = SolicitudCotizacion::count();
        $totalReferidos = SolicitudCotizacion::whereNotNull('referido_por_id')->count();
        $totalLlamadas = DB::table('solicitudes_contacto_demo')->count();
        $promedio = DB::table('encuestas_demo')->avg('valoracion');
        $desde = now()->startOfDay()->subDays(29);
        $fechas = SolicitudCotizacion::where('created_at', '>=', $desde)
            ->selectRaw('DATE(created_at) as fecha, count(*) as cantidad')
            ->groupByRaw('DATE(created_at)')->pluck('cantidad', 'fecha');
        $porFecha = collect(range(0, 29))->mapWithKeys(function ($i) use ($desde, $fechas) {
            $fecha = $desde->copy()->addDays($i)->format('Y-m-d');
            return [$fecha => (int) ($fechas[$fecha] ?? 0)];
        });
        $porOrigen = SolicitudCotizacion::selectRaw('origen, count(*) as cantidad')->groupBy('origen')->pluck('cantidad', 'origen');
        $porServicio = [];
        foreach (SolicitudCotizacion::select('id', 'ofertas')->cursor() as $solicitud) foreach (($solicitud->ofertas ?? []) as $oferta) {
            $categoria = $oferta['categoria'] ?? 'Sin categoría';
            $porServicio[$categoria] = ($porServicio[$categoria] ?? 0) + 1;
        }
        $encuestas = DB::table('encuestas_demo')->selectRaw('valoracion, count(*) as cantidad')->groupBy('valoracion')->orderBy('valoracion')->get();
        $solicitudesPagina = SolicitudCotizacion::select('codigo', 'origen', 'created_at')->orderByDesc('created_at')->orderByDesc('id')->paginate(10, ['*'], 'solicitudes');
        $llamadasPagina = DB::table('solicitudes_contacto_demo as c')->join('solicitudes_cotizacion as s', 's.id', '=', 'c.solicitud_id')
            ->select('s.codigo', 'c.procedencia', 'c.created_at')->orderByDesc('c.created_at')->orderByDesc('c.id')->paginate(10, ['*'], 'llamadas');
        $encuestasPagina = DB::table('encuestas_demo as e')->join('solicitudes_cotizacion as s', 's.id', '=', 'e.solicitud_id')
            ->select('s.codigo', 'e.valoracion', 'e.created_at')->orderByDesc('e.created_at')->orderByDesc('e.id')->paginate(10, ['*'], 'encuestas');
        return response()->view('metricas.index', compact('totalSolicitudes', 'totalReferidos', 'totalLlamadas', 'promedio', 'porFecha', 'porOrigen', 'porServicio', 'encuestas', 'solicitudesPagina', 'llamadasPagina', 'encuestasPagina'))
            ->header('Cache-Control', 'no-store, private')->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
