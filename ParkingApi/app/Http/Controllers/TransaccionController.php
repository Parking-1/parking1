<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

use App\Models\Transaccion;
use App\Models\Espacio;
use App\Models\Vehiculo;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransaccionController extends Controller
{
    public function Save(Request $request): JsonResponse
    {
        try {
            $vehiculo = Vehiculo::findOrFail($request->id_vehiculo);
            $this->authorize('create', Transaccion::class);

            $espacio = Espacio::where('estado', 'disponible')->first();
            if (!$espacio) {
                throw new Exception("No hay espacios disponibles.");
            }

            $tarifa = $vehiculo->TipoVehiculo->Tarifa->first(); // asume relación hasMany
            if (!$tarifa) {
                throw new Exception("No hay tarifa definida para el tipo de vehículo.");
            }

            DB::beginTransaction();

            $espacio->update(['estado' => 'ocupado']);

            $transaccion = Transaccion::create([
                'id_vehiculo' => $vehiculo->id,
                'id_tarifa'   => $tarifa->id,
                'id_espacio'  => $espacio->id,
                'fecha_entrada' => now()
            ]);

            DB::commit();

            return response()->json(["data" => $transaccion], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Vehículo no encontrado"], 404);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(["error" => "Error de base de datos"], 500);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function GetPaginate(): JsonResponse
    {
        try {
            $data = Transaccion::with(['Vehiculo.TipoVehiculo', 'Tarifa', 'Espacio'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);

            return response()->json(["data" => $data], 200);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error de consulta"], 500);
        }
    }

    public function GetById($id): JsonResponse
    {
        try {
            $transaccion = Transaccion::with(['Vehiculo.TipoVehiculo', 'Tarifa', 'Espacio'])->findOrFail($id);
            $this->authorize('view', $transaccion);
            return response()->json(["data" => $transaccion], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Transacción no encontrada"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function Delete($id): JsonResponse
    {
        try {
            $transaccion = Transaccion::findOrFail($id);
            $this->authorize('delete', $transaccion);
            $transaccion->delete();
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Transacción no encontrada"], 404);
        } catch (QueryException $e) {
            return response()->json(["error" => "Error al eliminar transacción"], 500);
        }
    }

    public function DeleteRange(Request $request): JsonResponse
    {
        try {
            foreach ($request->input("ids", []) as $id) {
                $trans = Transaccion::findOrFail($id);
                $this->authorize('delete', $trans);
                $trans->delete();
            }
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Una o más transacciones no encontradas"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function Update(Request $request, $id): JsonResponse
    {
        try {
            $transaccion = Transaccion::findOrFail($id);
            $this->authorize('update', $transaccion);

            DB::transaction(function () use ($transaccion, $request) {
                $transaccion->update($request->all());
            });

            return response()->json(["message" => "Transacción actualizada correctamente"], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Transacción no encontrada"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function CerrarTransaccion($id): JsonResponse
    {
        try {
            $transaccion = Transaccion::with(['Vehiculo.TipoVehiculo.Tarifa', 'Espacio'])->findOrFail($id);
            $this->authorize('update', $transaccion);

            DB::transaction(function () use ($transaccion) {
                $entrada = Carbon::parse($transaccion->fecha_entrada);
                $salida = now();
                $transaccion->fecha_salida = $salida;

                $tarifa = $transaccion->Tarifa;
                $monto = 0;

                switch ($tarifa->tipo_tarifa) {
                    case 'hora':
                        $horas = $entrada->diffInHours($salida);
                        $monto = $horas * $tarifa->precio_base;
                        break;
                    case 'dia':
                        $dias = $entrada->diffInDays($salida);
                        $monto = $dias * $tarifa->precio_base;
                        break;
                    case 'mes':
                        $meses = $entrada->diffInMonths($salida);
                        $monto = $meses * $tarifa->precio_base;
                        break;
                }

                $transaccion->precio_total = $monto;
                $transaccion->save();

                $transaccion->Espacio->update(['estado' => 'disponible']);
            });

            return response()->json(["message" => "Transacción cerrada correctamente"], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Transacción no encontrada"], 404);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function GetBetween(Request $request): JsonResponse
    {
        try {
            $inicio = Carbon::parse($request->input('inicio'));
            $fin = Carbon::parse($request->input('fin'));

            $transacciones = Transaccion::whereBetween('fecha_entrada', [$inicio, $fin])
                ->with(['Vehiculo.TipoVehiculo', 'Tarifa', 'Espacio'])
                ->get();

            return response()->json(["data" => $transacciones], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}

