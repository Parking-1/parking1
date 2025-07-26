<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cargo;
class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cargo::insert([
    ["id" => 1, "nombre" => "vigilante"],
    ["id" => 2, "nombre" => "administrador"],
    ["id" => 3, "nombre" => "encargado"]
]);

    }
}
