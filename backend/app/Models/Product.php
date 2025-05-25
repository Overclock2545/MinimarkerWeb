<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Esto fuerza a Laravel a usar la tabla 'product'
    protected $table = 'product';
}
