<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_page', function (Blueprint $table) {
            $table->string('subtitulo')->nullable()->after('titulo');
            $table->string('link_boton')->default('/inicio')->after('boton');
            $table->string('color_boton')->default('#111827')->after('link_boton');
            $table->string('video_url')->nullable()->after('color_boton');
            $table->string('imagen_secundaria')->nullable()->after('video_url');
            $table->boolean('mostrar_logo')->default(false)->after('imagen_secundaria');
            $table->boolean('mostrar_contador')->default(false)->after('mostrar_logo');
            $table->date('fecha_limite')->nullable()->after('mostrar_contador');
        });
    }

    public function down(): void
    {
        Schema::table('landing_page', function (Blueprint $table) {
            $table->dropColumn([
                'subtitulo',
                'link_boton',
                'color_boton',
                'video_url',
                'imagen_secundaria',
                'mostrar_logo',
                'mostrar_contador',
                'fecha_limite'
            ]);
        });
    }
};
