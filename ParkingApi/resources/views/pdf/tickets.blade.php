<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Tickets</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Reporte de Tickets</h2>
    <p><strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Placa</th>
                <th>Fecha Entrada</th>
                <th>Lavado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $i => $ticket)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $ticket['placa'] }}</td>
                    <td>{{ $ticket['fecha_entrada'] }}</td>
                    <td>{{ $ticket['lavado'] ? 'Sí' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
