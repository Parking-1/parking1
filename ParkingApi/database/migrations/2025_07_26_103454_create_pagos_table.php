<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('cliente')->onDelete('cascade');
            $table->string('placa');
            $table->unsignedTinyInteger('tipo_vehiculo'); // 1: Moto, 2: Carro, etc.
            $table->decimal('monto', 10, 2);
            $table->integer('dias_pagados');
            $table->date('fecha_inicio');
            $table->date('fecha_vencimiento');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
}

