<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Cobro</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }
        .titulo {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .linea {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .dato {
            margin: 5px 0;
        }
    </style>
</head>
<body>

    <div class="titulo">{{ $configuracion->nombre_empresa ?? 'EMPRESA' }}</div>
    <div class="dato">NIT: {{ $configuracion->nit ?? 'N/A' }}</div>
    <div class="dato">Dirección: {{ $configuracion->direccion ?? 'N/A' }}</div>
    <div class="dato">Teléfono: {{ $configuracion->telefono ?? 'N/A' }}</div>
    <div class="dato">Resolución DIAN: {{ $configuracion->resolucion_dian ?? 'N/A' }}</div>

    <div class="linea"></div>

    <div class="dato"><strong>Placa:</strong> {{ $transaccion->vehiculo->placa ?? 'Desconocida' }}</div>
    <div class="dato"><strong>Clase de Vehículo:</strong> {{ $transaccion->vehiculo->tipoVehiculo->descripcion ?? 'N/A' }}</div>

    <div class="linea"></div>

    <div class="dato"><strong>Fecha de Entrada:</strong> {{ $transaccion->fecha_ingreso->format('d/m/Y') }}</div>
    <div class="dato"><strong>Hora de Entrada:</strong> {{ $transaccion->fecha_ingreso->format('H:i') }}</div>

    <div class="dato"><strong>Fecha de Salida:</strong> {{ $transaccion->fecha_salida->format('d/m/Y') }}</div>
    <div class="dato"><strong>Hora de Salida:</strong> {{ $transaccion->fecha_salida->format('H:i') }}</div>

    <div class="linea"></div>

    <div class="dato"><strong>Lavado:</strong> {{ $transaccion->lavado ? 'Sí' : 'No' }}</div>

    <div class="dato">
        <strong>Tiempo Estacionado:</strong>
        {{ $transaccion->fecha_ingreso->diff($transaccion->fecha_salida)->format('%h horas %i minutos') }}
    </div>

    <div class="dato"><strong>Total a Pagar:</strong> ${{ number_format($transaccion->precio_total, 0, ',', '.') }}</div>

    <div class="linea"></div>

    <div class="titulo">Gracias por su visita</div>
</body>
</html>

