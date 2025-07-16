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
        Schema::create('plan_abonado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('cliente')->onDelete('cascade');

            $table->string('tipo_plan'); // semanal o mensual
            $table->integer('duracion'); // en días
            $table->decimal('monto', 10, 2); // monto por unidad
            $table->decimal('total', 10, 2); // total pagado
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();

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
        Schema::dropIfExists('plan_abonado');
    }
};
