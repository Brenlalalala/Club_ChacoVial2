<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva Confirmada</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            border-left: 4px solid #10b981;
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
        .price {
            font-size: 24px;
            color: #10b981;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            background: #f0fdf4;
            border-radius: 5px;
            margin: 20px 0;
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
            background: #10b981;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .alert {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0;">✅ Reserva Confirmada</h1>
        <p style="margin: 10px 0 0 0;">Club Chaco Vial</p>
    </div>

    <div class="content">
        <p>Hola <strong>{{ $reserva->nombre_cliente }}</strong>,</p>
        
        <p>¡Excelente noticia! Tu reserva ha sido <strong>confirmada</strong> por el Club Chaco Vial.</p>

        <div class="info-box">
            <h3 style="margin-top: 0; color: #667eea;">📋 Detalles de la Reserva</h3>
            
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

            <div class="info-row">
                <span class="label">Duración:</span>
                <span class="value">{{ $reserva->horas_reserva }} hora(s)</span>
            </div>
        </div>

        <div class="price">
            Total: ${{ number_format($reserva->precio_total, 2) }}
        </div>

        <div class="alert">
            <strong>⚠️ Importante:</strong> Por favor, presenta este email al llegar al club. El pago se realiza en la recepción.
        </div>

        @if($reserva->comentarios)
        <div class="info-box">
            <h4 style="margin-top: 0;">💬 Notas:</h4>
            <p style="margin: 0;">{{ $reserva->comentarios }}</p>
        </div>
        @endif

        <div style="text-align: center; margin-top: 30px;">
            <p><strong>¿Necesitas hacer cambios?</strong></p>
            <p style="font-size: 14px; color: #666;">Contacta con nosotros por WhatsApp o email</p>
        </div>

        <hr style="border: none; border-top: 1px solid #ddd; margin: 30px 0;">

        <p style="font-size: 14px; color: #666;">
            <strong>Datos de contacto del Club:</strong><br>
            📧 Email: admin@clubchacovial.com<br>
            📱 WhatsApp: {{ $reserva->telefono_cliente }}<br>
            📍 Dirección: Club Chaco Vial
        </p>
    </div>

    <div class="footer">
        <p style="margin: 0;">© {{ date('Y') }} Club Chaco Vial - Todos los derechos reservados</p>
        <p style="margin: 10px 0 0 0; font-size: 12px;">Este es un email automático, por favor no respondas a este mensaje.</p>
    </div>
</body>
</html>