<?php

namespace App\Services\Facturacion;

interface ProveedorInterface
{
    public function enviarFactura(array $datos): array;
}
