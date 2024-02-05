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
        Schema::create('tarifa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_tipo_vehiculo");
            $table->foreign('id_tipo_vehiculo')->references('id')->on('tipo_vehiculo');
            $table->enum("tipo_tarifa", ["diario", "mensual", "hora"]);
            $table->double("precio_base", 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarifa');
    }
};
