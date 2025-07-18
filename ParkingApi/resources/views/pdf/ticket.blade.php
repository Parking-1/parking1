<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            width: 100%;
            text-align: center;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        .content p {
            margin: 2px 0;
        }

        .footer {
            margin-top: 6px;
            font-size: 9px;
        }
    </style>
</head>
<body>
    <div class="title">{{ strtoupper($configuracion->nombre_empresa) }}</div>
    <p>NIT: {{ $configuracion->nit }}</p>
    <p>{{ $configuracion->direccion }}</p>
    <p>Tel: {{ $configuracion->telefono }}</p>

    <div class="line"></div>

    <p><strong>Fecha:</strong> {{ $ticket->fecha_entrada->format('d/m/Y') }}</p>
<p><strong>Hora:</strong> {{ $ticket->fecha_entrada->format('H:i') }}</p>
    <p><strong>Placa:</strong> {{ strtoupper($ticket->vehiculo->placa) }}</p>
    <p><strong>Tipo:</strong> {{ ucfirst($ticket->vehiculo->tipo) }}</p>
    <p><strong>Espacio:</strong> {{ $ticket->espacio->descripcion }}</p>
    <p><strong>Lavado:</strong> {{ $ticket->lavado ? 'Sí' : 'No' }}</p>

    @if($ticket->cliente)
        <p><strong>Cliente:</strong> {{ $ticket->cliente->nombre }}</p>
    @endif

    <div class="line"></div>

    <div class="footer">
        <p>{{ $configuracion->leyenda }}</p>
        <p>Gracias por su visita</p>
    </div>
</body>
</html>

