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
        Rol::firstOrCreate(['nombre' => 'administrador']);
        Rol::firstOrCreate(['nombre' => 'empleado']);
    }
}

