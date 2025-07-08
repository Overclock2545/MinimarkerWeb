<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class ModificarEstadoEnPedidos extends Migration

{
    public function up()
    {
        DB::statement("ALTER TABLE pedidos MODIFY estado ENUM('pendiente_pago', 'en_curso', 'entregado') NOT NULL DEFAULT 'pendiente_pago'");
    }

    public function down()
    {
        // Opcionalmente puedes volver al ENUM anterior
        DB::statement("ALTER TABLE pedidos MODIFY estado ENUM('pendiente_pago') NOT NULL DEFAULT 'pendiente_pago'");
    }
}
