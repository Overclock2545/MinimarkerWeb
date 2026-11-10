<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudCotizacion extends Model
{
    protected $table = 'solicitudes_cotizacion';

    protected $fillable = [
        'codigo', 'token_hash', 'ruc', 'razon_social', 'contacto', 'telefono',
        'origen', 'ofertas', 'total_mensual_centimos', 'total_unico_centimos',
    ];

    protected $casts = ['ofertas' => 'array'];
}
