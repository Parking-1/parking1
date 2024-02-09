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
        Schema::create('transaccion', function (Blueprint $table) {
            $table->id();
            $table->string("nit", 60)->unique();
            $table->unsignedBigInteger("id_vehiculo");
            $table->foreign('id_vehiculo')->references('id')->on('vehiculo');
            $table->dateTime("fecha_entrada");
            $table->dateTime("fecha_salida")->nullable();
            $table->double("precio_total",15,2)->nullable();
            $table->unsignedBigInteger("id_tarifa");
            $table->foreign('id_tarifa')->references('id')->on('tarifa');
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
        Schema::dropIfExists('transaccion');
    }
};
