<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plan_abonado', function (Blueprint $table) {
            if (!Schema::hasColumn('plan_abonado', 'vehiculo_id')) {
                $table->unsignedBigInteger('vehiculo_id')->nullable()->after('cliente_id');

                if (Schema::hasTable('vehiculos')) {
                    $table->foreign('vehiculo_id')
                        ->references('id')
                        ->on('vehiculos') // ✅ nombre correcto
                        ->onDelete('set null');
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('plan_abonado', function (Blueprint $table) {
            if (Schema::hasColumn('plan_abonado', 'vehiculo_id')) {
                $table->dropForeign(['vehiculo_id']);
                $table->dropColumn('vehiculo_id');
            }
        });
    }
};


