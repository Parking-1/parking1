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
            $resultado = Transaccion::with('vehiculo')
                ->whereBetween('created_at', [$inicio, $fin])
                ->get()
                ->map(function ($t) {
                    return [
                        'id' => $t->id,
                        'placa' => $t->vehiculo->placa ?? 'N/A',
                        'fecha_entrada' => $t->fecha_entrada,
                        'lavado' => $t->lavado,
                    ];
                });
            break;

        case 'salidas':
            $resultado = Transaccion::with('vehiculo')
                ->whereNotNull('fecha_salida')
                ->whereBetween('fecha_salida', [$inicio, $fin])
                ->get()
                ->map(function ($t) {
                    return [
                        'id' => $t->id,
                        'placa' => $t->vehiculo->placa ?? 'N/A',
                        'fecha_entrada' => $t->fecha_entrada,
                        'fecha_salida' => $t->fecha_salida,
                        'total' => $t->precio_total,
                    ];
                });
            break;

        case 'estacionados':
            $resultado = Transaccion::with('vehiculo')
                ->whereNull('fecha_salida')
                ->get()
                ->map(function ($t) {
                    return [
                        'id' => $t->id,
                        'placa' => $t->vehiculo->placa ?? 'N/A',
                        'fecha_entrada' => $t->fecha_entrada,
                    ];
                });
            break;

        case 'pagos':
            $resultado = PlanAbonado::with('cliente', 'vehiculo')
                ->whereBetween('created_at', [$inicio, $fin])
                ->get()
                ->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'cliente' => [
                            'nombre' => $p->cliente->nombre ?? '',
                            'apellido' => $p->cliente->apellido ?? '',
                            'cedula' => $p->cliente->cedula ?? '',
                        ],
                        'vehiculo' => [
                            'placa' => $p->vehiculo->placa ?? '-',
                        ],
                        'fecha_inicio' => $p->fecha_inicio,
                        'fecha_fin' => $p->fecha_fin,
                        'total' => $p->total,
                    ];
                });
            break;

        default:
            return response()->json(['error' => 'Tipo de reporte no válido.'], 400);
    }

    return response()->json(['data' => $resultado], 200);
}

}


