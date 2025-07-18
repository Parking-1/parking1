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
            ClienteSeeder::class,
            RolSeeder::class,
            CargoSeeder::class,
            TipoVehiculoSeeder::class,
            EspacioSeeder::class,
            VehiculoSeeder::class,
            UserSeeder::class,
            TarifaSeeder::class,
            ConfiguracionSeeder::class
        ]);

    }
}
