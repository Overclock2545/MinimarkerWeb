<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;

class Product extends Model
{
    protected $table = 'product';

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
        // 👆 aclaramos que la FK es 'categoria_id'
    }
}
