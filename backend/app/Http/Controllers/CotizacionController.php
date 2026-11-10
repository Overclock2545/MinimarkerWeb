<?php

namespace App\Http\Controllers;

use App\Models\SolicitudCotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class CotizacionController extends Controller
{
    public function crear()
    {
        return response()->view('cotizacion.formulario', ['categorias' => config('catalogo_b2')])
            ->header('Cache-Control', 'no-store, private')
            ->header('Referrer-Policy', 'no-referrer');
    }

    public function guardar(Request $request)
    {
        $datos = $request->validate([
            'ruc' => ['required', 'string', 'regex:/^[0-9]{11}$/'],
            'razon_social' => ['required', 'string', 'max:160'],
            'contacto' => ['required', 'string', 'max:120'],
            'telefono' => ['required', 'string', 'regex:/^[0-9]{9,15}$/'],
            'ofertas' => ['required', 'array', 'min:1', 'max:9'],
            'ofertas.*.id' => ['required', 'string', 'distinct', 'max:100'],
            'ofertas.*.cantidad' => ['required', 'integer', 'min:1', 'max:99'],
        ], [
            'ruc.regex' => 'El RUC debe tener 11 dígitos.',
            'telefono.regex' => 'El teléfono debe contener entre 9 y 15 dígitos.',
            'ofertas.required' => 'Agrega al menos una oferta desde el catálogo.',
            'ofertas.min' => 'Agrega al menos una oferta desde el catálogo.',
        ]);

        $catalogo = [];
        foreach (config('catalogo_b2') as $categoria) {
            foreach ($categoria['ofertas'] as $oferta) {
                $catalogo[$oferta['id']] = ['categoria' => $categoria['nombre'], 'unidad' => $categoria['unidad']] + $oferta;
            }
        }

        $items = [];
        $totales = ['mensual' => 0, 'único' => 0];
        foreach ($datos['ofertas'] as $seleccion) {
            $oferta = $catalogo[$seleccion['id']] ?? null;
            if (!$oferta) {
                throw ValidationException::withMessages(['ofertas' => 'Una oferta ya no está disponible. Actualiza el carrito.']);
            }
            $cantidad = (int) $seleccion['cantidad'];
            $precio = $oferta['precio'] ?? null;
            $periodo = $oferta['periodo'] ?? null;
            $centimos = is_numeric($precio) && $precio >= 0 && isset($totales[$periodo]) ? (int) round($precio * 100) : null;
            if ($centimos !== null) $totales[$periodo] += $centimos * $cantidad;
            $items[] = [
                'referencia' => $oferta['id'], 'nombre' => $oferta['nombre'],
                'categoria' => $oferta['categoria'], 'unidad' => $oferta['unidad'], 'cantidad' => $cantidad,
                'precio_centimos' => $centimos, 'periodo' => $periodo,
            ];
        }

        $token = bin2hex(random_bytes(32));
        try {
            DB::transaction(function () use ($datos, $items, $totales, $token) {
                SolicitudCotizacion::create([
                    'codigo' => 'B2-'.strtoupper(Str::random(12)),
                    'token_hash' => hash('sha256', $token),
                    'ruc' => $datos['ruc'], 'razon_social' => trim($datos['razon_social']),
                    'contacto' => trim($datos['contacto']), 'telefono' => $datos['telefono'],
                    'origen' => 'web', 'ofertas' => $items,
                    'total_mensual_centimos' => $totales['mensual'], 'total_unico_centimos' => $totales['único'],
                ]);
            });
        } catch (Throwable $exception) {
            Log::error('No se pudo guardar una solicitud de cotización.', ['exception_class' => get_class($exception)]);
            return back()->withInput()->withErrors(['guardado' => 'No fue posible guardar la solicitud. Inténtalo nuevamente.']);
        }

        return redirect()->route('cotizacion.propuesta', ['token' => $token]);
    }

    public function propuesta(string $token)
    {
        abort_unless(preg_match('/\A[a-f0-9]{64}\z/', $token), 404);
        $solicitud = SolicitudCotizacion::where('token_hash', hash('sha256', $token))->firstOrFail();

        return response()->view('cotizacion.propuesta', compact('solicitud'))
            ->header('Cache-Control', 'no-store, private')
            ->header('Referrer-Policy', 'no-referrer')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
