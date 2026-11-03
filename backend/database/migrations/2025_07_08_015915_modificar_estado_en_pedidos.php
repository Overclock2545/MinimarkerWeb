<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class ModificarEstadoEnPedidos extends Migration

{
    public function up()
    {
        // La migración inicial usa texto para admitir los estados en todos los motores.
    }

    public function down()
    {
        // Opcionalmente puedes volver al ENUM anterior
        // No hay cambio de esquema que revertir.
    }
}
