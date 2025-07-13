<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaccion;
use App\Models\PlanAbonado;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function generar(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date',
        ]);

        $inicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fin = Carbon::parse($request->fecha_final)->endOfDay();

        $tipo = $request->tipo;
        $resultado = [];

        switch ($tipo) {
            case 'tickets':
                $resultado = Transaccion::whereBetween('created_at', [$inicio, $fin])->get();
                break;
            case 'salidas':
                $resultado = Transaccion::whereNotNull('fecha_salida')->whereBetween('fecha_salida', [$inicio, $fin])->get();
                break;
            case 'estacionados':
                $resultado = Transaccion::whereNull('fecha_salida')->get();
                break;
            case 'pagos':
                $resultado = PlanAbonado::with('cliente', 'vehiculo')
                    ->whereBetween('created_at', [$inicio, $fin])
                    ->get();
                break;
            default:
                return response()->json(['error' => 'Tipo de reporte no válido.'], 400);
        }

        return response()->json(['data' => $resultado], 200);
    }
}

