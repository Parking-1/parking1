<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Cobro</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; }
        .datos { margin: 10px 0; }
    </style>
</head>
<body>
    <h1>{{ $configuracion->nombre_empresa ?? 'PARKING' }}</h1>
    <p>NIT: {{ $configuracion->nit ?? 'N/A' }}</p>
    <p>Dirección: {{ $configuracion->direccion ?? 'N/A' }}</p>
    <hr>

    <div class="datos">
        <p><strong>Placa:</strong> {{ $transaccion->vehiculo->placa }}</p>
        <p><strong>Tipo:</strong> {{ $transaccion->vehiculo->tipo }}</p>
        <p><strong>Fecha Entrada:</strong> {{ \Carbon\Carbon::parse($transaccion->fecha_entrada)->format('d/m/Y H:i') }}</p>
        <p><strong>Fecha Salida:</strong> {{ \Carbon\Carbon::parse($transaccion->fecha_salida)->format('d/m/Y H:i') }}</p>
        <p><strong>Tarifa:</strong> ${{ number_format($transaccion->tarifa->precio, 0, ',', '.') }}</p>
        <p><strong>Lavado:</strong> {{ $transaccion->lavado ? 'Sí' : 'No' }}</p>
        <p><strong>Total a Pagar:</strong> ${{ number_format($transaccion->precio_total, 0, ',', '.') }}</p>
    </div>

    <hr>
    <p style="text-align: center;">Gracias por su visita</p>
</body>
</html>
