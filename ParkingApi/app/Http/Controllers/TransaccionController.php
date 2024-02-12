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
    private function GetDateDiff(array $fechas, string $tipo){
        $fecha_entrada = Carbon::parse($fechas["fecha_entrada"]);
        $fecha_salida = Carbon::parse($fechas["fecha_salida"]);
        if($tipo == "hora"){
            $diff = $fecha_entrada->diffInHours($fecha_salida);
        }else if($tipo == "diario"){
            $diff = $fecha_entrada->diff($fecha_salida);
            $diff = $diff->days;
        }else{
            $diff = $fecha_entrada->diffInMonths($fecha_salida);
        }
        return $diff;
    }
    public function Save(Request $request) : JsonResponse{
        try{
            $vehiculo  = Vehiculo::where("placa", $request->placa)->first();
            $dato      = Tarifa::findOrFail($request["id_tarifa"]);
            $tipo_veh_vehiculo = $vehiculo->TipoVehiculo()->get()[0]->descripcion;
            if($tipo_veh_vehiculo != $dato->TipoVehiculo()->get()[0]->descripcion){
                throw new Exception("No coincide");
            }
            DB::transaction(function ()  use($request, $vehiculo, $dato){
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

                    $diff = $this->GetDateDiff([
                        "fecha_entrada" => $request["fecha_entrada"],
                        "fecha_salida" => $request["fecha_salida"],
                    ],
                    $dato["tipo_tarifa"]
            );
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
                if(isset($datos["fecha_salida"])){
                    throw new Exception("Ya existe la fecha de salida");
                }
                $now =  Carbon::now();
                $diff = $this->GetDateDiff([
                    "fecha_entrada" => $datos["fecha_entrada"],
                    "fecha_salida" => $now,
                ],
                $datos["tipo_tarifa"]
        );
                $request["fecha_salida"] = $now;
                $request["precio_total"] = ((float)$diff) * $datos->tarifa()->get()[0]["precio_base"];
                $datos->update($request->all());
            });
            return response()->json(["status" => 200]);
        }catch(Exception $err){
            return response()->json([
                "error" => $err->getMessage(),
                "status" => 400  ]);
        }
    }
    public function GetBetween(Request $request) : JsonResponse{
        try{
            $datos = DB::transaction(function () use ($request) {
                $trans = new Transaccion();
                return $trans
                ->whereBetween("fecha_entrada", [$request["fecha_entrada"], $request["fecha_salida"]])
                ->with("vehiculo")
                ->get();
            });
            return response()->json(["datos" => $datos, "status" => 200]);

        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }
    }
}
