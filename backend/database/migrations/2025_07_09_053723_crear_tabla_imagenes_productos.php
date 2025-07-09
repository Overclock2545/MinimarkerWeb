<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaImagenesProductos extends Migration
{
    public function up(): void
    {
        Schema::create('imagenes_productos', function (Blueprint $table) {
            $table->id();
            $table->string('ruta');
            $table->string('product_id', 20); // 👈 Mismo tipo que la columna id de product

            // No uses foreign key aquí porque Laravel/MySQL no admite claves foráneas entre strings en muchas configuraciones
            // $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes_productos');
    }
}
