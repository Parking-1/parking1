<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Modelo
use App\Models\TipoVehiculo;

// Responses
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

// Excepciones
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TipoVehiculoController extends Controller
{
public function GetAll(): JsonResponse
{
    try {
        $tipos = TipoVehiculo::all(); // Asegúrate de importar el modelo si no está arriba
        return response()->json(["data" => $tipos], 200);
    } catch (Exception $e) {
        return response()->json(["error" => $e->getMessage()], 500);
    }
}


    public function Save(Request $request): JsonResponse
    {
        try {
            $tipo = TipoVehiculo::create($request->all());
            return response()->json(["data" => $tipo], 201);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al crear el tipo de vehículo"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function GetPaginate(): JsonResponse
    {
        try {
            $datos = TipoVehiculo::paginate(15);
            return response()->json(["data" => $datos], 200);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function GetById($id): JsonResponse
    {
        try {
            $tipo = TipoVehiculo::findOrFail((int) $id);
            return response()->json(["data" => $tipo], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Tipo de vehículo no encontrado"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function AddRange(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            DB::transaction(function () use ($data): void {
                foreach ($data as $item) {
                    TipoVehiculo::create([
                        "descripcion" => $item["descripcion"]
                    ]);
                }
            });
            return response()->noContent(); // HTTP 204
        } catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function Delete($id): JsonResponse
    {
        try {
            TipoVehiculo::findOrFail($id)->delete();
            return response()->noContent(); // HTTP 204
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Tipo de vehículo no encontrado"], 404);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar el tipo de vehículo"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => "Error desconocido"], 500);
        }
    }

    public function DeleteRange(Request $request): JsonResponse
    {
        try {
            TipoVehiculo::whereIn("id", $request->input("ids"))->delete();
            return response()->noContent(); // HTTP 204
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar los tipos de vehículos"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function Update(Request $request, $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($request, $id): void {
                $tipo = TipoVehiculo::findOrFail($id);
                $tipo->update($request->all());
            });
            return response()->json(["status" => 200]);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Tipo de vehículo no encontrado"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}

