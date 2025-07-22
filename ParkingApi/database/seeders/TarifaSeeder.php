<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoVehiculo;
use App\Models\Tarifa;

class TarifaSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = TipoVehiculo::all();

        foreach ($tipos as $tipo) {
            // Evitar duplicar tarifas si ya existe una para este tipo
            if (!$tipo->tarifa()->exists()) {
                Tarifa::create([
                    'id_tipo_vehiculo' => $tipo->id,
                    'tipo_tarifa' => 'hora',         // Puedes variar esto si lo necesitas
                    'precio_base' => 2000,
                    'precio_dia' => 15000,
                    'precio_lavado' => 5000,
                ]);
            }
        }
    }
}


