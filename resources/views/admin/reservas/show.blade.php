@extends('layouts.admin')

@section('title', 'Detalle de Reserva')

@section('content')
<!-- Breadcrumb y acciones -->
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.reservas.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm mb-2 inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Volver a la lista
            </a>
            <h2 class="text-3xl font-bold text-gray-800">
                Reserva #{{ str_pad($reserva->id, 6, '0', STR_PAD_LEFT) }}
            </h2>
            <p class="text-gray-600 mt-1">Creada el {{ $reserva->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Estado badge grande -->
        <div>
            @if($reserva->estado === 'pendiente')
                <span class="inline-flex items-center px-6 py-3 bg-yellow-100 text-yellow-800 rounded-lg text-lg font-bold">
                    <i class="fas fa-clock mr-2"></i>PENDIENTE
                </span>
            @elseif($reserva->estado === 'aceptada')
                <span class="inline-flex items-center px-6 py-3 bg-green-100 text-green-800 rounded-lg text-lg font-bold">
                    <i class="fas fa-check-circle mr-2"></i>ACEPTADA
                </span>
            @else
                <span class="inline-flex items-center px-6 py-3 bg-red-100 text-red-800 rounded-lg text-lg font-bold">
                    <i class="fas fa-times-circle mr-2"></i>CANCELADA
                </span>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Columna principal -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Información de la instalación -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-building text-indigo-600 mr-2"></i>
                Instalación
            </h3>
            <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-200">
                <h4 class="text-lg font-bold text-indigo-900 mb-2">{{ $reserva->instalacion->nombre }}</h4>
                <p class="text-gray-700 mb-3">{{ $reserva->instalacion->descripcion }}</p>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600 font-medium">Capacidad:</span>
                        <span class="text-gray-900 ml-2">{{ $reserva->instalacion->capacidad }} personas</span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">Precio/hora:</span>
                        <span class="text-green-600 font-bold ml-2">${{ number_format($reserva->instalacion->precio_hora, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fecha y horario -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>
                Fecha y Horario
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Fecha de reserva</p>
                    <p class="text-lg font-bold text-gray-900">{{ $reserva->fecha_inicio->format('d/m/Y') }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $reserva->fecha_inicio->locale('es')->isoFormat('dddd') }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Hora inicio</p>
                    <p class="text-lg font-bold text-gray-900">{{ $reserva->fecha_inicio->format('H:i') }} hs</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm text-gray-600 mb-1">Hora fin</p>
                    <p class="text-lg font-bold text-gray-900">{{ $reserva->fecha_fin->format('H:i') }} hs</p>
                </div>
            </div>
            <div class="mt-4 bg-indigo-50 rounded-lg p-4 border border-indigo-200">
                <div class="flex items-center justify-between">
                    <span class="text-gray-700 font-medium">Duración total:</span>
                    <span class="text-2xl font-bold text-indigo-900">{{ $reserva->horas_reserva }} hora(s)</span>
                </div>
            </div>
        </div>

        <!-- Información del cliente -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-user text-indigo-600 mr-2"></i>
                Información del Cliente
            </h3>
            <div class="space-y-3">
                <div class="flex items-center py-2 border-b border-gray-100">
                    <i class="fas fa-user-circle text-gray-400 w-8"></i>
                    <div>
                        <p class="text-sm text-gray-600">Nombre completo</p>
                        <p class="font-medium text-gray-900">{{ $reserva->nombre_cliente }}</p>
                    </div>
                </div>
                <div class="flex items-center py-2 border-b border-gray-100">
                    <i class="fas fa-envelope text-gray-400 w-8"></i>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <a href="mailto:{{ $reserva->email_cliente }}" class="font-medium text-indigo-600 hover:underline">
                            {{ $reserva->email_cliente }}
                        </a>
                    </div>
                </div>
                <div class="flex items-center py-2">
                    <i class="fas fa-phone text-gray-400 w-8"></i>
                    <div>
                        <p class="text-sm text-gray-600">Teléfono / WhatsApp</p>
                        <a href="tel:{{ $reserva->telefono_cliente }}" class="font-medium text-gray-900">
                            {{ $reserva->telefono_cliente }}
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $reserva->telefono_cliente) }}" 
                           target="_blank"
                           class="ml-2 text-green-600 hover:text-green-700">
                            <i class="fab fa-whatsapp"></i> Abrir WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comentarios -->
        @if($reserva->comentarios)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-comment-alt text-indigo-600 mr-2"></i>
                Comentarios
            </h3>
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <p class="text-gray-700 whitespace-pre-line">{{ $reserva->comentarios }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Columna lateral -->
    <div class="space-y-6">
        <!-- Resumen de pago -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-receipt text-indigo-600 mr-2"></i>
                Resumen
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">Precio por hora:</span>
                    <span class="font-medium text-gray-900">${{ number_format($reserva->instalacion->precio_hora, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">Duración:</span>
                    <span class="font-medium text-gray-900">{{ $reserva->horas_reserva }}h</span>
                </div>
                <div class="flex justify-between py-3 bg-green-50 rounded-lg px-3 mt-3">
                    <span class="text-lg font-bold text-gray-800">TOTAL:</span>
                    <span class="text-2xl font-bold text-green-600">${{ number_format($reserva->precio_total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Acciones</h3>
            
            @if($reserva->estado === 'pendiente')
                <div class="space-y-3">
                    <form method="POST" action="{{ route('admin.reservas.confirmar', $reserva->id) }}">
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('¿Confirmar esta reserva? Se enviará un email al cliente.')"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition flex items-center justify-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            Confirmar Reserva
                        </button>
                    </form>

                    <button onclick="mostrarModalCancelar()" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-times-circle mr-2"></i>
                        Cancelar Reserva
                    </button>
                </div>
            @elseif($reserva->estado === 'aceptada')
                <div class="space-y-3">
                    <a href="{{ route('admin.reservas.edit', $reserva->id) }}" 
                       class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition text-center">
                        <i class="fas fa-edit mr-2"></i>
                        Editar Reserva
                    </a>
                    
                    <button onclick="mostrarModalCancelar()" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-times-circle mr-2"></i>
                        Cancelar Reserva
                    </button>
                </div>
            @else
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-red-700 text-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Esta reserva fue cancelada
                    </p>
                </div>
            @endif

            <hr class="my-4">

            <!-- Acciones adicionales -->
            <div class="space-y-2">
                <button onclick="window.print()" 
                        class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition text-sm">
                    <i class="fas fa-print mr-2"></i>
                    Imprimir
                </button>
                
                <a href="mailto:{{ $reserva->email_cliente }}?subject=Reserva #{{ $reserva->id }} - Club Chaco Vial" 
                   class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition text-sm text-center">
                    <i class="fas fa-envelope mr-2"></i>
                    Enviar Email
                </a>
            </div>
        </div>

        <!-- Historial -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Historial</h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-start">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3"></div>
                    <div>
                        <p class="font-medium text-gray-900">Reserva creada</p>
                        <p class="text-gray-500">{{ $reserva->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                @if($reserva->estado === 'aceptada')
                    <div class="flex items-start">
                        <div class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3"></div>
                        <div>
                            <p class="font-medium text-gray-900">Reserva confirmada</p>
                            <p class="text-gray-500">{{ $reserva->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                @elseif($reserva->estado === 'cancelada')
                    <div class="flex items-start">
                        <div class="w-2 h-2 bg-red-500 rounded-full mt-2 mr-3"></div>
                        <div>
                            <p class="font-medium text-gray-900">Reserva cancelada</p>
                            <p class="text-gray-500">{{ $reserva->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal para cancelar -->
<div id="modalCancelar" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Cancelar Reserva</h3>
            <form method="POST" action="{{ route('admin.reservas.cancelar', $reserva->id) }}">
                @csrf
                <div class="mb-4">
                    <label for="motivo" class="block text-sm font-medium text-gray-700 mb-2">
                        Motivo de cancelación (opcional)
                    </label>
                    <textarea name="motivo" id="motivo" rows="3" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                              placeholder="Ej: Cliente solicitó cancelación, falta de pago, etc."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" 
                            onclick="cerrarModalCancelar()" 
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                        Confirmar Cancelación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function mostrarModalCancelar() {
    document.getElementById('modalCancelar').classList.remove('hidden');
}

function cerrarModalCancelar() {
    document.getElementById('modalCancelar').classList.add('hidden');
    document.getElementById('motivo').value = '';
}

// Cerrar modal al hacer clic fuera
document.getElementById('modalCancelar').addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalCancelar();
    }
});
</script>
@endpush
@endsection