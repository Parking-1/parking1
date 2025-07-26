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
        $total = Configuracion::value('capacidad_total');
        $disponibles = Configuracion::value('espacios_disponibles');
        $abonados = PlanAbonado::whereDate('fecha_fin', '>=', now())->count();
        $ocupados = $total - $disponibles;

        return response()->json([
            'capacidad_total' => $total,
            'espacios_disponibles' => $disponibles,
            'abonados' => $abonados,
            'ocupados' => $ocupados,
        ]);
    }

    public function liberarEspacio(): JsonResponse
{
    try {
        $config = Configuracion::first();

        if (!$config) {
            return response()->json(['error' => 'Configuración no encontrada.'], 404);
        }

        if ($config->espacios_disponibles < $config->capacidad_total) {
            $config->espacios_disponibles += 1;
            $config->save();
            return response()->json(['message' => 'Espacio liberado exitosamente.']);
        }

        return response()->json(['message' => 'Ya están disponibles todos los espacios.'], 400);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al liberar espacio.'], 500);
    }
}

}

