<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{

    protected $fillable = [
        'pedido_id',
        'product_id',
        'cantidad',
        'precio_unitario',
    ];

    public function producto()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    //
}
