<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuracion;

class ConfiguracionSeeder extends Seeder
{
    public function run()
    {
        Configuracion::create([
            'nombre_empresa' => 'Mi Parqueadero S.A.S.',
            'nit' => '123456789-0',
            'direccion' => 'Cra 1 # 2-34',
            'telefono' => '3001234567',
            'leyenda' => 'Gracias por su visita',
        ]);
    }
}

