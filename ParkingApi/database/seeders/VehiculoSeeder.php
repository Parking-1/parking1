<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehiculo;

class VehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          // Crear datos principales
          $datosPrincipales = Vehiculo::factory(5)->create();

          // Asignar datos hijos a datos principales
          foreach ($datosPrincipales as $datoPrincipal) {
              Vehiculo::factory(3)->create(['id_cliente' => $datoPrincipal->id]);
              Vehiculo::factory(3)->create(['id_tipo_vehiculo' => $datoPrincipal->id]);

          }
    }
}
