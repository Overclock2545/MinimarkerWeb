<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;

class CarritoItem extends Model
{
    protected $table = 'carrito_items';

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'user_id',
        'product_id',
        'cantidad',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    //
}
