<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Espacio;

class EspacioSeeder extends Seeder
{
    public function run(): void
    {
        // Opción 1: Si quieres nombres específicos tipo A1, A2... hasta por ejemplo B10
        $letras = range('A', 'D'); // A, B, C, D
        $numeros = range(1, 10);   // 1 - 10

        foreach ($letras as $letra) {
            foreach ($numeros as $numero) {
                $descripcion = $letra . $numero;
                Espacio::firstOrCreate(
                    ['descripcion' => $descripcion],
                    ['estado' => 'Disponible']
                );
            }
        }

        // Opción 2: Si prefieres generar aleatorios válidos (hasta 100 sin riesgo)
        // Espacio::factory(100)->create(); // Comentado por si prefieres solo Opción 1
    }
}

