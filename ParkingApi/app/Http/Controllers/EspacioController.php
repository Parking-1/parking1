<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Modelos
use App\Models\Espacio;

// Responses
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

// Excepciones
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EspacioController extends Controller
{
    public function Save(Request $request): JsonResponse
    {
        try {
            $espacio = Espacio::create($request->all());
            return response()->json(["data" => $espacio], 201);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al crear el Espacio"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function GetPaginate(): JsonResponse
    {
        try {
            $datos = Espacio::paginate(15);
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
            $datos = Espacio::findOrFail((int)$id);
            return response()->json(["data" => $datos], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Espacio no encontrado"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function AddRange(Request $request): JsonResponse
    {
        try {
            $data = $request->all(); // Laravel ya convierte JSON
            DB::transaction(function () use ($data): void {
                foreach ($data as $item) {
                    Espacio::create([
                        "descripcion" => $item["descripcion"],
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
            Espacio::findOrFail($id)->delete();
            return response()->noContent(); // 204
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Espacio no encontrado"], 404);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar Espacio"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => "Error desconocido"], 500);
        }
    }

    public function DeleteRange(Request $request): JsonResponse
    {
        try {
            Espacio::whereIn("id", $request->input("ids"))->delete();
            return response()->noContent(); // 204
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar Espacios"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function Update(Request $request, $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($request, $id): void {
                $espacio = Espacio::findOrFail($id);
                $espacio->update($request->all());
            });
            return response()->json(["status" => 200]);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Espacio no encontrado"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function GetEspacesBy($estado): JsonResponse
    {
        try {
            $datos = Espacio::where("estado", $estado)->get();
            return response()->json(["datos" => $datos], 200);
        } catch (QueryException $err) {
            return response()->json(["error" => "Error en la consulta"], 500);
        } catch (Exception $err) {
            return response()->json(["error" => $err->getMessage()], 500);
        }
    }
}


