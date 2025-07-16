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
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->id();
            $table->string("placa", 30); // 🔁 SIN unique()

            // Clave foránea a cliente
            $table->unsignedBigInteger("id_cliente")->nullable();
            $table->foreign('id_cliente')->references('id')->on('cliente')->onDelete('set null');

            // Clave foránea a tipo_vehiculo
            $table->unsignedBigInteger("id_tipo_vehiculo");
            $table->foreign('id_tipo_vehiculo')->references('id')->on('tipo_vehiculo')->onDelete('cascade');

            $table->timestamps();

            // 🔐 Clave única compuesta
            $table->unique(['placa', 'id_tipo_vehiculo']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculo');
    }
};

