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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Configuracion;

class TransaccionController extends Controller
{
    public function Save(Request $request): JsonResponse
    {

        try {
            $vehiculo = Vehiculo::firstOrCreate(
            ['placa' => strtoupper($request->placa)],
            ['id_tipo_vehiculo' => $request->id_tipo_vehiculo]
        );

        // Validar tipo de vehículo existente si ya está registrado
        if ($vehiculo->wasRecentlyCreated === false && $vehiculo->id_tipo_vehiculo !== $request->id_tipo_vehiculo) {
            return response()->json([
                "error" => "Ya existe un vehículo con esta placa y con un tipo diferente."
            ], 400);
        }

        $this->authorize('create', Transaccion::class);

            $espacio = Espacio::where('estado', 'disponible')->first();
            if (!$espacio) {
                throw new Exception("No hay espacios disponibles.");
            }

            $tarifa = $vehiculo->tipoVehiculo->tarifa->first();
            if (!$tarifa) {
                throw new Exception("No hay tarifa definida para el tipo de vehículo.");
            }

            DB::beginTransaction();

            $espacio->update(['estado' => 'ocupado']);

            $transaccion = Transaccion::create([
                'id_vehiculo'   => $vehiculo->id,
                'id_tarifa'     => $tarifa->id,
                'id_espacio'    => $espacio->id,
                'fecha_entrada' => now(),
                'lavado'        => $request->lavado ?? false,
            ]);

             // 🔸 Cargar configuración de empresa
            $config = \App\Models\Configuracion::first();
            DB::commit();

            $transaccion->load('vehiculo.tipoVehiculo');
            // 🔸 Generar PDF del ticket
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.ticket', [
            'configuracion' => $config,
            'ticket' => $transaccion,
            ]);

            // 🔸 Guardar el archivo en storage/app/public/tickets
            $nombreArchivo = 'ticket_' . $transaccion->id . '.pdf';
            \Illuminate\Support\Facades\Storage::put('public/tickets/' . $nombreArchivo, $pdf->output());

            DB::commit();

            return response()->json(["data" => $transaccion,"ticket_url" => asset('storage/tickets/' . $nombreArchivo)], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Vehículo no encontrado"], 404);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(["error" => $e->getMessage()], 500);
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

    public function GetByPlaca(string $placa): JsonResponse
    {
        try {
            //$placa = strtoupper($request->query('placa'));

            $trans = Transaccion::with(['vehiculo.tipoVehiculo', 'tarifa', 'espacio'])
                ->whereNull('fecha_salida')
                ->whereHas('vehiculo', function ($q) use ($placa) {
                    $q->whereRaw('UPPER(placa) = ?', [strtoupper($placa)]);
                })
                ->firstOrFail();

            return response()->json(['data' => $trans], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Transacción no encontrada"], 404);
        } catch (\Exception $e) {
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

            DB::beginTransaction();
            $transaccion->update($request->all());
            DB::commit();

            return response()->json(["message" => "Transacción actualizada correctamente"], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(["error" => "Transacción no encontrada"], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function CerrarTransaccion(Request $request, $id): JsonResponse
{
    try {
        $transaccion = Transaccion::with([
            'vehiculo.tipoVehiculo.tarifa',
            'espacio',
            'tarifa' // <- solo si existe esta relación
        ])->findOrFail($id);

        $this->authorize('update', $transaccion);

        $lavado = filter_var($request->input('lavado', false), FILTER_VALIDATE_BOOLEAN);

        DB::transaction(function () use ($transaccion, $lavado) {
            $entrada = Carbon::parse($transaccion->fecha_entrada);
            $salida = now();
            $tarifa = $transaccion->tarifa; // usa el nombre correcto de la relación

            $monto = $this->calcularPrecio($entrada, $salida, $tarifa, $lavado);

            $transaccion->update([
                'fecha_salida' => $salida,
                'precio_total' => $monto,
                'lavado'       => $lavado,
            ]);

            $transaccion->espacio->update(['estado' => 'disponible']);
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

    /**
     * Método auxiliar para calcular el precio de una transacción
     */
    private function calcularPrecio(Carbon $entrada, Carbon $salida, $tarifa, bool $lavado = false): float
    {
        $monto = 0;

        switch ($tarifa->tipo_tarifa) {
            case 'hora':
                $horas = max(1, $entrada->diffInHours($salida));
                $monto = $horas * $tarifa->precio_base;
                break;
            case 'dia':
                $dias = max(1, $entrada->diffInDays($salida));
                $monto = $dias * $tarifa->precio_base;
                break;
            case 'mes':
                $meses = max(1, $entrada->diffInMonths($salida));
                $monto = $meses * $tarifa->precio_base;
                break;
        }

        if ($lavado && isset($tarifa->precio_lavado)) {
            $monto += $tarifa->precio_lavado;
        }

        return $monto;
    }

public function registrarSalida($id)
{
    try {
        $transaccion = Transaccion::with(['vehiculo.tipoVehiculo', 'espacio', 'cliente', 'tarifa'])->findOrFail($id);

        // Calcular tiempo y monto
        $salida = now();
        $entrada = $transaccion->fecha_entrada;

        $tarifa = $transaccion->tarifa; // Asegúrate de tener esta relación
        $lavado = $transaccion->lavado ?? false;

        $monto = $this->calcularPrecio($entrada, $salida, $tarifa, $lavado);

        $transaccion->update([
            'fecha_salida' => $salida,
            'precio_total' => $monto,
        ]);

        $transaccion->espacio->update(['estado' => 'disponible']);

        // Solo generar PDF si hay monto a cobrar
        if ($monto > 0) {
            $configuracion = Configuracion::first();

            $pdf = Pdf::loadView('pdf.ticket_cobro', [
                'transaccion'   => $transaccion,
                'configuracion' => $configuracion,
            ])->setPaper([0, 0, 165, 440], 'portrait'); // 58mm térmico

            $filename = 'cobro_' . $transaccion->id . '_' . now()->format('Ymd_His') . '.pdf';
            $path = 'tickets/' . $filename;

            Storage::disk('public')->put($path, $pdf->output());

            $transaccion->update(['ruta_pdf' => $path]);
        }

        return response()->json([
            'message' => 'Salida registrada correctamente',
            'ruta_pdf' => $transaccion->ruta_pdf ? asset('storage/' . $transaccion->ruta_pdf) : null
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
