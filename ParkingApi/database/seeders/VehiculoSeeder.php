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
          Vehiculo::insert(
        [
            [
                "placa" => "abc123",
                "id_cliente" => 32,
                "id_tipo_vehiculo" => 1
            ],
            [
                "placa" => "acf234",
                "id_cliente" => 29,
                "id_tipo_vehiculo" => 2
            ],
            [
                "placa" => "agf543",
                "id_cliente" => 42,
                "id_tipo_vehiculo" => 3
            ],
            [
                "placa" => "xxa231",
                "id_cliente" => 37,
                "id_tipo_vehiculo" => 2
            ],
            [
                "placa" => "xad414",
                "id_cliente" => 35,
                "id_tipo_vehiculo" => 1
            ],
            [
                "placa" => "asd",
                "id_cliente" => 30,
                "id_tipo_vehiculo" => 1
            ],
        ]);
    }
}
