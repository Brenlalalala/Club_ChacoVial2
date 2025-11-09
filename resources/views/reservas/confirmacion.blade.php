@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 md:p-8 mt-4 md:mt-20 max-w-3xl">
    <!-- Mensaje de éxito -->
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-6 mb-8 rounded-lg shadow-md">
        <div class="flex items-center mb-2">
            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <h2 class="text-2xl font-bold">¡Solicitud de Reserva Recibida!</h2>
        </div>
        <p class="text-base">Tu reserva ha sido registrada correctamente y está pendiente de confirmación.</p>
    </div>

    <!-- Detalles de la reserva -->
    <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">Detalles de tu Reserva</h3>
        
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Información de la instalación -->
            <div>
                <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Instalación
                </h4>
                <p class="text-lg text-gray-900 font-medium">{{ $reserva->instalacion->nombre }}</p>
                <p class="text-sm text-gray-600">{{ $reserva->instalacion->descripcion }}</p>
            </div>

            <!-- Datos del cliente -->
            <div>
                <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Datos de Contacto
                </h4>
                <p class="text-gray-900"><strong>Nombre:</strong> {{ $reserva->nombre_cliente }}</p>
                <p class="text-gray-900"><strong>Email:</strong> {{ $reserva->email_cliente }}</p>
                <p class="text-gray-900"><strong>Teléfono:</strong> {{ $reserva->telefono_cliente }}</p>
            </div>

            <!-- Fecha y hora -->
            <div>
                <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Fecha y Horario
                </h4>
                <p class="text-gray-900"><strong>Fecha:</strong> {{ $reserva->fecha_inicio->format('d/m/Y') }}</p>
                <p class="text-gray-900"><strong>Desde:</strong> {{ $reserva->fecha_inicio->format('H:i') }} hs</p>
                <p class="text-gray-900"><strong>Hasta:</strong> {{ $reserva->fecha_fin->format('H:i') }} hs</p>
                <p class="text-gray-600 text-sm mt-1">Duración: {{ $reserva->horas_reserva }} hora(s)</p>
            </div>

            <!-- Precio -->
            <div>
                <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Precio
                </h4>
                <p class="text-3xl font-bold text-green-600">${{ number_format($reserva->precio_total, 2) }}</p>
                <p class="text-sm text-gray-600">El pago se coordina al confirmar</p>
            </div>
        </div>

        <!-- Estado -->
        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <p class="text-yellow-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <strong>Estado:</strong> <span class="ml-2 px-3 py-1 bg-yellow-200 text-yellow-800 rounded-full text-sm font-semibold">PENDIENTE</span>
            </p>
        </div>

        @if($reserva->comentarios)
        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
            <p class="text-gray-700"><strong>Comentarios:</strong></p>
            <p class="text-gray-600 mt-1">{{ $reserva->comentarios }}</p>
        </div>
        @endif
    </div>

    <!-- Información adicional -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
        <h3 class="text-lg font-bold text-blue-900 mb-3">📧 ¿Qué sigue ahora?</h3>
        <ul class="space-y-2 text-sm text-blue-800">
            <li class="flex items-start">
                <span class="mr-2 mt-1">1️⃣</span>
                <span>El administrador del club revisará tu solicitud.</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2 mt-1">2️⃣</span>
                <span>Recibirás un <strong>email de confirmación</strong> en <strong>{{ $reserva->email_cliente }}</strong></span>
            </li>
            <li class="flex items-start">
                <span class="mr-2 mt-1">3️⃣</span>
                <span>El email incluirá las instrucciones de pago y el comprobante de reserva.</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2 mt-1">4️⃣</span>
                <span>Para cancelaciones, contacta al club por WhatsApp al <strong>{{ $reserva->telefono_cliente }}</strong></span>
            </li>
        </ul>
    </div>

    <!-- Número de reserva -->
    <div class="text-center mb-6">
        <p class="text-gray-600 text-sm">Número de reserva:</p>
        <p class="text-2xl font-bold text-indigo-600">#{{ str_pad($reserva->id, 6, '0', STR_PAD_LEFT) }}</p>
        <p class="text-xs text-gray-500 mt-1">Guarda este número para futuras consultas</p>
    </div>

    <!-- Botones de acción -->
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <a href="{{ url('/') }}" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 text-center">
            Volver al Inicio
        </a>
        <a href="{{ route('reservas.create') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition-colors duration-200 text-center">
            Hacer Otra Reserva
        </a>
    </div>
</div>
@endsection