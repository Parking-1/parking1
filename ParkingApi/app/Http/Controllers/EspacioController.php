<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

// Modelos
use App\Models\Espacio;
//responses
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

//excepciones
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EspacioController extends Controller
{
    public function Save(Request $request) : JsonResponse{
        try{
            Espacio::create($request->all());
            return response()->json(["data" => $request->all()], status : 201);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al crear el Espacio"], status :  500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status: 500);
        }
    }
    public function GetPaginate() : JsonResponse
    {
        try{
            $datos =  Espacio::paginate(15);
            return response()->json(["data" => $datos], status: 200);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], status: 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status:  500);
        }
    }
    public function GetById($id) : JsonResponse {
        try{
            $datos = Espacio::findOrFail((int)$id);
            return response()->json(["data" => $datos], status:  200);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Espacio no encontrado"], status :  404 );
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
                        Espacio::create(
                            [
                                "descripcion" => $key["descripcion"],
                            ]
                        );
                    }
            });
            return response()->json(["data" => true], status:  201);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], status : 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status: 500);
        }
    }
    public function Delete($id) : JsonResponse
    {
        try{
            Espacio::findOrFail($id)->delete();
            return response()->json(status:204);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Espacio no encontrado"], status: 404);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar Espacio"], status: 500);
        }catch (Exception $e) {
            return response()->json(["error" => "Error desconocido"], status:  500);
        }
    }
    public function DeleteRange(Request $request) : JsonResponse
    {
        try{
            Espacio::whereIn("id", $request->input("ids"))->delete();
            return response()->json(["status" => 204]);
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
                $datos = Espacio::findOrFail($id);
                $datos->update($request->all());
            });
            return response()->json(["status" => 200]);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Espacio no encontrado"], status: 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    public function GetEspacesBy($estado) : JsonResponse{
        try{
            $datos = DB::transaction(function () use ($estado) : Collection {
                return Espacio::where("estado", $estado)->get();
            });
            return response()->json(["datos" => $datos], status : 200);
        }catch(QueryException $err){
            return response()->json(["error" => "Error en la consulta"], status : 500);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage()], status : 500);
        }
    }
}
