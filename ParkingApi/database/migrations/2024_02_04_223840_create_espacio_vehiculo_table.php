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
            $table->unsignedBigInteger("espacio_id");
            $table->foreign("espacio_id")->references("id")->on("espacio");
            $table->unsignedBigInteger("vehiculo_id");
            $table->foreign("vehiculo_id")->references("id")->on("vehiculo");
            $table->primary(["espacio_id", "vehiculo_id"]);
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
