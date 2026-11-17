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
            DB::table('encuestas_demo')->updateOrInsert(['solicitud_id' => $solicitud->id], [
                'valoracion' => $datos['valoracion'], 'comentario' => $datos['comentario'] ?? null,
                'updated_at' => now(), 'created_at' => now(),
            ]);
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
        $clave = config('continuidad.metricas_clave');
        if (!is_string($clave) || strlen($clave) < 16) abort(503, 'Configura una clave de métricas de al menos 16 caracteres.');
        if ($request->getUser() !== 'admin' || !hash_equals($clave, (string) $request->getPassword())) {
            return response('Autenticación requerida.', 401, ['WWW-Authenticate' => 'Basic realm="Métricas B2"', 'Cache-Control' => 'no-store']);
        }
        $solicitudes = SolicitudCotizacion::select('id', 'created_at', 'origen', 'ofertas', 'referido_por_id')->get();
        $porFecha = $solicitudes->groupBy(fn ($s) => $s->created_at->format('Y-m-d'))->map->count()->sortKeysDesc();
        $porOrigen = $solicitudes->groupBy('origen')->map->count();
        $porServicio = [];
        foreach ($solicitudes as $solicitud) foreach ($solicitud->ofertas as $oferta) {
            $categoria = $oferta['categoria'] ?? 'Sin categoría';
            $porServicio[$categoria] = ($porServicio[$categoria] ?? 0) + 1;
        }
        $encuestas = DB::table('encuestas_demo')->selectRaw('valoracion, count(*) as cantidad')->groupBy('valoracion')->orderBy('valoracion')->get();
        return response()->view('metricas.index', compact('solicitudes', 'porFecha', 'porOrigen', 'porServicio', 'encuestas'))
            ->header('Cache-Control', 'no-store, private')->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
