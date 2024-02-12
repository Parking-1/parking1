<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoVehiculo;

class TipoVehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoVehiculo::insert([
            ["descripcion" =>  "Moto"],
            ["descripcion" =>  "Carro"],
            ["descripcion" =>  "Camion"],
            ["descripcion" =>  "Autobus"],
            ["descripcion" =>  "Vehiculo Sin Determinar"],

        ]);
    }
}
