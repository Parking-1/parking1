<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//modelos
use App\Models\Cliente;
//responses
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
//excepciones
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class ClienteController extends Controller
{
    public function Save(Request $request) : JsonResponse{
        try{
            Cliente::create($request->all());
            return response()->json(["data" => $request->all()], 201);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al crear el cliente"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    public function GetPaginate() : JsonResponse
    {
        try{
            $datos = Cliente::select("nombre", "apellido")->paginate(15);
            return response()->json(["data" => $datos], 200);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()],500);
        }
    }
    public function GetById($id) : JsonResponse {
        try{
            $datos = Cliente::select("nombre")->findOrFail((int)$id);
            return response()->json(["data" => $datos, "status" => 200]);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Cliente no encontrado"],404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    public function AddRange(Request $req) : JsonResponse
    {
        try{
            DB::transaction(function () use($req) : void {
                $jsonData = $req->collect();
                $data = json_decode($jsonData, true);
                    foreach($data as $key){
                        Cliente::create(
                            [
                                "nombre" => $key["nombre"],
                                "apellido" => $key["apellido"],
                                "cedula" => $key["cedula"],
                                "telefono" => $key["telefono"]
                            ]
                        );
                    }
            });
            return response()->json(["data" => $data], 201);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    public function Delete($id) : JsonResponse
    {
        try{
            Cliente::findOrFail($id)->delete();
            return response()->json([ "status" => 204]);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Cliente no encontrado"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => "Error desconocido"], 500);
        }
    }
    public function DeleteRange(Request $request) : JsonResponse
    {
        try{
            Cliente::whereIn("id", $request->input("ids"))->delete();
            return response()->json(["status" => 204]);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar clientes"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    public function Update(Request $request, $id) : JsonResponse
    {
        try{
            DB::transaction(function () use($request,$id) : void{
                $datos = Cliente::findOrFail($id);
                $datos->update($request->all());
            });
            return response()->json(["status" => 200]);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Cliente no encontrado"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    public function GetWithVehiculo() : JsonResponse{
        try{
            $vehiculo = new Cliente();
            $datos = $vehiculo->with("vehiculo")->get();
            return response()->json(["datos" => $datos], 200);
        }catch(QueryException $e){
            return response()->json(["error" => "Error de consulta"], 500);
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }

    }
}
