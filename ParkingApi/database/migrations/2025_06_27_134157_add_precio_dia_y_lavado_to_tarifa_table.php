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
    Schema::table('tarifa', function (Blueprint $table) {
        $table->double('precio_dia', 12, 2)->nullable()->after('precio_base');
        $table->double('precio_lavado', 12, 2)->nullable()->after('precio_dia');
    });
}

public function down()
{
    Schema::table('tarifa', function (Blueprint $table) {
        $table->dropColumn(['precio_dia', 'precio_lavado']);
    });
}

};
