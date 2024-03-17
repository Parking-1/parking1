<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Interface\IPdf;

//responses
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

//excepciones
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;

class VehiculoController extends Controller
{
    public function Save(Request $request) : JsonResponse{
        try{
            Vehiculo::create($request->all());
            return response()->json(["data" => $request->all(), "status" => 201]);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al crear el Vehiculo"], 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    public function GetPaginate() : JsonResponse
    {
        try{

            $datos =  Vehiculo::paginate(15);
            $this->authorize(ability:'view', arguments:$datos[0]);
            return response()->json(["data" => $datos, "status" => 200]);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], status: 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status:  500);
        }
    }
    public function GetById($id) : JsonResponse {
        try{
            $datos = Vehiculo::findOrFail((int)$id);
            $this->authorize(ability:'view', arguments:$datos);
            return response()->json(["data" => $datos], status : 200);
        }
        catch(AuthorizationException $e){
            return response()->json(["error" => "No autorizado para ver los datos"], status :  403 );
        }
        catch (ModelNotFoundException $e) {
            return response()->json(["error" => "vehiculo no encontrada"], status :  404 );
        }
        catch(QueryException $err){
            return response()->json(["error" => "Error en la consulta"], status : 500);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage()], status : 500);
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
            return response()->json(["data" => true], status : 201);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], status : 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status: 500);
        }
    }
    public function Delete($id) : JsonResponse
    {
        try{
            $vehiculo = Vehiculo::findOrFail($id);
            $this->authorize(ability:'delete', arguments: $vehiculo);
            $vehiculo
            ->delete();
            return response()->json(status : 204);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Vehiculo no encontrada"], status :  404 );
        }
        catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], status : 500);
        }
        catch(AuthorizationException $e){
            return response()->json(["error" => "No autorizado para borrar los datos"], status :  403 );
        }
        catch(Exception $err){
            return response()->json(["error" => $err->getMessage()], status : 500);
        }
    }
    public function DeleteRange(Request $request) : JsonResponse
    {
        try{
            Vehiculo::whereIn("id", $request->input("ids"))->delete();
            return response()->json(status : 204);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Transaccion no encontrada"], status: 404);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar el vehiculo"], status: 500);
        }catch (Exception $e) {
            return response()->json(["error" => "Error desconocido"], status:  500);
        }
    }
    public function Update(Request $request, $id) : JsonResponse
    {
        try{
            DB::transaction(function () use($request,$id){
                $datos = Vehiculo::findOrFail($id);
                $this->authorize(ability:'update', arguments: $datos);
                $datos->update($request->all());
            });
            return response()->json(status : 201);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => " vehiculo no encontrado"], status: 404);
        }catch(AuthorizationException $e){
            return response()->json(["error" => "No autorizado para editar los datos"], status :  403 );
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al editar la transaccion"], status: 500);
        }
        catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()],  status : 500);
        }
    }
    public function GetWithCliente() : JsonResponse{
        try{
             $vehiculo = new Vehiculo();
            $datos = $vehiculo->with("cliente")->get();
            return response()->json(["datos" => $datos, "status" => 200]);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al consultar"], status: 500);
        }
        catch(Exception $err){
            return response()->json(["error" => $err->getMessage()], status : 500);
        }

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
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al consultar"], status: 500);
        }
        catch(Exception $err){
            return response()->json(["error" => $err->getMessage()], status : 500);
        }
    }
    public function GetReport(IPdf $pdf) {
        $data = Vehiculo::with("TipoVehiculo")->get();
        $pdf->body($data->toArray(), "vehiculo") ;
    }
}
