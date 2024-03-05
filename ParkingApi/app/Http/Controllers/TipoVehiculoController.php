<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Modelo

use App\Models\TipoVehiculo;
//responses
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

//excepciones
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class TipoVehiculoController extends Controller
{
    public function Save(Request $request) : JsonResponse{
        try{
            TipoVehiculo::create($request->all());
            return response()->json(["data" => $request->all()], status : 201);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al crear la Tipo De Vehiculo"], status :  500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status: 500);
        }
    }
    public function GetPaginate() : JsonResponse
    {
        try{
            $datos = TipoVehiculo::paginate(15);
            return response()->json(["data" => $datos], status : 200);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], status: 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status:  500);
        }
    }
    public function GetById($id) : JsonResponse {
        try{
            $datos = TipoVehiculo::findOrFail((int)$id);
            return response()->json(["data" => $datos], status : 200);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Tipo de vehiculo no encontrada"], status :  404 );
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
                        TipoVehiculo::create(
                            [
                                "descripcion" => $key["descripcion"],
                            ]
                        );
                    }
            });
            return response()->json(status : 204);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], status : 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status: 500);
        }
    }
    public function Delete($id) : JsonResponse
    {
        try{
            TipoVehiculo::findOrFail($id)->delete();
            return response()->json(status : 204);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "tipo de vehiculo no encontrada"], status: 404);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar el tipo de vehiculo"], status: 500);
        }catch (Exception $e) {
            return response()->json(["error" => "Error desconocido"], status:  500);
        }
    }
    public function DeleteRange(Request $request) : JsonResponse
    {
        try{
            TipoVehiculo::whereIn("id", $request->input("ids"))->delete();
            return response()->json(status : 204);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar los tipos de vehiculos"], status : 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status :  500);
        }
    }
    public function Update(Request $request, $id) : JsonResponse
    {
        try{
            DB::transaction(function () use($request,$id) : void{
                $datos = TipoVehiculo::findOrFail($id);
                $datos->update($request->all());
            });
            return response()->json(status : 201);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "tipo de vehiculo no encontrado"], status: 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()],  status : 500);
        }
    }
}
