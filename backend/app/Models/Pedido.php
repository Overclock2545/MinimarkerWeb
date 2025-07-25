<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Pedido extends Model
{
    protected $fillable = [
    'user_id',
    'codigo_pedido',
    'total',
    'estado',
    'foto_entrega',
    'fecha_entregado',
];


    public function items()
{
    return $this->hasMany(PedidoItem::class);
}


    public function usuario()
{
    return $this->belongsTo(User::class, 'user_id');
}


    //
}
