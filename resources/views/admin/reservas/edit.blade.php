@extends('layouts.admin')

@section('title', 'Editar Reserva')

@section('content')
<!-- Breadcrumb -->
<div class="mb-6">
    <a href="{{ route('admin.reservas.show', $reserva->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm mb-2 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Volver al detalle
    </a>
    <h2 class="text-3xl font-bold text-gray-800">
        Editar Reserva #{{ str_pad($reserva->id, 6, '0', STR_PAD_LEFT) }}
    </h2>
    <p class="text-gray-600 mt-1">Modifica la información de la reserva</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Formulario principal -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('admin.reservas.update', $reserva->id) }}">
                @csrf
                @method('PUT')

                <!-- Información de la instalación (solo lectura) -->
                <div class="mb-6 bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-building text-indigo-600 mr-2"></i>
                        Instalación
                    </h3>
                    <p class="text-lg font-medium text-gray-900">{{ $reserva->instalacion->nombre }}</p>
                    <p class="text-sm text-gray-600">No se puede cambiar la instalación de una reserva existente</p>
                </div>

                <!-- Datos del cliente (solo lectura) -->
                <div class="mb-6 bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-user text-indigo-600 mr-2"></i>
                        Cliente
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                        <div>
                            <p class="text-gray-600">Nombre:</p>
                            <p class="font-medium text-gray-900">{{ $reserva->nombre_cliente }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Email:</p>
                            <p class="font-medium text-gray-900">{{ $reserva->email_cliente }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Teléfono:</p>
                            <p class="font-medium text-gray-900">{{ $reserva->telefono_cliente }}</p>
                        </div>
                    </div>
                </div>

                <hr class="my-6">

                <!-- Fecha y horario (EDITABLE) -->
                <div class="mb-6">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>
                        Fecha y Horario
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <!-- Fecha -->
                        <div>
                            <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">
                                Fecha <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   name="fecha" 
                                   id="fecha" 
                                   value="{{ old('fecha', $reserva->fecha_inicio->format('Y-m-d')) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   required>
                        </div>

                        <!-- Hora inicio -->
                        <div>
                            <label for="hora_inicio" class="block text-sm font-medium text-gray-700 mb-2">
                                Hora Inicio <span class="text-red-500">*</span>
                            </label>
                            <input type="time" 
                                   name="hora_inicio" 
                                   id="hora_inicio" 
                                   value="{{ old('hora_inicio', $reserva->fecha_inicio->format('H:i')) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   required>
                        </div>

                        <!-- Hora fin -->
                        <div>
                            <label for="hora_fin" class="block text-sm font-medium text-gray-700 mb-2">
                                Hora Fin <span class="text-red-500">*</span>
                            </label>
                            <input type="time" 
                                   name="hora_fin" 
                                   id="hora_fin" 
                                   value="{{ old('hora_fin', $reserva->fecha_fin->format('H:i')) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   required>
                        </div>
                    </div>

                    <!-- Campos ocultos para datetime -->
                    <input type="hidden" name="fecha_inicio" id="fecha_inicio">
                    <input type="hidden" name="fecha_fin" id="fecha_fin">

                    <!-- Resumen de duración -->
                    <div id="resumenDuracion" class="bg-indigo-50 rounded-lg p-4 border border-indigo-200 hidden">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700 font-medium">Duración:</span>
                            <span id="duracionHoras" class="text-xl font-bold text-indigo-900">-- horas</span>
                        </div>
                    </div>
                </div>

                <hr class="my-6">

                <!-- Precio (EDITABLE) -->
                <div class="mb-6">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-dollar-sign text-indigo-600 mr-2"></i>
                        Precio
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="precio_total" class="block text-sm font-medium text-gray-700 mb-2">
                                Precio Total <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                <input type="number" 
                                       name="precio_total" 
                                       id="precio_total" 
                                       value="{{ old('precio_total', $reserva->precio_total) }}"
                                       step="0.01"
                                       min="0"
                                       class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       required>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Precio sugerido: ${{ number_format($reserva->instalacion->precio_hora, 2) }}/hora
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 flex items-center">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Precio anterior:</p>
                                <p class="text-2xl font-bold text-gray-900">${{ number_format($reserva->precio_total, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-6">

                <!-- Comentarios (EDITABLE) -->
                <div class="mb-6">
                    <label for="comentarios" class="block text-sm font-medium text-gray-700 mb-2">
                        Comentarios / Notas internas
                    </label>
                    <textarea name="comentarios" 
                              id="comentarios" 
                              rows="4" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Agregar notas, observaciones o cambios realizados...">{{ old('comentarios', $reserva->comentarios) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Estos comentarios son visibles para el cliente</p>
                </div>

                <!-- Botones de acción -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Cambios
                    </button>
                    <a href="{{ route('admin.reservas.show', $reserva->id) }}" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-6 rounded-lg transition text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Columna lateral - Información adicional -->
    <div class="space-y-6">
        <!-- Advertencias -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <h3 class="font-bold text-yellow-900 mb-2 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Importante
            </h3>
            <ul class="text-sm text-yellow-800 space-y-2">
                <li class="flex items-start">
                    <i class="fas fa-circle text-xs mt-1 mr-2"></i>
                    <span>Los cambios no envían notificaciones automáticas al cliente</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-circle text-xs mt-1 mr-2"></i>
                    <span>Verifica la disponibilidad antes de cambiar la fecha/hora</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-circle text-xs mt-1 mr-2"></i>
                    <span>Contacta al cliente para informarle de los cambios</span>
                </li>
            </ul>
        </div>

        <!-- Información del sistema -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="font-bold text-gray-800 mb-3">Información del Sistema</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">ID Reserva:</span>
                    <span class="font-mono font-medium text-gray-900">#{{ str_pad($reserva->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Creada:</span>
                    <span class="text-gray-900">{{ $reserva->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Modificada:</span>
                    <span class="text-gray-900">{{ $reserva->updated_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Estado:</span>
                    <span class="font-semibold text-green-600">{{ ucfirst($reserva->estado) }}</span>
                </div>
            </div>
        </div>

        <!-- Acciones rápidas -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="font-bold text-gray-800 mb-3">Acciones Rápidas</h3>
            <div class="space-y-2">
                <a href="mailto:{{ $reserva->email_cliente }}" 
                   class="block w-full bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium py-2 px-4 rounded-lg transition text-sm text-center">
                    <i class="fas fa-envelope mr-2"></i>
                    Enviar Email al Cliente
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $reserva->telefono_cliente) }}" 
                   target="_blank"
                   class="block w-full bg-green-50 hover:bg-green-100 text-green-700 font-medium py-2 px-4 rounded-lg transition text-sm text-center">
                    <i class="fab fa-whatsapp mr-2"></i>
                    Contactar por WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const fechaInput = document.getElementById('fecha');
    const horaInicioInput = document.getElementById('hora_inicio');
    const horaFinInput = document.getElementById('hora_fin');
    const resumenDiv = document.getElementById('resumenDuracion');
    const duracionSpan = document.getElementById('duracionHoras');

    // Combinar fecha y hora antes de enviar
    form.addEventListener('submit', function(e) {
        const fecha = fechaInput.value;
        const horaInicio = horaInicioInput.value;
        const horaFin = horaFinInput.value;
        
        if (!fecha || !horaInicio || !horaFin) {
            e.preventDefault();
            alert('Por favor completa todos los campos de fecha y hora');
            return false;
        }
        
        document.getElementById('fecha_inicio').value = `${fecha} ${horaInicio}:00`;
        document.getElementById('fecha_fin').value = `${fecha} ${horaFin}:00`;
    });

    // Calcular duración
    function calcularDuracion() {
        const horaInicio = horaInicioInput.value;
        const horaFin = horaFinInput.value;
        
        if (horaInicio && horaFin) {
            const [h1, m1] = horaInicio.split(':').map(Number);
            const [h2, m2] = horaFin.split(':').map(Number);
            
            const minutos1 = h1 * 60 + m1;
            const minutos2 = h2 * 60 + m2;
            
            if (minutos2 > minutos1) {
                const duracionMinutos = minutos2 - minutos1;
                const duracionHoras = duracionMinutos / 60;
                
                duracionSpan.textContent = `${duracionHoras.toFixed(1)} horas`;
                resumenDiv.classList.remove('hidden');
            } else {
                resumenDiv.classList.add('hidden');
            }
        }
    }

    // Event listeners
    horaInicioInput.addEventListener('change', calcularDuracion);
    horaFinInput.addEventListener('change', calcularDuracion);
    
    // Calcular al cargar
    calcularDuracion();
});
</script>
@endpush
@endsection