<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Cliente;
use App\Models\PlanAbonado;
use App\Models\Vehiculo;
use App\Models\Configuracion;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Carbon\Carbon;

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

    public function getByNombreApellido(Request $request): JsonResponse
    {
        try {
            $query = Cliente::query();

            if ($request->filled('nombre')) {
                $query->where('nombre', 'LIKE', '%' . $request->nombre . '%');
            }

            if ($request->filled('apellido')) {
                $query->where('apellido', 'LIKE', '%' . $request->apellido . '%');
            }

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
                'cedula'   => 'required|string|max:50|unique:clientes,cedula',
                'telefono' => 'required|string|max:50',
            ]);

            $cliente = Cliente::create($request->only(['nombre', 'apellido', 'cedula', 'telefono']));

            if ($request->filled("placa")) {
                $cliente->vehiculo()->create([
                    "placa"            => strtoupper($request->input("placa")),
                    "id_tipo_vehiculo" => $request->input("id_tipo_vehiculo", 1),
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
        'cedula'       => 'required|string|max:50',
        'telefono'     => 'required|string|max:50',
        'tipo_plan'    => 'required|string',
        'duracion'     => 'required|integer|min:1',
        'monto'        => 'required|numeric|min:0',
        'total'        => 'required|numeric|min:0',
        'fecha_inicio' => 'required|date',
    ]);

    try {
        DB::transaction(function () use ($request) {
            $config = Configuracion::first();

            if ($config && $config->espacios_disponibles <= 0) {
                throw new \Exception('No hay espacios disponibles para asignar este plan.');
            }

            $cliente = Cliente::firstOrCreate(
                ['cedula' => $request->cedula],
                [
                    'nombre'   => $request->nombre,
                    'apellido' => $request->apellido,
                    'telefono' => $request->telefono,
                ]
            );

            $tienePlanActivo = $cliente->planes()
                ->whereDate('fecha_fin', '>=', now())
                ->exists();

            if ($tienePlanActivo) {
                throw new \Exception('Este cliente ya tiene un plan activo.');
            }

            $vehiculoId = null;
            if ($request->filled('placa')) {
                $vehiculo = $cliente->vehiculo()->firstOrCreate([
                    'placa'            => strtoupper($request->placa),
                    'id_tipo_vehiculo' => $request->id_tipo_vehiculo ?? 1,
                ]);
                $vehiculoId = $vehiculo->id;
            }

            $fechaFin = Carbon::parse($request->fecha_inicio)->addDays($request->duracion);

            $cliente->planes()->create([
                'tipo_plan'    => $request->tipo_plan,
                'duracion'     => $request->duracion,
                'monto'        => $request->monto,
                'total'        => $request->total,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin'    => $fechaFin,
                'vehiculo_id'  => $vehiculoId,
            ]);

            DB::table('pagos')->insert([
                'cliente_id'  => $cliente->id,
                'monto'       => $request->total,
                'fecha_pago'  => now(),
                'descripcion' => 'Pago por ' . $request->duracion . ' día(s) de plan abonado',
            ]);

            if ($config) {
                $config->espacios_disponibles = max(0, $config->espacios_disponibles - 1);
                $config->save();
            }
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
            $q->whereDate('fecha_fin', '>=', now())
              ->orderBy('fecha_fin', 'asc');
        }])->findOrFail($id);

        $activo = $cliente->planes->isNotEmpty();
        $vigenteHasta = $activo ? $cliente->planes->first()->fecha_fin : null;

        return response()->json([
            'activo' => $activo,
            'vigente_hasta' => $vigenteHasta,
        ]);

    } catch (ModelNotFoundException $e) {
        return response()->json(["error" => "Cliente no encontrado"], 404);
    } catch (Exception $e) {
        return response()->json(["error" => $e->getMessage()], 500);
    }
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_plan'    => 'required|string',
            'duracion'     => 'required|integer',
            'monto'        => 'required|numeric',
            'total'        => 'required|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date',
        ]);

        $plan = PlanAbonado::findOrFail($id);
        $plan->update($request->only([
            'tipo_plan', 'duracion', 'monto', 'total', 'fecha_inicio', 'fecha_fin',
        ]));

        return response()->json(['message' => 'Plan actualizado']);
    }

    public function buscarPlanPorCodigo(Request $request): JsonResponse
    {
        $codigo = $request->input('codigo_plan');

        try {
            $plan = DB::table('plan_abonado')
                ->join('clientes', 'plan_abonado.cliente_id', '=', 'clientes.id')
                ->leftJoin('vehiculos', 'vehiculos.cliente_id', '=', 'clientes.id')
                ->select(
                    'plan_abonado.id as plan_id',
                    'clientes.nombre',
                    'clientes.apellido',
                    'clientes.cedula',
                    'vehiculos.placa',
                    'plan_abonado.fecha_inicio',
                    'plan_abonado.fecha_fin'
                )
                ->where('plan_abonado.id', $codigo)
                ->first();

            if (!$plan) {
                return response()->json(['error' => 'Plan no encontrado'], 404);
            }

            return response()->json(['data' => $plan], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function buscarPagos(Request $request)
    {
        $query = PlanAbonado::with('cliente', 'vehiculo');

        if ($request->filled('codigo_plan')) {
            $query->where('id', $request->codigo_plan);
        }

        if ($request->filled('nombres')) {
            $query->whereHas('cliente', fn($q) =>
                $q->where('nombre', 'like', '%' . $request->nombres . '%')
                  ->orWhere('apellido', 'like', '%' . $request->nombres . '%')
            );
        }

        if ($request->filled('documento')) {
            $query->whereHas('cliente', fn($q) =>
                $q->where('cedula', $request->documento)
            );
        }

        if ($request->filled('placa')) {
            $query->whereHas('vehiculo', fn($q) =>
                $q->where('placa', strtoupper($request->placa))
            );
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha_inicio', $request->fecha);
        }

        if ($request->filled('vencimiento')) {
            $query->whereDate('fecha_fin', $request->vencimiento);
        }

        return response()->json(['data' => $query->orderByDesc('fecha_inicio')->get()]);
    }

    public function getPlanesPorCliente($clienteId): JsonResponse
{
    try {
        $planes = PlanAbonado::where('cliente_id', $clienteId)
            ->with('vehiculo')
            ->orderByDesc('fecha_inicio')
            ->get();

        return response()->json(['data' => $planes], 200);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function getPlanes(): JsonResponse
{
    try {
        $planes = PlanAbonado::with('cliente', 'vehiculo')
            ->orderByDesc('fecha_inicio')
            ->get();

        return response()->json(['data' => $planes], 200);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function eliminarPlan($id): JsonResponse
{
    try {
        DB::transaction(function () use ($id) {
            $plan = PlanAbonado::findOrFail($id);
            $plan->delete();

            // Sumar espacio disponible
            $config = Configuracion::first();
            $config->espacios_disponibles += 1;
            $config->save();
        });

        return response()->json(['message' => 'Plan eliminado correctamente']);
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Plan no encontrado'], 404);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


}

