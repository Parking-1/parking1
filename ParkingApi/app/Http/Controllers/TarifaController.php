<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Modelos
use App\Models\Tarifa;

// Responses
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

// Excepciones
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TarifaController extends Controller
{
    public function GetAll(): JsonResponse
{
    try {
        $tarifas = Tarifa::all();
        return response()->json(["data" => $tarifas], 200);
    } catch (Exception $e) {
        return response()->json(["error" => $e->getMessage()], 500);
    }
}

    public function store(Request $request): JsonResponse
    {
        try {
            $tarifa = Tarifa::create($request->all());
            return response()->json(["data" => $tarifa], 201);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al crear la tarifa"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function GetPaginate(): JsonResponse
    {
        try {
            $datos = Tarifa::paginate(15);
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
            $tarifa = Tarifa::findOrFail((int) $id);
            return response()->json(["data" => $tarifa], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Tarifa no encontrada"], 404);
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
                    Tarifa::create([
                        "id_tipo_vehiculo" => $item["id_tipo_vehiculo"],
                        "tipo_tarifa" => $item["tipo_tarifa"],
                        "precio_base" => $item["precio_base"],
                    ]);
                }
            });
            return response()->json(["data" => true], 201);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function Delete($id): JsonResponse
    {
        try {
            Tarifa::findOrFail($id)->delete();
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Tarifa no encontrada"], 404);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar Tarifa"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => "Error desconocido"], 500);
        }
    }

    public function DeleteRange(Request $request): JsonResponse
    {
        try {
            Tarifa::whereIn("id", $request->input("ids"))->delete();
            return response()->noContent();
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar Tarifas"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function Update(Request $request, $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($request, $id): void {
                $tarifa = Tarifa::findOrFail($id);
                $tarifa->update($request->all());
            });
            return response()->json(["status" => 200]);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Tarifa no encontrada"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}

