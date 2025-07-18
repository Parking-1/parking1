<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function __construct()
    {
        // Solo admins pueden acceder
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
}
