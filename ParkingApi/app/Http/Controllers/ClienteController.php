<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ClienteController extends Controller
{
    public function Save(Request $request): JsonResponse
    {
        try {
            $cliente = Cliente::create($request->all());
            return response()->json(["data" => $cliente], 201);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al crear el cliente"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function GetById($id): JsonResponse
    {
        try {
            $datos = Cliente::with('vehiculo')->findOrFail($id);
            return response()->json(["data" => $datos], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Cliente no encontrado"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    // 🔍 Buscar por documento (cedula)
    public function getByDocumento(string $cedula): JsonResponse
    {
        try {
            $cliente = Cliente::where('cedula', $cedula)->with('vehiculo')->firstOrFail();
            return response()->json(["data" => $cliente], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Cliente no encontrado por documento"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    // 🔍 Buscar por placa
    public function getByPlaca(string $placa): JsonResponse
    {
        try {
            $cliente = Cliente::whereHas('vehiculo', function ($q) use ($placa) {
                $q->where('placa', strtoupper($placa));
            })->with('vehiculo')->firstOrFail();

            return response()->json(["data" => $cliente], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Cliente no encontrado por placa"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    // 🔍 Buscar por nombre y apellido (opcional)
    public function getByNombreApellido(Request $request): JsonResponse
    {
        try {
            $nombre   = $request->input('nombre');
            $apellido = $request->input('apellido');

            $query = Cliente::query();

            if ($nombre) $query->where('nombre', 'LIKE', "%$nombre%");
            if ($apellido) $query->where('apellido', 'LIKE', "%$apellido%");

            $clientes = $query->with('vehiculo')->get();

            return response()->json(["data" => $clientes], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function SaveAbonado(Request $request): JsonResponse
    {
    try {
        $request->validate([
    'nombre'   => 'required|string|max:50',
    'apellido' => 'required|string|max:50',
    'cedula'   => 'required|string|max:50|unique:cliente,cedula',
    'telefono' => 'required|string|max:50',
]);

        $cliente = Cliente::create([
            "nombre"   => $request->input("nombre"),
            "apellido"=> $request->input("apellido"),
            "cedula"  => $request->input("cedula"),
            "telefono"=> $request->input("telefono"),
        ]);

        // Si también quieres guardar el vehículo:
        if ($request->filled("placa")) {
            $cliente->vehiculo()->create([
                "placa"            => strtoupper($request->input("placa")),
                "id_tipo_vehiculo" => $request->input("id_tipo_vehiculo", 1) // por defecto tipo 1
            ]);
        }

        return response()->json(["data" => $cliente], 201);
    } catch (Exception $e) {
        return response()->json(["error" => $e->getMessage()], 500);
    }
    }

    public function SavePlanAbonado(Request $request): JsonResponse
{
    $request->validate([
    'nombre'       => 'required|string|max:50',
    'apellido'     => 'required|string|max:50',
    'cedula'       => 'required|string|max:50|unique:cliente,cedula',
    'telefono'     => 'required|string|max:50',
    'tipo_plan'    => 'required|string',
    'duracion'     => 'required|integer',
    'monto'        => 'required|numeric',
    'total'        => 'required|numeric',
    'fecha_inicio' => 'required|date',
]);

    try {
        DB::transaction(function () use ($request) {
            // 1. Crear cliente
            $cliente = Cliente::firstOrCreate([
                'nombre'    => $request->nombre,
                'apellido'  => $request->apellido,
                'cedula'    => $request->cedula,
                'telefono'  => $request->telefono,
            ]);

            // Si el cliente tiene un plan vigente, rechazar
            $tienePlanActivo = $cliente->planes()
                ->whereDate('fecha_fin', '>=', now())
                ->exists();

            if ($tienePlanActivo) {
                throw new \Exception('Este cliente ya tiene un plan activo.');
            }

            // 2. Crear vehículo si aplica
            if ($request->filled('placa')) {
                $cliente->vehiculo()->create([
                    'placa'            => strtoupper($request->placa),
                    'id_tipo_vehiculo' => $request->id_tipo_vehiculo ?? 1
                ]);
            }
            $fechaFin = now()->parse($request->fecha_inicio)->addDays($request->duracion);
            // 3. Crear plan del abonado
            $cliente->planes()->create([
                'tipo_plan'    => $request->tipo_plan,
                'duracion'     => (int) $request->duracion,
                'monto'        => $request->monto,
                'total'        => $request->total,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin'    => $fechaFin, // <-- nueva columna
            ]);
        });

        return response()->json(['message' => 'Plan del abonado guardado'], 201);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    public function tienePlanActivo($id): JsonResponse
{
    try {
        $cliente = Cliente::with(['planes' => function ($q) {
            $q->whereDate('fecha_fin', '>=', now());
        }])->findOrFail($id);

        $activo = $cliente->planes->isNotEmpty();

        return response()->json([
            'activo' => $activo,
            'vigente_hasta' => $activo ? $cliente->planes->first()->fecha_fin : null
        ]);
    } catch (Exception $e) {
        return response()->json(["error" => $e->getMessage()], 500);
    }
}

public function update(Request $request, $id)
{
    $request->validate([
        'tipo_plan' => 'required|string',
        'duracion' => 'required|integer',
        'monto' => 'required|numeric',
        'total' => 'required|numeric',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date',
    ]);

    $plan = PlanAbonado::findOrFail($id);
    $plan->update($request->only([
        'tipo_plan', 'duracion', 'monto', 'total', 'fecha_inicio', 'fecha_fin'
    ]));

    return response()->json(['message' => 'Plan actualizado']);
}

}
