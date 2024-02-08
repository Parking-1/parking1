<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Support\Facades\DB;


class CargoController extends Controller
{
    public function Save(Request $request) : JsonResponse{
        try{
            Cargo::create($request->all());
            return response()->json(["data" => $request->all(), "status" => 201]);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }
    }
    public function GetPaginate() : JsonResponse
    {
        try{
            $datos = DB::transaction(function () {
                return Cargo::paginate(15);
            });
            return response()->json(["data" => $datos, "status" => 200]);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }
    }
    public function GetById($id) : JsonResponse {
        try{
            $datos = Cargo::findOrFail((int)$id);
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
                        Cargo::create(
                            [
                                "nombre" => $key["nombre"],
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
            Cargo::findOrFail($id)->delete();
            return response()->json([ "status" => 204]);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }
    }
    public function DeleteRange(Request $request) : JsonResponse
    {
        try{
            Cargo::whereIn("id", $request->input("ids"))->delete();
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
                $datos = Cargo::findOrFail($id);
                $datos->update($request->all());
            });
            return response()->json(["status" => 200]);
        }catch(Exception $err){
            return response()->json([
                "error" => $err->getMessage(),
                "status" => 400  ]);
        }
    }
}
