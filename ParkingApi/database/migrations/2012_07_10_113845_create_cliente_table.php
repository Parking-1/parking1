<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 50);
            $table->string("apellido", 50);
            $table->string("cedula", 50)->unique();
            $table->string("telefono", 50); // <- ✅ Acepta cadenas tipo "3101234567"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
