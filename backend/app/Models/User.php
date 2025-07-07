<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $factory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'celular',
        'documento_identidad',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function carritoItems(): HasMany
    {
        return $this->hasMany(CarritoItem::class);
    }

    public function favoritos(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'favoritos')->withTimestamps();
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }

    public function esAdmin()
    {
        return $this->rol === 'admin';
    }
}
