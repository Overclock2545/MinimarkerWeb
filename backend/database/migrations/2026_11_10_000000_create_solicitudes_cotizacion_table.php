<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('solicitudes_cotizacion', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 24)->unique();
            $table->char('token_hash', 64)->unique();
            $table->string('ruc', 11);
            $table->string('razon_social', 160);
            $table->string('contacto', 120);
            $table->string('telefono', 20);
            $table->string('origen', 40);
            $table->json('ofertas');
            $table->unsignedBigInteger('total_mensual_centimos');
            $table->unsignedBigInteger('total_unico_centimos');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_cotizacion');
    }
};
