<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Models\Ticket; // o el modelo que uses para el ticket
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function generarPDF($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId); // Ajusta según tu lógica
        $config = Configuracion::first(); // Configuración de la empresa

        $pdf = PDF::loadView('pdf.ticket', [
            'configuracion' => $config,
            'ticket' => $ticket,
            // puedes pasar otros datos aquí si lo necesitas
        ]);

        return $pdf->stream('ticket.pdf'); // o ->download('ticket.pdf')
    }
}

