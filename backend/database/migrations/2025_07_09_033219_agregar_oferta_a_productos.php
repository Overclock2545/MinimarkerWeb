<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgregarOfertaAProductos extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->decimal('precio_oferta', 8, 2)->nullable()->after('precio');
            $table->boolean('oferta_activa')->default(false)->after('precio_oferta');
            $table->date('fecha_fin_oferta')->nullable()->after('oferta_activa');
        });
    }

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('product', function (Blueprint $table) {
        $table->dropColumn(['precio_oferta', 'oferta_activa', 'fecha_fin_oferta']);
    });
}

}
