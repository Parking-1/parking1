<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoVehiculo;
use Illuminate\Support\Facades\DB;

class TipoVehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Limpia la tabla primero

DB::table('tipo_vehiculo')->delete(); // ✅ borra sin reiniciar el autoincremento

        // Luego inserta los valores con ID explícito
        TipoVehiculo::insert([
    ["id" => 1, "descripcion" => "Moto"],
    ["id" => 2, "descripcion" => "Carro"],
    ["id" => 3, "descripcion" => "Camion"],
    ["id" => 4, "descripcion" => "Autobus"],
    ["id" => 5, "descripcion" => "Vehiculo Sin Determinar"],
]);

    }
}
