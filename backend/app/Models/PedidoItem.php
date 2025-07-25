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
        'subtotal',
    ];

    public function producto()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
    public function product()
{
    return $this->belongsTo(Product::class);
}


    //
}
