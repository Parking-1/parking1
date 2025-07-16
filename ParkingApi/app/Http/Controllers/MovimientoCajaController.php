<?php

namespace App\Http\Controllers;

use App\Models\MovimientoCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class MovimientoCajaController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'tipo'   => 'required|in:ingreso,egreso',
            'monto'  => 'required|numeric|min:0',
            'motivo' => 'nullable|string',
        ]);

        $movimiento = MovimientoCaja::create([
            'tipo'   => $request->tipo,
            'monto'  => $request->monto,
            'motivo' => $request->motivo,
            'fecha'  => now()->toDateString(),
        ]);

        return response()->json(['data' => $movimiento], 201);
    }

    public function index(): JsonResponse
    {
        $movimientos = MovimientoCaja::orderBy('fecha', 'desc')->get();

        return response()->json(['data' => $movimientos]);
    }
}


