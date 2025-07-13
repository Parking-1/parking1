<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vehiculo', function (Blueprint $table) {
            // Solo agrega la columna si no existe aún
            if (!Schema::hasColumn('vehiculo', 'cliente_id')) {
                $table->unsignedBigInteger('cliente_id')->nullable()->after('id');
            }

            // Verifica si la tabla relacionada existe antes de aplicar la clave foránea
            if (Schema::hasTable('clientes')) {
                $table->foreign('cliente_id')
                      ->references('id')
                      ->on('clientes') // nombre correcto: clientes
                      ->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('vehiculo', function (Blueprint $table) {
            // Asegúrate de que la clave y columna existen antes de intentar borrarlas
            if (Schema::hasColumn('vehiculo', 'cliente_id')) {
                $table->dropForeign(['cliente_id']);
                $table->dropColumn('cliente_id');
            }
        });
    }
};
