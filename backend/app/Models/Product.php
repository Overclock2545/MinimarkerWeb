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

    protected $fillable = [
        'nombre',
        'categoria_id',
        'precio',
        'descripcion',
        'stock',
        'imagen', // Solo si planeas permitir subir/cambiar imagen desde el formulario
    ];
}
