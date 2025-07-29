<?php

namespace App\Services\Facturacion;

use App\Models\Configuracion;

class FacturaService
{
    public function enviar(array $datosFactura): array
    {
        $config = Configuracion::first();

        if (!$config || !$config->facturacion_electronica_activa) {
            return ['estado' => 'omitida', 'mensaje' => 'Facturación electrónica desactivada'];
        }

        // Determinar el proveedor
        switch ($config->proveedor_factura) {
            case 'mock':
                $proveedor = new MockProveedor();
                break;
            // Puedes añadir más casos con otros proveedores reales
            default:
                return ['estado' => 'error', 'mensaje' => 'Proveedor no definido'];
        }

        return $proveedor->enviarFactura($datosFactura);
    }
}
