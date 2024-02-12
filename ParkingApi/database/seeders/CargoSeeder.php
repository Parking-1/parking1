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
            ["nombre" => "vigilante"],
            ["nombre" => "administrador"],
            ["nombre" => "encargado"]
        ]);
    }
}
