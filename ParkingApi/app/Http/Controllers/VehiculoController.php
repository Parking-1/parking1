<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use Illuminate\Http\JsonResponse;
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
}
