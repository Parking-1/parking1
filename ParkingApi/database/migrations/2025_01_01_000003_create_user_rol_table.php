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
        Schema::create('user_rol', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('id_user');
    $table->unsignedBigInteger('id_rol');

    // Relaciones
    $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('id_rol')->references('id')->on('roles')->onDelete('cascade');

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
        Schema::dropIfExists('user_rol');
    }
};
