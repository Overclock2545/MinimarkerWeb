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
    Schema::create('landing_page', function (Blueprint $table) {
        $table->id();
        $table->string('imagen');
        $table->string('titulo');
        $table->text('descripcion');
        $table->string('boton');
        $table->boolean('estado')->default(true); // true = visible, false = oculto
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('landing_page');
}

};
