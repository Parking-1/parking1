<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use App\Models\PlanAbonado;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ConfiguracionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isGranted('Administrador')) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $config = Configuracion::first();
        return response()->json($config);
    }

    public function update(Request $request)
    {
        $config = Configuracion::firstOrCreate([]);

        $config->update($request->only([
            'nombre_empresa', 'nit', 'direccion', 'telefono', 'leyenda'
        ]));

        return response()->json(['message' => 'Configuración actualizada', 'data' => $config]);
    }

    public function resumen(): JsonResponse
    {
        $total = Configuracion::value('espacios_totales');
        $disponibles = Configuracion::value('espacios_disponibles');
        $abonados = PlanAbonado::whereDate('fecha_fin', '>=', now())->count();
        $ocupados = $total - $disponibles;

        return response()->json([
            'espacios_totales' => $total,
            'espacios_disponibles' => $disponibles,
            'abonados' => $abonados,
            'ocupados' => $ocupados,
        ]);
    }
}

