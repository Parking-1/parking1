<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;




class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        RolSeeder::class,
        CargoSeeder::class,
        TipoVehiculoSeeder::class,
        TarifaSeeder::class,
        ClienteSeeder::class,
        EspacioSeeder::class,
        VehiculoSeeder::class,
        UserSeeder::class,
        ConfiguracionSeeder::class,
    ]);

    }
}
