<?php

namespace App\Services\Facturacion;

use App\Helpers\FirmaXmlHelper;
use App\Helpers\GeneradorXmlHelper;
use Illuminate\Support\Facades\Log;

class MockProveedor implements ProveedorInterface
{
    public function enviarFactura(array $datos): array
    {
        try {
            // Validar existencia mínima de datos
            if (!isset($datos['emisor'], $datos['receptor'], $datos['items'], $datos['total'], $datos['fecha'], $datos['forma_pago'])) {
                throw new \Exception('Faltan datos requeridos para generar la factura.');
            }

            // Extraer datos
            $emisor = $datos['emisor'];
            $receptor = $datos['receptor'];
            $items = $datos['items'];
            $total = $datos['total'];
            $fecha = $datos['fecha'];
            $forma_pago = $datos['forma_pago'];

            // Generar XML sin firmar
            $xmlSinFirmar = GeneradorXmlHelper::generarXmlFactura($emisor, $receptor, $items, $total, $fecha, $forma_pago);

            // Firmar el XML
            $xmlFirmado = FirmaXmlHelper::firmarXml($xmlSinFirmar);

            // Simular respuesta de proveedor
            return [
                'estado' => 'exitoso',
                'cufe' => strtoupper(uniqid('CUFE-')),
                'xml' => $xmlFirmado,
                'fecha_validacion' => now()->toDateTimeString()
            ];
        } catch (\Throwable $e) {
            Log::error('Error al enviar factura con MockProveedor: ' . $e->getMessage());

            return [
                'estado' => 'fallido',
                'error' => $e->getMessage(),
            ];
        }
    }
}


