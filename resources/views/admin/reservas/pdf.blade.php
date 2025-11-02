<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Reservas - Club Chaco Vial</title>
    <style>
        @page {
            margin: 100px 50px;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }
        header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            height: 60px;
            text-align: center;
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 10px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #4F46E5;
            margin: 0;
        }
        .subtitle {
            font-size: 14px;
            color: #666;
            margin: 5px 0 0 0;
        }
        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 40px;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            font-size: 9px;
            color: #666;
        }
        .page-number:before {
            content: "Página " counter(page);
        }
        .info-box {
            background: #f3f4f6;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-left: 4px solid #4F46E5;
        }
        .info-row {
            display: inline-block;
            width: 48%;
            margin-bottom: 5px;
        }
        .label {
            font-weight: bold;
            color: #4F46E5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }
        thead {
            background: #4F46E5;
            color: white;
        }
        th {
            padding: 10px 5px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #4F46E5;
        }
        td {
            padding: 8px 5px;
            border-bottom: 1px solid #e5e7eb;
        }
        tr:nth-child(even) {
            background: #f9fafb;
        }
        .estado {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }
        .estado-pendiente {
            background: #FEF3C7;
            color: #92400E;
        }
        .estado-aceptada {
            background: #D1FAE5;
            color: #065F46;
        }
        .estado-cancelada {
            background: #FEE2E2;
            color: #991B1B;
        }
        .summary {
            margin-top: 30px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 5px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .summary-row:last-child {
            border-bottom: none;
            font-size: 14px;
            font-weight: bold;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1 class="logo">Club Chaco Vial</h1>
        <p class="subtitle">Reporte de Reservas</p>
    </header>

    <footer>
        <p class="page-number"></p>
        <p>Generado el {{ now()->format('d/m/Y H:i') }} | © {{ date('Y') }} Club Chaco Vial</p>
    </footer>

    <main>
        <!-- Información del reporte -->
        <div class="info-box">
            <div class="info-row">
                <span class="label">Fecha del reporte:</span> {{ now()->format('d/m/Y H:i') }}
            </div>
            <div class="info-row">
                <span class="label">Total de reservas:</span> {{ $reservas->count() }}
            </div>
            @if(isset($filtros['estado']))
            <div class="info-row">
                <span class="label">Filtrado por estado:</span> {{ ucfirst($filtros['estado']) }}
            </div>
            @endif
            @if(isset($filtros['fecha']))
            <div class="info-row">
                <span class="label">Filtrado por fecha:</span> {{ $filtros['fecha'] }}
            </div>
            @endif
        </div>

        <!-- Tabla de reservas -->
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 15%;">Cliente</th>
                    <th style="width: 15%;">Instalación</th>
                    <th style="width: 12%;">Fecha</th>
                    <th style="width: 12%;">Horario</th>
                    <th style="width: 8%;">Duración</th>
                    <th style="width: 10%;">Precio</th>
                    <th style="width: 10%;">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservas as $reserva)
                <tr>
                    <td>#{{ $reserva->id }}</td>
                    <td>
                        <strong>{{ $reserva->nombre_cliente }}</strong><br>
                        <small style="color: #666;">{{ $reserva->telefono_cliente }}</small>
                    </td>
                    <td>{{ $reserva->instalacion->nombre }}</td>
                    <td>{{ $reserva->fecha_inicio->format('d/m/Y') }}</td>
                    <td>{{ $reserva->fecha_inicio->format('H:i') }} - {{ $reserva->fecha_fin->format('H:i') }}</td>
                    <td>{{ $reserva->horas_reserva }}h</td>
                    <td>${{ number_format($reserva->precio_total, 2) }}</td>
                    <td>
                        <span class="estado estado-{{ $reserva->estado }}">
                            {{ $reserva->estado }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #999;">
                        No se encontraron reservas con los filtros aplicados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Resumen -->
        @if($reservas->count() > 0)
        <div class="summary">
            <h3 style="margin-top: 0; color: #4F46E5;">Resumen</h3>
            <div class="summary-row">
                <span>Reservas Pendientes:</span>
                <span><strong>{{ $reservas->where('estado', 'pendiente')->count() }}</strong></span>
            </div>
            <div class="summary-row">
                <span>Reservas Aceptadas:</span>
                <span><strong>{{ $reservas->where('estado', 'aceptada')->count() }}</strong></span>
            </div>
            <div class="summary-row">
                <span>Reservas Canceladas:</span>
                <span><strong>{{ $reservas->where('estado', 'cancelada')->count() }}</strong></span>
            </div>
            <div class="summary-row">
                <span>Ingresos Totales (Aceptadas):</span>
                <span style="color: #059669;">
                    <strong>${{ number_format($reservas->where('estado', 'aceptada')->sum('precio_total'), 2) }}</strong>
                </span>
            </div>
        </div>
        @endif
    </main>
</body>
</html>