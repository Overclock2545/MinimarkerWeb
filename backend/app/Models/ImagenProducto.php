<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenProducto extends Model
{
    protected $table = 'imagenes_productos';

    protected $fillable = [
        'ruta',
        'product_id',
    ];

    public function producto()
{
    return $this->belongsTo(Product::class, 'product_id', 'id');
}

}
