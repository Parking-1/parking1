<?php

namespace App\Services\Facturacion;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenericFacturaService implements FacturaServiceInterface
{
    public function generar(array $datos): string
    {
        $nombreArchivo = 'facturas/' . now()->format('Ymd_His') . '_' . Str::random(6) . '.xml';

        $xml = view('facturas.xml', $datos)->render();

        Storage::disk('local')->put($nombreArchivo, $xml);

        return $nombreArchivo;
    }
}
