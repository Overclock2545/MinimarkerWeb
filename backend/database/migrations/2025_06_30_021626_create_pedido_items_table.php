<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedido_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            // Se cambia la columna a string en lugar de foreignId
            $table->string('product_id', 50);
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 8, 2);
            $table->timestamps();
            // Agregamos la clave foránea manualmente si la tabla 'product' usa un varchar(50)
            $table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_items');
    }
};
