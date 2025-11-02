<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 3px solid #4F46E5;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #4F46E5;
            margin: 0;
        }
        .subtitle {
            font-size: 16px;
            color: #666;
            margin: 5px 0 0 0;
        }
        .estado-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            margin: 15px 0;
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
        .info-section {
            margin: 20px 0;
            padding: 15px;
            background: #f9fafb;
            border-left: 4px solid #4F46E5;
        }
        .info-section h3 {
            margin: 0 0 15px 0;
            color: #4F46E5;
            font-size: 16px;
        }
        .info-row {
            margin: 8px 0;
            padding: 5px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            display: inline-block;
            width: 150px;
            font-weight: bold;
            color: #666;
        }
        .value {
            color: #333;
        }
        .price-box {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: white;
            border-radius: 10px;
            margin: 20px 0;
        }
        .price-label {
            font-size: 14px;
            margin: 0 0 5px 0;
        }
        .price-value {
            font-size: 36px;
            font-weight: bold;
            margin: 0;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 11px;
            color: #666;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        .alert-box {
            background: #FEF3C7;
            border: 2px solid #F59E0B;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1 class="logo">Club Chaco Vial</h1>
        <p class="subtitle">Comprobante de Reserva</p>
        <p style="margin: 10px 0; font-size: 18px; font-weight: bold;">
            #{{ str_pad($reserva->id, 6, '0', STR_PAD_LEFT) }}
        </p>
        <span class="estado-badge estado-{{ $reserva->estado }}">
            {{ strtoupper($reserva->estado) }}
        </span>
    </div>

    <!-- Información del Cliente -->
    <div class="info-section">
        <h3>👤 Datos del Cliente</h3>
        <div class="info-row">
            <span class="label">Nombre Completo:</span>
            <span class="value">{{ $reserva->nombre_cliente }}</span>
        </div>
        <div class="info-row">
            <span class="label">Email:</span>
            <span class="value">{{ $reserva->email_cliente }}</span>
        </div>
        <div class="info-row">
            <span class="label">Teléfono:</span>
            <span class="value">{{ $reserva->telefono_cliente }}</span>
        </div>
    </div>

    <!-- Información de la Reserva -->
    <div class="info-section">
        <h3>📋 Detalles de la Reserva</h3>
        <div class="info-row">
            <span class="label">Instalación:</span>
            <span class="value"><strong>{{ $reserva->instalacion->nombre }}</strong></span>
        </div>
        <div class="info-row">
            <span class="label">Capacidad:</span>
            <span class="value">{{ $reserva->instalacion->capacidad }} personas</span>
        </div>
        <div class="info-row">
            <span class="label">Fecha de Reserva:</span>
            <span class="value">{{ $reserva->fecha_inicio->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Hora de Inicio:</span>
            <span class="value">{{ $reserva->fecha_inicio->format('H:i') }} hs</span>
        </div>
        <div class="info-row">
            <span class="label">Hora de Fin:</span>
            <span class="value">{{ $reserva->fecha_fin->format('H:i') }} hs</span>
        </div>
        <div class="info-row">
            <span class="label">Duración:</span>
            <span class="value"><strong>{{ $reserva->horas_reserva }} hora(s)</strong></span>
        </div>
        <div class="info-row">
            <span class="label">Fecha de Solicitud:</span>
            <span class="value">{{ $reserva->created_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    @if($reserva->comentarios)
    <div class="info-section">
        <h3>💬 Comentarios</h3>
        <p style="margin: 0;">{{ $reserva->comentarios }}</p>
    </div>
    @endif

    <!-- Precio -->
    <div class="price-box">
        <p class="price-label">TOTAL A PAGAR</p>
        <p class="price-value">${{ number_format($reserva->precio_total, 2) }}</p>
    </div>

    @if($reserva->estado === 'aceptada')
    <div class="alert-box">
        <strong>✓ RESERVA CONFIRMADA</strong><br>
        Por favor, presenta este comprobante al llegar al club.<br>
        El pago se realiza en la recepción.
    </div>
    @elseif($reserva->estado === 'pendiente')
    <div class="alert-box">
        <strong>⏳ RESERVA PENDIENTE</strong><br>
        Tu reserva está siendo procesada. Recibirás un email cuando sea confirmada.
    </div>
    @endif

    <!-- Información del Club -->
    <div class="info-section">
        <h3>📍 Información de Contacto</h3>
        <div class="info-row">
            <span class="label">Dirección:</span>
            <span class="value">Club Chaco Vial, Resistencia, Chaco</span>
        </div>
        <div class="info-row">
            <span class="label">Email:</span>
            <span class="value">admin@clubchacovial.com</span>
        </div>
        <div class="info-row">
            <span class="label">WhatsApp:</span>
            <span class="value">{{ $reserva->telefono_cliente }}</span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Términos y Condiciones:</strong></p>
        <p>
            • La reserva es válida solo para la fecha y hora especificadas.<br>
            • El pago debe realizarse al llegar al club.<br>
            • Para cancelaciones, contactar con 24 horas de anticipación.<br>
            • Este comprobante no es válido como factura fiscal.
        </p>
        <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
        <p>
            Documento generado el {{ now()->format('d/m/Y H:i') }}<br>
            © {{ date('Y') }} Club Chaco Vial - Todos los derechos reservados
        </p>
    </div>
</body>
</html>