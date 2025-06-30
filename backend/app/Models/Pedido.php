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
    ];

    public function items(): HasMany
    {
        return $this->hasMany(PedidoItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    //
}
