<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Support\Facades\DB;

class VehiculoController extends Controller
{
    public function Save(Request $request) : JsonResponse{
        try{
            Vehiculo::create($request->all());
            return response()->json(["data" => $request->all(), "status" => 201]);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }
    }
    public function GetPaginate() : JsonResponse
    {
        try{
            $datos = DB::transaction(function () {
                return Vehiculo::paginate(15);
            });
            return response()->json(["data" => $datos, "status" => 200]);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }
    }
    public function GetById($id) : JsonResponse {
        try{
            $datos = Vehiculo::findOrFail((int)$id);
            return response()->json(["data" => $datos, "status" => 200]);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }
    }
    public function AddRange(Request $req) : JsonResponse
    {
        try{
            DB::transaction(function () use($req) : void{
                $jsonData = $req->collect();
                $data = json_decode($jsonData, true);
                    foreach($data as $key){
                        Vehiculo::create(
                            [
                                "placa" => $key["placa"],
                                "id_tipo_vehiculo" => $key["id_tipo_vehiculo"],
                                "id_cliente" => $key["id_cliente"]
                            ]
                        );
                    }
            });
            return response()->json(["data" => true, "status" => 201]);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }
    }
    public function Delete($id) : JsonResponse
    {
        try{
            Vehiculo::findOrFail($id)->delete();
            return response()->json([ "status" => 204]);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }
    }
    public function DeleteRange(Request $request) : JsonResponse
    {
        try{
            Vehiculo::whereIn("id", $request->input("ids"))->delete();
            return response()->json(["status" => 204]);
        }catch(Exception $err){
            return response()->json([
                "error" => $err->getMessage(),
                "status" => 400  ]);
        }
    }
    public function Update(Request $request, $id) : JsonResponse
    {
        try{
            DB::transaction(function () use($request,$id){
                $datos = Vehiculo::findOrFail($id);
                $datos->update($request->all());
            });
            return response()->json(["status" => 200]);
        }catch(Exception $err){
            return response()->json([
                "error" => $err->getMessage(),
                "status" => 400  ]);
        }
    }
    public function GetWithCliente() : JsonResponse{
        $vehiculo = new Vehiculo();
        $datos = $vehiculo->with("cliente")->get();
        return response()->json(["datos" => $datos, "status" => 200]);
    }
    public function GetGroupVehiculos() : JsonResponse{
        try{
            $vehiculos = new Vehiculo();
            $vehiculos = $vehiculos
            ->join("tipo_vehiculo", "vehiculo.id_tipo_vehiculo","=", "tipo_vehiculo.id")
            ->join("espacio_vehiculo", "espacio_vehiculo.vehiculo_id", "=", "vehiculo.id")
            ->join("espacio", "espacio_vehiculo.espacio_id", "=", "espacio.id")
            ->select(DB::raw("tipo_vehiculo.descripcion ,count(*) as total"))
            ->where("espacio.estado", "disponible")
            ->groupBy("tipo_vehiculo.descripcion")
            ->get();

            return response()->json(["datos" => $vehiculos, "status" => 200]);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }
    }
}