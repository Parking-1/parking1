<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaccion;
use App\Models\Vehiculo;
use App\Models\Tarifa;


use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class TransaccionController extends Controller
{
    public function Save(Request $request) : JsonResponse{
        try{
            DB::transaction(function ()  use($request){
                $vehiculo  = Vehiculo::where("placa", $request->placa)->first();
                $transaccion = new Transaccion();
                if(isset( $vehiculo) ){
                    $request["id_vehiculo"] = $vehiculo->id;
                }else{
                    $transaccion->vehiculo()->create(
                    [
                        "placa" => $request->placa,
                        "id_tipo_vehiculo" => $request["id_tipo_vehiculo"],
                        "id_cliente" => $request["id_cliente"]
                    ]);
                    $request["id_vehiculo"] = $transaccion->vehiculo()->get()->id;
                }
                if(isset( $request["fecha_salida"] ) ){
                    $dato = Tarifa::findOrFail($request["id_tarifa"]);
                    $fecha_entrada = Carbon::parse($request["fecha_entrada"]);
                    $fecha_salida = Carbon::parse($request["fecha_salida"]);
                    if($dato["tipo_tarifa"] == "hora"){
                        $diff = $fecha_entrada->diffInHours($fecha_salida);
                    }else if($dato["tipo_tarifa"] == "diario"){
                        $diff = $fecha_entrada->diff($fecha_salida);
                        $diff = $diff->days;
                    }else{
                        $diff = $fecha_entrada->diffInMonths($fecha_salida);
                    }
                    $request["precio_total"] = ((float)$diff) * $dato["precio_base"];
                }
                $transaccion->create($request->all());
            });

            return response()->json(["data" => $request->all(), "status" => 201]);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }
    }
    public function GetPaginate() : JsonResponse
    {
        try{
            $datos = DB::transaction(function () {
                return Transaccion::paginate(15);
            });
            return response()->json(["data" => $datos, "status" => 200]);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }
    }
    public function GetById($id) : JsonResponse {
        try{
            $datos = Transaccion::findOrFail((int)$id);
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
                        Transaccion::create(
                            [
                                "id_tipo_vehiculo" => $key["id_tipo_vehiculo"],
                                "tipo_tarifa" => $key["tipo_tarifa"],
                                "precio_base" => $key["precio_base"]
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
            Transaccion::findOrFail($id)->delete();
            return response()->json([ "status" => 204]);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }
    }
    public function DeleteRange(Request $request) : JsonResponse
    {
        try{
            Transaccion::whereIn("id", $request->input("ids"))->delete();
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
                $datos = Transaccion::findOrFail($id);
                $datos->update($request->all());
            });
            return response()->json(["status" => 200]);
        }catch(Exception $err){
            return response()->json([
                "error" => $err->getMessage(),
                "status" => 400  ]);
        }
    }
    public function GetBeetween(Request $request) : JsonResponse{

    }
}
