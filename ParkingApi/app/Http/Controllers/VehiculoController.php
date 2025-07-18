<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Interface\IPdf;

// Responses
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;

class VehiculoController extends Controller
{
    public function save(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'placa' => [
                'required',
                'string',
                Rule::unique('vehiculo')->where(function ($query) use ($input) {
                    return $query->where('id_tipo_vehiculo', $input['id_tipo_vehiculo']);
                }),
            ],
            'id_tipo_vehiculo' => 'required|exists:tipo_vehiculo,id',
            'id_cliente' => 'nullable|exists:cliente,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validación fallida',
                'details' => $validator->errors(),
            ], 422);
        }

        try {
            $vehiculo = Vehiculo::create([
                'placa' => strtoupper($input['placa']),
                'id_tipo_vehiculo' => $input['id_tipo_vehiculo'],
                'id_cliente' => $input['id_cliente'] ?? null,
            ]);

            return response()->json(["data" => $vehiculo], 201);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al crear el vehículo"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function firstOrCreateByPlaca(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'placa' => 'required|string',
            'id_tipo_vehiculo' => 'required|exists:tipo_vehiculo,id',
            'id_cliente' => 'nullable|exists:cliente,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validación fallida',
                'details' => $validator->errors(),
            ], 422);
        }

        try {
            $placa = strtoupper($input['placa']);
            $vehiculo = Vehiculo::whereRaw('LOWER(placa) = ?', [strtolower($placa)])->first();

            if ($vehiculo) {
                return response()->json(['data' => $vehiculo, 'message' => 'Vehículo ya existe'], 200);
            }

            $vehiculo = Vehiculo::create([
                'placa' => $placa,
                'id_tipo_vehiculo' => $input['id_tipo_vehiculo'],
                'id_cliente' => $input['id_cliente'] ?? null,
            ]);

            return response()->json(['data' => $vehiculo, 'message' => 'Vehículo creado'], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function GetByPlaca(Request $request): JsonResponse
    {
        try {
            $vehiculo = Vehiculo::whereRaw('LOWER(placa) = ?', [strtolower($request->query('placa'))])->firstOrFail();
            return response()->json(['data' => $vehiculo], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Vehículo no encontrado'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPaginate(): JsonResponse
    {
        try {
            $vehiculos = Vehiculo::paginate(15);
            if ($vehiculos->isNotEmpty()) {
                $this->authorize('view', $vehiculos->first());
            }
            return response()->json(["data" => $vehiculos], 200);
        } catch (AuthorizationException $e) {
            return response()->json(["error" => "No autorizado"], 403);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function getById($id): JsonResponse
    {
        try {
            $vehiculo = Vehiculo::findOrFail((int) $id);
            $this->authorize('view', $vehiculo);
            return response()->json(["data" => $vehiculo], 200);
        } catch (AuthorizationException $e) {
            return response()->json(["error" => "No autorizado para ver los datos"], 403);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Vehículo no encontrado"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function addRange(Request $request): JsonResponse
    {
        try {
            DB::transaction(function () use ($request) {
                foreach ($request->all() as $vehiculoData) {
                    Vehiculo::create([
                        "placa" => strtoupper($vehiculoData["placa"]),
                        "id_tipo_vehiculo" => $vehiculoData["id_tipo_vehiculo"],
                        "id_cliente" => $vehiculoData["id_cliente"] ?? null,
                    ]);
                }
            });

            return response()->json(["data" => true], 201);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al guardar los vehículos"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $vehiculo = Vehiculo::findOrFail($id);
            $this->authorize('delete', $vehiculo);
            $vehiculo->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Vehículo no encontrado"], 404);
        } catch (AuthorizationException $e) {
            return response()->json(["error" => "No autorizado para eliminar"], 403);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error en la consulta"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function deleteRange(Request $request): JsonResponse
    {
        try {
            Vehiculo::whereIn("id", $request->input("ids"))->delete();
            return response()->json(null, 204);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar los vehículos"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $vehiculo = Vehiculo::findOrFail($id);
                $this->authorize('update', $vehiculo);
                $vehiculo->update($request->all());
            });

            return response()->json(["message" => "Vehículo actualizado"], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Vehículo no encontrado"], 404);
        } catch (AuthorizationException $e) {
            return response()->json(["error" => "No autorizado para editar"], 403);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al actualizar"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function getWithCliente(): JsonResponse
    {
        try {
            $datos = Vehiculo::with("cliente")->get();
            return response()->json(["data" => $datos], 200);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al consultar"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function getGroupVehiculos(): JsonResponse
    {
        try {
            $vehiculos = Vehiculo::join("tipo_vehiculo", "vehiculo.id_tipo_vehiculo", "=", "tipo_vehiculo.id")
                ->join("espacio_vehiculo", "espacio_vehiculo.vehiculo_id", "=", "vehiculo.id")
                ->join("espacio", "espacio_vehiculo.espacio_id", "=", "espacio.id")
                ->select(DB::raw("tipo_vehiculo.descripcion, count(*) as total"))
                ->where("espacio.estado", "disponible")
                ->groupBy("tipo_vehiculo.descripcion")
                ->get();

            return response()->json(["data" => $vehiculos], 200);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al consultar"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function getReport(IPdf $pdf)
    {
        $data = Vehiculo::with("tipoVehiculo")->get();
        $pdf->body($data->toArray(), "vehiculo");
    }
}



