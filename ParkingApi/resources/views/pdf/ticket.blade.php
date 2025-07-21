<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Ingreso</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; text-align: center; }
        .line { border-top: 1px dashed #000; margin: 6px 0; }
        .title { font-size: 14px; font-weight: bold; margin-bottom: 4px; }
        .footer { font-size: 9px; margin-top: 6px; }
    </style>
</head>
<body>
    <div class="title">{{ strtoupper($configuracion->nombre_empresa ?? 'EMPRESA') }}</div>
    <p>{{ $configuracion->direccion ?? '' }}</p>
    <p>NIT: {{ $configuracion->nit ?? '' }}</p>
    <p>Tel: {{ $configuracion->telefono ?? '' }}</p>

    <div class="line"></div>

    <p><strong>Fecha de Entrada:</strong> {{ $ticket->fecha_entrada?->format('d/m/Y') ?? 'N/A' }}</p>
    <p><strong>Hora de Entrada:</strong> {{ $ticket->fecha_entrada?->format('H:i') ?? 'N/A' }}</p>
    <p><strong>Placa:</strong> {{ strtoupper($ticket->vehiculo->placa ?? 'N/A') }}</p>
    <p><strong>Tipo de Vehículo:</strong> {{ ucfirst($ticket->vehiculo->tipoVehiculo->descripcion ?? 'N/A') }}</p>
    <p><strong>Espacio:</strong> {{ $ticket->espacio->descripcion ?? 'N/A' }}</p>
    <p><strong>Lavado:</strong> {{ $ticket->lavado ? 'Sí' : 'No' }}</p>

    <div class="line"></div>
    <div class="footer">
        <p>{{ $configuracion->leyenda ?? 'Documento equivalente generado por sistema de parqueadero' }}</p>
        <p>Gracias por su visita</p>
    </div>
</body>
</html>


