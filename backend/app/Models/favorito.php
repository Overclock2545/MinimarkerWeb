<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class favorito extends Model
{

    protected $table = 'favoritos'; // Asegúrate que coincide con el nombre de tu tabla
    protected $fillable = ['user_id', 'product_id'];

    public function producto()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    //
}
