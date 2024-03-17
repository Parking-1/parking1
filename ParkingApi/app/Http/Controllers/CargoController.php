<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//modelos
use App\Models\Cargo;
//responses
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

//excepciones
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CargoController extends Controller
{
    public function Save(Request $request) : JsonResponse{
        try{
            Cargo::create($request->all());
            return response()->json(["data" => $request->all()], 201);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al crear el Cargo"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    public function GetPaginate() : JsonResponse
    {
        try{
            $datos = Cargo::paginate(15);
            return response()->json(["data" => $datos], 200);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    public function GetById($id) : JsonResponse {
        try{
            $datos = Cargo::findOrFail((int)$id);
            return response()->json(["data" => $datos], 200);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Cargo no encontrado"],  404 );
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
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
            return response()->json(["data" => true], 201);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    public function Delete($id) : JsonResponse
    {
        try{
            Cargo::findOrFail($id)->delete();
            return response()->json([ "status" => 204]);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Cargo no encontrado"], 404);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar Cargo"], 500);
        }catch (Exception $e) {
            return response()->json(["error" => "Error desconocido"], 500);
        }
    }
    public function DeleteRange(Request $request) : JsonResponse
    {
        try{
            Cargo::whereIn("id", $request->input("ids"))->delete();
            return response()->json(["status" => 204]);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar Cargos"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    public function Update(Request $request, $id) : JsonResponse
    {
        try{
            DB::transaction(function () use($request,$id){
                $datos = Cargo::findOrFail($id);
                $datos->update($request->all());
            });
            return response()->json(201);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Cargo no encontrado"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}
