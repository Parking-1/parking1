<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// modelos
use App\Models\User;
use App\Models\Vehiculo;
use App\Models\Tarifa;
use App\Models\Transaccion;
use App\Models\Espacio;

//responses
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

//excepciones
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;


class TransaccionController extends Controller
{
    private function GetDateDiff(array $fechas, string $tipo) : int{
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
    // Creacion de transaccion
    public function Save(Request $request) : JsonResponse{
        try{
            $vehiculo  = Vehiculo::where("placa", $request->placa)->first();
            $dato      = Tarifa::findOrFail($request["id_tarifa"]);
            //verifica si el vehiculo existe y si lo hace realiza una busqueda del tipo de tarifa para ver si coincide con el tipo de vehiculo
            if(isset($vehiculo)){
                $tipo_veh_vehiculo = $vehiculo->TipoVehiculo()->get()[0]->descripcion;
                if($tipo_veh_vehiculo != $dato->TipoVehiculo()->get()[0]->descripcion){
                    throw new Exception("No coincide");
                }
            }
            // una transaccion hacia la base de datos
            DB::transaction(function ()  use($request, $vehiculo, $dato) : void{
                $transaccion = new Transaccion();
                // si existe el vehiculo el request del id vendra siendo la id del vehiculo encontrado
                if(isset( $vehiculo) ){
                    $request["id_vehiculo"] = $vehiculo->id;
                    $tid = $vehiculo->id;
                }
                // sino se creara un nuevo vehiculo usando los datos pasados por body
                else{
                    // crea un nuevo vehiculo y lo guarda en la variable $t
                    $t = $transaccion->vehiculo()->create(
                    [
                        "placa" => $request->placa,
                        "id_tipo_vehiculo" => $request["id_tipo_vehiculo"],
                        "id_cliente" => $request["id_cliente"]
                    ]);
                    // asigna la id del vehiculo creado en la variable $tid
                    $tid = $t->id;
                    // asigna la id del vehiculo en el request
                    $request["id_vehiculo"] = $tid;
                }
                // verifica si existe la fecha de salida
                if(isset( $request["fecha_salida"] ) ){
                    // funcion que obtiene la diferencia entre dos fechas dependiendo del tipo de tarifa
                    $diff = $this->GetDateDiff([
                        "fecha_entrada" => $request["fecha_entrada"],
                        "fecha_salida" => $request["fecha_salida"],
                    ],
                    $dato["tipo_tarifa"]
            );
                    // calculo para sacar el precio total
                    $request["precio_total"] = ((float)$diff) * $dato["precio_base"];

                }
                // crea la transaccion
                $transaccion->create($request->all());
                // busca el vehiculo que se creo o que esta directamente relacionado con esta transaccion
                $vehiculo = Vehiculo::findOrFail($tid);
                // asigna un espacio para dicho vehiculo
                $idEspacio = Espacio::where("estado", "disponible")->first();
                if(!isset($request["fecha_salida"])){
                    $idEspacio->estado = "ocupado";
                    $idEspacio->save();
                }
                $vehiculo->espacio()->sync([$idEspacio->id]);
            });

            return response()->json(["data" => $request->all(), "status" => 201]);
        }catch(Exception $err){
            return response()->json(["error" => $err->getMessage(), "status" => 400]);
        }
    }
    public function GetPaginate() : JsonResponse
    {
        try{
            $datos = Transaccion::paginate(15);
            return response()->json(["data" => $datos] , status : 200);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], status: 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status:  500);
        }
    }
    public function GetById($id) : JsonResponse {
        try{
            $datos = Transaccion::findOrFail((int)$id);
            $this->authorize(ability:'view', arguments: $datos);
            return response()->json(["data" => $datos], status : 200);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Transaccion no encontrada"], status :  404 );
        }catch(AuthorizationException $e){
            return response()->json(["error" => "No autorizado para ver los datos"], status :  403 );
        }
        catch (Exception $e) {
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
                        Transaccion::create(
                            [
                                "id_tipo_vehiculo" => $key["id_tipo_vehiculo"],
                                "tipo_tarifa" => $key["tipo_tarifa"],
                                "precio_base" => $key["precio_base"]
                            ]
                        );
                    }
            });
            return response()->json(["data" => true], status : 201 );
        }catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], status : 500);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], status: 500);
        }
    }
    public function Delete($id) : JsonResponse
    {
        try{
            $trans = Transaccion::findOrFail($id);
            $this->authorize(ability:'delete', arguments:$trans);
            $trans
            ->delete();
            return response()->json(status : 204);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Transaccion no encontrada"], status :  404 );
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
            Transaccion::whereIn("id", $request->input("ids"))->delete();
            return response()->json(status : 204);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Transaccion no encontrada"], status: 404);
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar la transaccion"], status: 500);
        }catch (Exception $e) {
            return response()->json(["error" => "Error desconocido"], status:  500);
        }
    }
    public function Update(Request $request, $id) : JsonResponse
    {

        try{
            $datos = Transaccion::findOrFail($id);
            $this->authorize(ability:'Update', arguments:$datos);
            DB::transaction(function () use($request,$datos) : void{
                if(isset($datos["fecha_salida"])){
                    throw new Exception("Ya existe la fecha de salida");
                }
                $now =  Carbon::now();
                $diff = $this->GetDateDiff([
                    "fecha_entrada" => $datos["fecha_entrada"],
                    "fecha_salida" => $now,
                ],
                $datos->tarifa()->get()[0]["tipo_tarifa"]
        );
                $request["fecha_salida"] = $now;
                $request["precio_total"] = ((float)$diff) * $datos->tarifa()->get()[0]["precio_base"];
                $espacioId = $datos->vehiculo()->first()->espacio()->first()->id;
                $espacio = Espacio::findOrFail($espacioId);
                $espacio->estado = "disponible";
                $espacio->save();
                $datos->update($request->all());
            });
            return response()->json(status : 201);
        }catch (ModelNotFoundException $e) {
            return response()->json(["error" => "tipo de vehiculo no encontrado"], status: 404);
        }catch(AuthorizationException $e){
            return response()->json(["error" => "No autorizado para editar los datos"], status :  403 );
        }catch (QueryException $e) {
            return response()->json(["error" => "Error al editar la transaccion"], status: 500);
        }
        catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()],  status : 500);
        }
    }
    public function GetBetween(Request $request) : JsonResponse{
        try{
            $datos = DB::transaction(function () use ($request) : Collection{
                $trans = new Transaccion();
                return $trans
                ->whereBetween("fecha_entrada", [$request["fecha_entrada"], $request["fecha_salida"]])
                ->with("vehiculo")
                ->get();
            });
            return response()->json(["datos" => $datos], status : 200);

        }catch (QueryException $e) {
            return response()->json(["error" => "Error al consultar"], status: 500);
        }
        catch(Exception $err){
            return response()->json(["error" => $err->getMessage()], status : 500);
        }
    }
}
