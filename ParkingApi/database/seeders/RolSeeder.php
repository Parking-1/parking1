<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::insert([
            ['nombre' => 'administrador'],
            ['nombre' => 'empleado'],
        ]);
    }
}

