<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class B2Usuario extends Authenticatable
{
    protected $table = 'b2_usuarios';
    protected $fillable = ['name', 'email', 'password', 'rol'];
    protected $hidden = ['password', 'remember_token'];
    protected function casts(): array { return ['password' => 'hashed']; }
}
