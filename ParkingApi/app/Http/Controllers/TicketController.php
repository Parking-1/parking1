<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Models\Ticket;
use App\Services\Facturacion\FacturaService;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    /**
     * Generar PDF simple del ticket (sin facturación electrónica).
     */
    public function generarPDF($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $config = Configuracion::first();

        $pdf = PDF::loadView('pdf.ticket', [
            'configuracion' => $config,
            'ticket' => $ticket,
        ]);

        return $pdf->stream("ticket_{$ticket->id}.pdf");
    }

    /**
     * Generar PDF y facturación electrónica (opcional según configuración).
     */
    public function generarFacturaPDF($ticketId)
    {
        $ticket = Ticket::with('cliente')->findOrFail($ticketId);

        // 1. Preparar datos para el servicio
        $datosFactura = [
            'cliente' => [
                'nombre' => optional($ticket->cliente)->nombre ?? 'Consumidor final',
                'documento' => optional($ticket->cliente)->documento ?? '0000000000',
            ],
            'empresa' => [
                'nombre' => config('empresa.nombre'),
                'nit' => config('empresa.nit'),
            ],
            'items' => [
                ['descripcion' => 'Parqueo', 'valor' => $ticket->total],
            ],
            'fecha' => now(),
            'ticket_id' => $ticket->id,
        ];

        // 2. Verificar si está habilitada la facturación electrónica
        $facturaActiva = config('facturacion.activa', false);
        $respuesta = null;

        if ($facturaActiva) {
            $facturaService = new FacturaService();
            $respuesta = $facturaService->enviar($datosFactura);

            if ($respuesta['estado'] === 'aceptado') {
                $ticket->cufe = $respuesta['cufe'];
                $ticket->fecha_validacion = $respuesta['fecha_validacion'];
                $ticket->save();
            }
        }

        // 3. Generar PDF con o sin datos de facturación
        return view('pdf.ticket_cobro', [
            'ticket' => $ticket,
            'respuesta' => $respuesta,
        ]);
    }
}
