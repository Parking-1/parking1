<?php
namespace App\Http\Controllers;

use App\Models\Transaccion;
use App\Models\Espacio;

class ParqueaderoController extends Controller
{
    public function resumen()
    {
        $totalEspacios = Espacio::count();

        // Contamos las transacciones sin salida
        $ocupados = Transaccion::whereNull('fecha_salida')->count();

        $disponibles = $totalEspacios - $ocupados;

        return response()->json([
            'total' => $totalEspacios,
            'ocupados' => $ocupados,
            'disponibles' => $disponibles
        ]);
    }
}



