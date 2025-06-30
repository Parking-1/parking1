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
    Schema::dropIfExists('user_rol');
    Schema::dropIfExists('roles');
}

public function down()
{
    // No necesitas definir nada a menos que quieras poder revertir esta eliminación.
}

};
