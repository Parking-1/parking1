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
        Schema::create('espacio_vehiculo', function (Blueprint $table) {
            $table->unsignedBigInteger("id_espacio");
            $table->foreign("id_espacio")->references("id")->on("espacio");
            $table->unsignedBigInteger("id_vehiculo");
            $table->foreign("id_vehiculo")->references("id")->on("vehiculo");
            $table->primary("id_espacio");
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
        Schema::dropIfExists('espacio_vehiculo');
    }
};
