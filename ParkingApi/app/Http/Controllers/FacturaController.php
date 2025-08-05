<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Facturacion\MockProveedor;
use App\Services\Facturacion\ProveedorInterface;

class FacturaController extends Controller
{
    protected ProveedorInterface $proveedor;

    public function __construct(ProveedorInterface $proveedor)
    {
        $this->proveedor = $proveedor;
    }
    public function generar()
    {
        $datos = [
            'emisor' => [
                'nombre' => 'Mi Empresa S.A.S.',
                'nit' => '123456789',
                'direccion' => 'Cra 123 #45-67',
            ],
            'receptor' => [
                'nombre' => 'Cliente Ejemplo',
                'nit' => '987654321',
                'direccion' => 'Calle 8 #12-34',
            ],
            'items' => [
                [
                    'descripcion' => 'Lavado de auto',
                    'cantidad' => 1,
                    'precio_unitario' => 15000,
                    'total' => 15000,
                ],
            ],
            'total' => 15000,
            'fecha' => now()->toDateString(),
            'forma_pago' => 'EFECTIVO',
        ];

        $respuesta = $this->proveedor->enviarFactura($datos);

        return response()->json($respuesta);
    }
}
