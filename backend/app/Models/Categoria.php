<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias'; // 👈 nombre correcto de la tabla
    protected $fillable = ['nombre'];

    // Opcional: si tienes relación inversa
    public function productos()
    {
        return $this->hasMany(Product::class, 'categoria_id');
    }
}
