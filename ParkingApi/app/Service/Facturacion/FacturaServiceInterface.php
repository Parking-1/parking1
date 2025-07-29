<?php

namespace App\Services\Facturacion;

interface FacturaServiceInterface
{
    public function generar(array $datos): string;
}
