<?php

namespace Database\Seeders;

use App\Models\SolicitudCotizacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatosDemostracionB2Seeder extends Seeder
{
    public function run(): void
    {
        $catalogo = config('catalogo_b2');
        $categorias = array_values($catalogo);
        DB::transaction(function () use ($categorias) {
            $referentes = [];
            for ($i = 1; $i <= 240; $i++) {
                $codigo = sprintf('B2-DEMO-%04d', $i);
                $existente = SolicitudCotizacion::where('codigo', $codigo)->first();
                if ($existente) { $referentes[] = $existente; continue; }
                $fecha = now()->subDays((240 - $i) % 60)->setTime(8 + $i % 10, ($i * 7) % 60);
                $ofertas = [];
                $totalMensual = 0;
                $totalUnico = 0;
                foreach (array_unique([$i % 3, ($i + intdiv($i, 3)) % 3]) as $indice) {
                    $categoria = $categorias[$indice];
                    $oferta = $categoria['ofertas'][$i % count($categoria['ofertas'])];
                    $cantidad = 1 + ($i % 5);
                    $centimos = (int) round($oferta['precio'] * 100);
                    $ofertas[] = ['referencia' => $oferta['id'], 'nombre' => $oferta['nombre'], 'categoria' => $categoria['nombre'], 'unidad' => $categoria['unidad'], 'cantidad' => $cantidad, 'precio_centimos' => $centimos, 'periodo' => $oferta['periodo']];
                    if ($oferta['periodo'] === 'mensual') $totalMensual += $centimos * $cantidad;
                    else $totalUnico += $centimos * $cantidad;
                }
                $referente = $i % 4 === 0 ? $referentes[count($referentes) - 1] : null;
                $solicitud = new SolicitudCotizacion([
                    'codigo' => $codigo, 'token_hash' => hash('sha256', random_bytes(32)),
                    'ruc' => str_pad((string) (20000000000 + $i), 11, '0', STR_PAD_LEFT),
                    'razon_social' => sprintf('Empresa ficticia %03d', $i), 'contacto' => 'Contacto de demostración',
                    'telefono' => '900000000', 'origen' => $referente ? 'referido' : 'web', 'ofertas' => $ofertas,
                    'codigo_referido' => bin2hex(random_bytes(16)), 'referido_por_id' => $referente?->id,
                    'ejecutivo_demo' => 'Equipo de demostración', 'total_mensual_centimos' => $totalMensual,
                    'total_unico_centimos' => $totalUnico,
                ]);
                $solicitud->created_at = $fecha; $solicitud->updated_at = $fecha; $solicitud->save();
                $referentes[] = $solicitud;
                if ($i % 3 !== 0) DB::table('encuestas_demo')->insert(['solicitud_id' => $solicitud->id, 'valoracion' => 1 + (($i * 7) % 5), 'comentario' => 'Respuesta ficticia de demostración.', 'created_at' => $fecha, 'updated_at' => $fecha]);
                if ($i % 3 === 0) DB::table('solicitudes_contacto_demo')->insert(['solicitud_id' => $solicitud->id, 'preferencia' => 'llamada', 'procedencia' => 'enlace_propuesta', 'ejecutivo_demo' => 'Equipo de demostración', 'created_at' => $fecha, 'updated_at' => $fecha]);
            }
        });
    }
}
