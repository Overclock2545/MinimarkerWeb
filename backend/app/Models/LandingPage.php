<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    public $timestamps = false; // Ya que no usamos created_at ni updated_at
    protected $table = 'landing_page';

    protected $fillable = [
        'imagen',
        'titulo',
        'subtitulo',
        'descripcion',
        'boton',
        'link_boton',
        'color_boton',
        'video_url',
        'imagen_secundaria',
        'mostrar_logo',
        'mostrar_contador',
        'fecha_limite',
        'estado',
        'color_fondo'
    ];
}
