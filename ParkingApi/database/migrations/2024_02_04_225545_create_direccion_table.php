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
        Schema::create('direccion', function (Blueprint $table) {
            $table->unsignedBigInteger("id_cliente");
            $table->foreign('id_cliente')
            ->references('id')
            ->on('cliente')
            ->onUpdate("cascade")
            ->onDelete("cascade");
            $table->string("calle", 30);
            $table->string("carrera", 30);
            $table->integer("numero");
            $table->text("descripcion_extra");
            $table->unsignedBigInteger("id_tipo_calle");
            $table->foreign('id_tipo_calle')
            ->references('id')
            ->on('tipo_calle');
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
        Schema::dropIfExists('direccion');
    }
};
