<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva Cancelada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .info-box {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #ef4444;
            border-radius: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #666;
        }
        .value {
            color: #333;
        }
        .footer {
            background: #333;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 10px 10px;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            background: #3b82f6;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .alert-box {
            background: #fee2e2;
            border: 1px solid #ef4444;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0;">❌ Reserva Cancelada</h1>
        <p style="margin: 10px 0 0 0;">Club Chaco Vial</p>
    </div>

    <div class="content">
        <p>Hola <strong>{{ $reserva->nombre_cliente }}</strong>,</p>
        
        <p>Lamentamos informarte que tu reserva ha sido <strong>cancelada</strong>.</p>

        <div class="info-box">
            <h3 style="margin-top: 0; color: #ef4444;">📋 Detalles de la Reserva Cancelada</h3>
            
            <div class="info-row">
                <span class="label">Número de Reserva:</span>
                <span class="value" style="font-weight: bold;">#{{ str_pad($reserva->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="info-row">
                <span class="label">Instalación:</span>
                <span class="value">{{ $reserva->instalacion->nombre }}</span>
            </div>

            <div class="info-row">
                <span class="label">Fecha:</span>
                <span class="value">{{ $reserva->fecha_inicio->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
            </div>

            <div class="info-row">
                <span class="label">Horario:</span>
                <span class="value">{{ $reserva->fecha_inicio->format('H:i') }} - {{ $reserva->fecha_fin->format('H:i') }} hs</span>
            </div>
        </div>

        @php
            // Extraer solo el motivo de cancelación si está en comentarios
            $motivo = '';
            if ($reserva->comentarios) {
                if (strpos($reserva->comentarios, 'Motivo cancelación:') !== false) {
                    $partes = explode('Motivo cancelación:', $reserva->comentarios);
                    $motivo = trim(end($partes));
                } else if (strpos($reserva->comentarios, 'Motivo:') !== false) {
                    $partes = explode('Motivo:', $reserva->comentarios);
                    $motivo = trim(end($partes));
                }
            }
        @endphp

        @if($motivo)
        <div class="alert-box">
            <h4 style="margin-top: 0; color: #dc2626;">Motivo de la Cancelación:</h4>
            <p style="margin: 0;">{{ $motivo }}</p>
        </div>
        @endif

        <hr style="border: none; border-top: 1px solid #ddd; margin: 30px 0;">

        <div style="text-align: center;">
            <p><strong>¿Quieres hacer una nueva reserva?</strong></p>
            <a href="{{ url('/reservar') }}" class="button">Reservar Nuevamente</a>
        </div>

        <p style="font-size: 14px; color: #666; margin-top: 30px;">
            Si tienes alguna duda o consulta, no dudes en contactarnos:<br><br>
            📧 Email: admin@clubchacovial.com<br>
            📱 WhatsApp: {{ $reserva->telefono_cliente }}
        </p>
    </div>

    <div class="footer">
        <p style="margin: 0;">© {{ date('Y') }} Club Chaco Vial - Todos los derechos reservados</p>
        <p style="margin: 10px 0 0 0; font-size: 12px;">Este es un email automático, por favor no respondas a este mensaje.</p>
    </div>
</body>
</html>