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
            $table->unsignedBigInteger("id_rol");
            $table->foreign('id_rol')->references('id')->on('rol');
            $table->unsignedBigInteger("id_user");
            $table->foreign('id_user')->references('id')->on('users');
            $table->timestamps();
            $table->primary(["id_rol", "id_user"]);
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
