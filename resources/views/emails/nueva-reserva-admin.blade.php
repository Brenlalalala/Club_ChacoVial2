<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Reserva Pendiente</title>
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
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
            border-left: 4px solid #f59e0b;
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
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            font-weight: bold;
        }
        .button-confirm {
            background: #10b981;
        }
        .button-view {
            background: #3b82f6;
        }
        .alert {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0;">🔔 Nueva Reserva Pendiente</h1>
        <p style="margin: 10px 0 0 0;">Requiere tu atención</p>
    </div>

    <div class="content">
        <div class="alert">
            <strong>⏰ ACCIÓN REQUERIDA:</strong> Una nueva reserva está esperando tu confirmación.
        </div>

        <div class="info-box">
            <h3 style="margin-top: 0; color: #f59e0b;">👤 Datos del Cliente</h3>
            
            <div class="info-row">
                <span class="label">Nombre:</span>
                <span class="value">{{ $reserva->nombre_cliente }}</span>
            </div>

            <div class="info-row">
                <span class="label">Email:</span>
                <span class="value">
                    <a href="mailto:{{ $reserva->email_cliente }}" style="color: #3b82f6;">{{ $reserva->email_cliente }}</a>
                </span>
            </div>

            <div class="info-row">
                <span class="label">Teléfono:</span>
                <span class="value">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $reserva->telefono_cliente) }}" style="color: #10b981;" target="_blank">
                        {{ $reserva->telefono_cliente }} (WhatsApp)
                    </a>
                </span>
            </div>
        </div>

        <div class="info-box">
            <h3 style="margin-top: 0; color: #f59e0b;">📋 Detalles de la Reserva</h3>
            
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

            <div class="info-row">
                <span class="label">Fecha de solicitud:</span>
                <span class="value">{{ $reserva->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <div class="price">
            Total: ${{ number_format($reserva->precio_total, 2) }}
        </div>

        @if($reserva->comentarios)
        <div class="info-box">
            <h4 style="margin-top: 0;">💬 Comentarios del Cliente:</h4>
            <p style="margin: 0; background: #f9fafb; padding: 10px; border-radius: 5px;">{{ $reserva->comentarios }}</p>
        </div>
        @endif

        <div style="text-align: center; margin-top: 30px;">
            <p><strong>Acciones disponibles:</strong></p>
            <a href="{{ route('admin.reservas.show', $reserva->id) }}" class="button button-view">
                Ver Detalle Completo
            </a>
            <br>
            <a href="{{ route('admin.reservas.confirmar', $reserva->id) }}" class="button button-confirm">
                Confirmar Reserva Ahora
            </a>
        </div>

        <hr style="border: none; border-top: 1px solid #ddd; margin: 30px 0;">

        <p style="font-size: 12px; color: #666; text-align: center;">
            <strong>TIP:</strong> Responde rápido para mejorar la satisfacción del cliente.<br>
            Puedes confirmar o cancelar la reserva desde el panel de administración.
        </p>
    </div>

    <div class="footer">
        <p style="margin: 0;">Panel de Administración - Club Chaco Vial</p>
        <p style="margin: 10px 0 0 0; font-size: 12px;">
            <a href="{{ route('admin.reservas.index') }}" style="color: #60a5fa;">Ir al Panel Admin</a>
        </p>
    </div>
</body>
</html>