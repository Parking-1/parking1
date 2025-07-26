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
    Schema::table('configuraciones', function (Blueprint $table) {
        $table->integer('capacidad_total')->default(0);
        $table->integer('espacios_disponibles')->default(0);
    });
}

public function down()
{
    Schema::table('configuraciones', function (Blueprint $table) {
        $table->dropColumn(['capacidad_total', 'espacios_disponibles']);
    });
}

};
