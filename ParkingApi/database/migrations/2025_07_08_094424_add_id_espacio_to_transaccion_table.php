<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaccion', function (Blueprint $table) {
            $table->unsignedBigInteger('id_espacio')->after('id_tarifa');

        // Si hay relación con tabla espacio
            $table->foreign('id_espacio')->references('id')->on('espacio')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaccion', function (Blueprint $table) {
            $table->dropForeign(['id_espacio']);
            $table->dropColumn('id_espacio');
        });
    }
};
