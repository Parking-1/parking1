<?php

namespace App\Services\Facturacion;

class MockProveedor implements ProveedorInterface
{
    public function enviarFactura(array $datos): array
    {
        // Extraer los datos necesarios
        $emisor = $datos['emisor'];
        $receptor = $datos['receptor'];
        $items = $datos['items'];
        $total = $datos['total'];
        $fecha = $datos['fecha'];
        $forma_pago = $datos['forma_pago'];

        // Generar XML usando la vista
        $xml = view('facturas.xml', compact('emisor', 'receptor', 'items', 'total', 'fecha', 'forma_pago'))->render();

        // Simular respuesta
        return [
            'estado' => 'exitoso',
            'cufe' => strtoupper(uniqid('CUFE-')),
            'xml' => $xml,
            'fecha_validacion' => now()->toDateTimeString()
        ];
    }
}
