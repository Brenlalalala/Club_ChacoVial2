@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 md:p-8 mt-4 md:mt-20 max-w-4xl">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-indigo-800 tracking-tight sm:text-5xl">Realizar una Reserva</h1>
        <p class="mt-4 text-lg text-gray-600">Completa el formulario para reservar tu turno en nuestras instalaciones.</p>
    </div>

    <!-- Mensajes de error -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <strong class="font-bold">¡Atención!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-8 rounded-xl shadow-lg">
        <form action="{{ route('reservas.store') }}" method="POST" id="reservaForm">
            @csrf
            
            <!-- Selector o información de instalación -->
            @if(isset($instalacion))
                <!-- Si viene una instalación específica, mostrar info y campo oculto -->
                <input type="hidden" name="instalacion_id" value="{{ $instalacion->id }}" id="instalacion_id_hidden">
                
                <div class="bg-indigo-50 p-4 rounded-lg mb-6 border border-indigo-200">
                    <h3 class="text-xl font-bold text-indigo-900 mb-2">{{ $instalacion->nombre }}</h3>
                    <p class="text-gray-700 mb-2">{{ $instalacion->descripcion }}</p>
                    <div class="flex flex-wrap gap-4 text-sm">
                        <span class="text-gray-600"><strong>Capacidad:</strong> {{ $instalacion->capacidad }} personas</span>
                        <span class="text-green-600 font-semibold"><strong>Precio:</strong> ${{ number_format($instalacion->precio_hora, 2) }}/hora</span>
                    </div>
                </div>
            @else
                <!-- Si no viene instalación, mostrar selector -->
                <div class="mb-6">
                    <label for="instalacion_id" class="block text-base font-semibold text-gray-800 mb-2">
                        Instalación a Reservar: <span class="text-red-500">*</span>
                    </label>
                    <select name="instalacion_id" id="instalacion_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        <option value="">-- Selecciona una instalación --</option>
                        @if(isset($instalaciones))
                            @foreach($instalaciones as $inst)
                                <option value="{{ $inst->id }}" 
                                        data-precio="{{ $inst->precio_hora }}" 
                                        data-capacidad="{{ $inst->capacidad }}"
                                        data-descripcion="{{ $inst->descripcion }}"
                                        {{ old('instalacion_id') == $inst->id ? 'selected' : '' }}>
                                    {{ $inst->nombre }} - ${{ number_format($inst->precio_hora, 2) }}/hora
                                </option>
                            @endforeach
                        @endif
                    </select>
                    
                    <!-- Info dinámica de la instalación seleccionada -->
                    <div id="instalacion-info" class="hidden mt-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h4 class="font-bold text-gray-800 mb-2" id="info-nombre"></h4>
                        <p class="text-gray-600 text-sm mb-2" id="info-descripcion"></p>
                        <div class="flex gap-4 text-sm">
                            <span class="text-gray-600"><strong>Capacidad:</strong> <span id="info-capacidad"></span> personas</span>
                            <span class="text-green-600 font-semibold"><strong>Precio:</strong> $<span id="info-precio"></span>/hora</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Datos del Cliente -->
            <div class="border-t border-gray-200 pt-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Datos de Contacto</h3>
                
                <div class="mb-5">
                    <label for="nombre_cliente" class="block text-base font-semibold text-gray-800 mb-2">Nombre Completo: <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre_cliente" id="nombre_cliente" value="{{ old('nombre_cliente') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Ej: Juan Pérez" required>
                </div>

                <div class="flex flex-col md:flex-row gap-5 mb-5">
                    <div class="w-full md:w-1/2">
                        <label for="email_cliente" class="block text-base font-semibold text-gray-800 mb-2">Email: <span class="text-red-500">*</span></label>
                        <input type="email" name="email_cliente" id="email_cliente" value="{{ old('email_cliente') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="correo@ejemplo.com" required>
                        <p class="text-xs text-gray-500 mt-1">Recibirás la confirmación aquí</p>
                    </div>
                    <div class="w-full md:w-1/2">
                        <label for="telefono_cliente" class="block text-base font-semibold text-gray-800 mb-2">Teléfono/WhatsApp: <span class="text-red-500">*</span></label>
                        <input type="tel" name="telefono_cliente" id="telefono_cliente" value="{{ old('telefono_cliente') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Ej: 362-4123456" required>
                    </div>
                </div>
            </div>

            <!-- Fecha y Hora -->
            <div class="border-t border-gray-200 pt-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Fecha y Horario</h3>
                
                <div class="flex flex-col md:flex-row gap-5 mb-5">
                    <div class="w-full md:w-1/3">
                        <label for="fecha" class="block text-base font-semibold text-gray-800 mb-2">Fecha: <span class="text-red-500">*</span></label>
                        <input type="date" name="fecha" id="fecha" value="{{ old('fecha') }}" min="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                    <div class="w-full md:w-1/3">
                        <label for="hora_inicio" class="block text-base font-semibold text-gray-800 mb-2">Hora Inicio: <span class="text-red-500">*</span></label>
                        <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                    <div class="w-full md:w-1/3">
                        <label for="hora_fin" class="block text-base font-semibold text-gray-800 mb-2">Hora Fin: <span class="text-red-500">*</span></label>
                        <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                </div>

                <!-- Campos ocultos para datetime -->
                <input type="hidden" name="fecha_inicio" id="fecha_inicio">
                <input type="hidden" name="fecha_fin" id="fecha_fin">

                <!-- Mensaje de disponibilidad -->
                <div id="disponibilidadMensaje" class="hidden p-3 rounded-lg mb-4"></div>

                <!-- Resumen de precio -->
                <div id="resumenPrecio" class="bg-gray-50 p-4 rounded-lg hidden">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-700 font-medium">Duración:</span>
                        <span id="duracionHoras" class="text-gray-900 font-bold">-- horas</span>
                    </div>
                    <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-300">
                        <span class="text-lg font-bold text-gray-800">Total estimado:</span>
                        <span id="precioTotal" class="text-2xl font-bold text-green-600">$0.00</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">* El precio final será confirmado por el administrador</p>
                </div>
            </div>

            <!-- Comentarios -->
            <div class="mb-6">
                <label for="comentarios" class="block text-base font-semibold text-gray-800 mb-2">Comentarios o Solicitudes Especiales:</label>
                <textarea name="comentarios" id="comentarios" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Ej: Necesito proyector, música, etc.">{{ old('comentarios') }}</textarea>
            </div>

            <!-- Términos y condiciones -->
            <div class="mb-6">
                <label class="flex items-start">
                    <input type="checkbox" name="acepta_terminos" id="acepta_terminos" class="mt-1 mr-2" required>
                    <span class="text-sm text-gray-700">
                        Acepto los <a href="#" class="text-indigo-600 hover:underline">términos y condiciones</a> y entiendo que la reserva quedará pendiente de confirmación por el administrador.
                    </span>
                </label>
            </div>

            <!-- Botones -->
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" id="btnSubmit" class="flex-1 bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed">
                    <span id="btnText">Enviar Solicitud de Reserva</span>
                    <span id="btnLoading" class="hidden">Verificando disponibilidad...</span>
                </button>
                <a href="{{ url()->previous() }}" class="flex-1 sm:flex-none bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition-colors duration-200 text-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Información adicional -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-bold text-blue-900 mb-3">📋 Información Importante</h3>
        <ul class="space-y-2 text-sm text-blue-800">
            <li class="flex items-start">
                <span class="mr-2">•</span>
                <span>Tu reserva quedará en estado <strong>PENDIENTE</strong> hasta que el administrador la confirme.</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2">•</span>
                <span>Recibirás un email de confirmación cuando tu reserva sea aprobada.</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2">•</span>
                <span>Para cancelaciones, contacta al administrador por WhatsApp o email.</span>
            </li>
            <li class="flex items-start">
                <span class="mr-2">•</span>
                <span>El pago se coordina directamente con el club una vez confirmada la reserva.</span>
            </li>
        </ul>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reservaForm');
    const fechaInput = document.getElementById('fecha');
    const horaInicioInput = document.getElementById('hora_inicio');
    const horaFinInput = document.getElementById('hora_fin');
    const instalacionSelect = document.getElementById('instalacion_id');
    const disponibilidadDiv = document.getElementById('disponibilidadMensaje');
    const resumenDiv = document.getElementById('resumenPrecio');
    const duracionSpan = document.getElementById('duracionHoras');
    const precioSpan = document.getElementById('precioTotal');
    const btnSubmit = document.getElementById('btnSubmit');
    
    // Elementos para mostrar info de instalación seleccionada
    const instalacionInfo = document.getElementById('instalacion-info');
    const infoNombre = document.getElementById('info-nombre');
    const infoDescripcion = document.getElementById('info-descripcion');
    const infoCapacidad = document.getElementById('info-capacidad');
    const infoPrecio = document.getElementById('info-precio');
    
    let precioHora = {{ $instalacion->precio_hora ?? 0 }};
    
    // Si hay select de instalación, configurar eventos
    if (instalacionSelect) {
        instalacionSelect.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            
            if (this.value) {
                // Actualizar precio
                precioHora = parseFloat(option.dataset.precio) || 0;
                
                // Mostrar información de la instalación
                if (instalacionInfo) {
                    infoNombre.textContent = option.text.split(' - ')[0];
                    infoDescripcion.textContent = option.dataset.descripcion || '';
                    infoCapacidad.textContent = option.dataset.capacidad || '';
                    infoPrecio.textContent = parseFloat(option.dataset.precio).toFixed(2);
                    instalacionInfo.classList.remove('hidden');
                }
                
                // Recalcular precio si ya hay horarios seleccionados
                calcularPrecio();
                
                // Habilitar campos de fecha/hora
                fechaInput.disabled = false;
                horaInicioInput.disabled = false;
                horaFinInput.disabled = false;
            } else {
                // Ocultar info y deshabilitar campos
                if (instalacionInfo) {
                    instalacionInfo.classList.add('hidden');
                }
                resumenDiv.classList.add('hidden');
                disponibilidadDiv.classList.add('hidden');
                
                fechaInput.disabled = true;
                horaInicioInput.disabled = true;
                horaFinInput.disabled = true;
            }
        });
        
        // Inicializar: deshabilitar campos si no hay instalación seleccionada
        if (!instalacionSelect.value) {
            fechaInput.disabled = true;
            horaInicioInput.disabled = true;
            horaFinInput.disabled = true;
        } else {
            // Si hay valor seleccionado (por old() o por defecto), inicializar precio
            const option = instalacionSelect.options[instalacionSelect.selectedIndex];
            precioHora = parseFloat(option.dataset.precio) || 0;
        }
    }

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
        
        console.log('Fecha inicio:', document.getElementById('fecha_inicio').value);
        console.log('Fecha fin:', document.getElementById('fecha_fin').value);
    });

    // Calcular precio y verificar disponibilidad
    function calcularPrecio() {
        const horaInicio = horaInicioInput.value;
        const horaFin = horaFinInput.value;
        
        if (horaInicio && horaFin) {
            const [h1, m1] = horaInicio.split(':').map(Number);
            const [h2, m2] = horaFin.split(':').map(Number);
            
            const minutos1 = h1 * 60 + m1;
            const minutos2 = h2 * 60 + m2;
            
            if (minutos2 <= minutos1) {
                mostrarError('La hora de fin debe ser posterior a la hora de inicio');
                resumenDiv.classList.add('hidden');
                return;
            }
            
            const duracionMinutos = minutos2 - minutos1;
            const duracionHoras = duracionMinutos / 60;
            const precioTotal = duracionHoras * precioHora;
            
            duracionSpan.textContent = `${duracionHoras.toFixed(1)} horas`;
            precioSpan.textContent = `$${precioTotal.toFixed(2)}`;
            resumenDiv.classList.remove('hidden');
            
            verificarDisponibilidad();
        }
    }

    // Verificar disponibilidad con AJAX
    function verificarDisponibilidad() {
        const instalacionId = instalacionSelect ? instalacionSelect.value : {{ $instalacion->id ?? 'null' }};
        const fecha = fechaInput.value;
        const horaInicio = horaInicioInput.value;
        const horaFin = horaFinInput.value;
        
        if (!instalacionId || !fecha || !horaInicio || !horaFin) return;
        
        const fechaInicio = `${fecha} ${horaInicio}:00`;
        const fechaFin = `${fecha} ${horaFin}:00`;
        
        fetch('{{ route("reservas.verificar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                instalacion_id: instalacionId,
                fecha_inicio: fechaInicio,
                fecha_fin: fechaFin
            })
        })
        .then(response => response.json())
        .then(data => {
            disponibilidadDiv.classList.remove('hidden');
            if (data.disponible) {
                disponibilidadDiv.className = 'bg-green-100 border border-green-400 text-green-700 p-3 rounded-lg mb-4';
                disponibilidadDiv.innerHTML = '✓ ' + data.mensaje;
                btnSubmit.disabled = false;
            } else {
                disponibilidadDiv.className = 'bg-red-100 border border-red-400 text-red-700 p-3 rounded-lg mb-4';
                disponibilidadDiv.innerHTML = '✗ ' + data.mensaje;
                btnSubmit.disabled = true;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function mostrarError(mensaje) {
        disponibilidadDiv.classList.remove('hidden');
        disponibilidadDiv.className = 'bg-red-100 border border-red-400 text-red-700 p-3 rounded-lg mb-4';
        disponibilidadDiv.textContent = mensaje;
    }

    // Event listeners
    horaInicioInput.addEventListener('change', calcularPrecio);
    horaFinInput.addEventListener('change', calcularPrecio);
    fechaInput.addEventListener('change', calcularPrecio);
});
</script>
@endpush
@endsection