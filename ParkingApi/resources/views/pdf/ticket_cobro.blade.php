<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Salida</title>
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

    <p><strong>Placa:</strong> {{ strtoupper($transaccion->vehiculo->placa) }}</p>
    <p><strong>Tipo:</strong> {{ $transaccion->vehiculo->tipoVehiculo->descripcion ?? 'No especificado' }}</p>

    <p><strong>Fecha Entrada:</strong> {{ optional($transaccion->fecha_entrada)->format('d/m/Y H:i') }}</p>
    <p><strong>Fecha Salida:</strong> {{ optional($transaccion->fecha_salida)->format('d/m/Y H:i') }}</p>

    <p><strong>Tiempo:</strong> {{ $tiempo }}</p>

    <p><strong>Total a Pagar:</strong> ${{ number_format($transaccion->precio_total, 0, ',', '.') }}</p>

    <p><strong>Lavado:</strong> {{ $transaccion->lavado ? 'Sí' : 'No' }}</p>

    @if(isset($respuesta['cufe']))
    <p>CUFE: {{ $respuesta['cufe'] }}</p>
    <p>Validado: {{ $respuesta['fecha_validacion'] }}</p>
@endif


    <div class="line"></div>

    <div class="footer">
        <p>{{ $configuracion->leyenda }}</p>
        <p>Gracias por su visita</p>
    </div>
</body>
</html>




