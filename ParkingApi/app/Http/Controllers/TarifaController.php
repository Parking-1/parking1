<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// modelos
use App\Models\Tarifa;

//responses
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

//excepciones
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class TarifaController extends Controller
{
    public function Save(Request $request) : JsonResponse{
        try{
            Tarifa::create($request->all());
            return response()->json(["data" => $request->all()], status : 201);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al crear la tarifa"], status :  500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status: 500);
        }
    }
    public function GetPaginate() : JsonResponse
    {
        try{
            $datos = Tarifa::paginate(15);
            return response()->json(["data" => $datos],  status : 200);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], status: 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status:  500);
        }
    }
    public function GetById($id) : JsonResponse {
        try{
            $datos = Tarifa::findOrFail((int)$id);
            return response()->json(["data" => $datos], status : 200);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "tarifa no encontrada"], status :  404 );
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status :  500);
        }
    }
    public function AddRange(Request $req) : JsonResponse
    {
        try{
            DB::transaction(function () use($req) : void{
                $jsonData = $req->collect();
                $data = json_decode($jsonData, true);
                    foreach($data as $key){
                        Tarifa::create(
                            [
                                "id_tipo_vehiculo" => $key["id_tipo_vehiculo"],
                                "tipo_tarifa" => $key["tipo_tarifa"],
                                "precio_base" => $key["precio_base"]
                            ]
                        );
                    }
            });
            return response()->json(["data" => true], status : 200);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], status : 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status: 500);
        }
    }
    public function Delete($id) : JsonResponse
    {
        try{
            Tarifa::findOrFail($id)->delete();
            return response()->json(status:204);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Tarifa no encontrada"], status: 404);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar Tarifa"], status: 500);
        }catch (Exception $e) {
            return response()->json(["error" => "Error desconocido"], status:  500);
        }
    }
    public function DeleteRange(Request $request) : JsonResponse
    {
        try{
            Tarifa::whereIn("id", $request->input("ids"))->delete();
            return response()->json(status : 204);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar Espacios"], status : 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status :  500);
        }
    }
    public function Update(Request $request, $id) : JsonResponse
    {
        try{
            DB::transaction(function () use($request,$id) : void{
                $datos = Tarifa::findOrFail($id);
                $datos->update($request->all());
            });
            return response()->json(status : 201);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Espacio no encontrado"], status: 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()],  status : 500);
        }
    }
}
