<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('solicitudes_cotizacion', function (Blueprint $table) {
            $table->string('codigo_referido', 32)->nullable()->unique();
            $table->foreignId('referido_por_id')->nullable()->constrained('solicitudes_cotizacion')->nullOnDelete();
            $table->string('ejecutivo_demo', 80)->nullable();
        });
        Schema::create('solicitudes_contacto_demo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')->constrained('solicitudes_cotizacion')->cascadeOnDelete();
            $table->string('preferencia', 30);
            $table->string('procedencia', 30);
            $table->string('ejecutivo_demo', 80)->nullable();
            $table->timestamps();
        });
        Schema::create('encuestas_demo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')->unique()->constrained('solicitudes_cotizacion')->cascadeOnDelete();
            $table->unsignedTinyInteger('valoracion');
            $table->string('comentario', 500)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('encuestas_demo');
        Schema::dropIfExists('solicitudes_contacto_demo');
        Schema::table('solicitudes_cotizacion', function (Blueprint $table) {
            $table->dropConstrainedForeignId('referido_por_id');
            $table->dropUnique(['codigo_referido']);
            $table->dropColumn(['codigo_referido', 'ejecutivo_demo']);
        });
    }
};
