<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;

class Product extends Model
{
    protected $table = 'product';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function favoritos()
    {
        return $this->belongsToMany(User::class, 'favoritos')->withTimestamps();
    }

    // App\Models\Product.php
protected $fillable = [
    'nombre',
    'categoria_id',
    'precio',
    'stock',
    'descripcion',
    'imagen',
    'precio_oferta',
    'oferta_activa',
    'fecha_fin_oferta',
];

protected $casts = [
    'oferta_activa' => 'boolean',
    'fecha_fin_oferta' => 'date',
];


    public function pedidoItems()
    {
        return $this->hasMany(PedidoItem::class);
    }
    public function imagenes()
{
    return $this->hasMany(ImagenProducto::class, 'product_id', 'id');
}

}
