@extends('layouts.admin')

@section('title', 'Editar Instalación')

@section('content')
<!-- Breadcrumb -->
<div class="mb-6">
    <a href="{{ route('admin.instalaciones.show', $instalacion->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm mb-2 inline-block">
        <i class="fas fa-arrow-left mr-1"></i> Volver al detalle
    </a>
    <h2 class="text-3xl font-bold text-gray-800">Editar Instalación</h2>
    <p class="text-gray-600 mt-1">Modifica la información de {{ $instalacion->nombre }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Formulario principal -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('admin.instalaciones.update', $instalacion->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nombre -->
                <div class="mb-6">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre de la Instalación <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nombre" 
                           id="nombre" 
                           value="{{ old('nombre', $instalacion->nombre) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nombre') border-red-500 @enderror"
                           placeholder="Ej: Cancha de Fútbol 5"
                           required>
                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="mb-6">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                        Descripción
                    </label>
                    <textarea name="descripcion" 
                              id="descripcion" 
                              rows="4" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('descripcion') border-red-500 @enderror"
                              placeholder="Describe las características, equipamiento y facilidades de la instalación...">{{ old('descripcion', $instalacion->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Capacidad y Precio -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Capacidad -->
                    <div>
                        <label for="capacidad" class="block text-sm font-medium text-gray-700 mb-2">
                            Capacidad (personas) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" 
                                   name="capacidad" 
                                   id="capacidad" 
                                   value="{{ old('capacidad', $instalacion->capacidad) }}"
                                   min="1"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('capacidad') border-red-500 @enderror"
                                   required>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        @error('capacidad')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Precio por hora -->
                    <div>
                        <label for="precio_hora" class="block text-sm font-medium text-gray-700 mb-2">
                            Precio por Hora <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                            <input type="number" 
                                   name="precio_hora" 
                                   id="precio_hora" 
                                   value="{{ old('precio_hora', $instalacion->precio_hora) }}"
                                   step="0.01"
                                   min="0"
                                   class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('precio_hora') border-red-500 @enderror"
                                   required>
                        </div>
                        @error('precio_hora')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Precio anterior: ${{ number_format($instalacion->precio_hora, 2) }}</p>
                    </div>
                </div>

                <!-- Imagen actual y nueva -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Imagen de la Instalación
                    </label>
                    
                    @if($instalacion->imagen_url)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Imagen actual:</p>
                            <div class="relative inline-block">
                                <img src="{{ asset($instalacion->imagen_url) }}" 
                                     alt="{{ $instalacion->nombre }}" 
                                     class="w-full max-w-md h-48 object-cover rounded-lg border border-gray-300">
                            </div>
                            <form method="POST" action="{{ route('admin.instalaciones.eliminar-imagen', $instalacion->id) }}" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('¿Eliminar la imagen actual?')"
                                        class="text-red-600 hover:text-red-800 text-sm">
                                    <i class="fas fa-trash mr-1"></i>Eliminar imagen actual
                                </button>
                            </form>
                        </div>
                    @endif
                    
                    <div class="flex items-center gap-4">
                        <!-- Botón personalizado -->
                        <label for="imagen" class="cursor-pointer bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium py-2 px-4 rounded-lg transition inline-flex items-center">
                            <i class="fas fa-upload mr-2"></i>
                            {{ $instalacion->imagen_url ? 'Cambiar Imagen' : 'Seleccionar Imagen' }}
                        </label>
                        
                        <!-- Input oculto -->
                        <input type="file" 
                               name="imagen" 
                               id="imagen" 
                               accept="image/*"
                               class="hidden"
                               onchange="previewImage(event)">
                        
                        <!-- Nombre del archivo -->
                        <span id="file-name" class="text-sm text-gray-600 italic">Ningún archivo seleccionado</span>
                    </div>
                    
                    @error('imagen')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        @if($instalacion->imagen_url)
                            Sube una nueva imagen para reemplazar la actual
                        @else
                            Sube una imagen (JPG, PNG, GIF. Máximo 2MB)
                        @endif
                    </p>
                    
                    <!-- Vista previa de nueva imagen -->
                    <div id="preview-container" class="hidden mt-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">Vista previa de nueva imagen:</p>
                        <img id="preview-image" src="" alt="Preview" class="w-full max-w-md h-48 object-cover rounded-lg border border-gray-300">
                    </div>
                </div>

                <!-- Estado activa -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="activa" 
                               id="activa" 
                               value="1"
                               {{ old('activa', $instalacion->activa) ? 'checked' : '' }}
                               class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-3 text-sm font-medium text-gray-700">
                            Instalación activa y disponible para reservas
                        </span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 ml-8">Si está desactivada, no aparecerá en el formulario de reservas</p>
                </div>

                <!-- Botones de acción -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Cambios
                    </button>
                    <a href="{{ route('admin.instalaciones.show', $instalacion->id) }}" 
                       class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-6 rounded-lg transition text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Columna lateral -->
    <div class="space-y-6">
        <!-- Advertencia sobre reservas existentes -->
        @php
            $reservasFuturas = $instalacion->reservas()
                ->where('fecha_inicio', '>=', now())
                ->where('estado', '!=', 'cancelada')
                ->count();
        @endphp

        @if($reservasFuturas > 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <h3 class="font-bold text-yellow-900 mb-2 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Atención
            </h3>
            <p class="text-sm text-yellow-800">
                Esta instalación tiene <strong>{{ $reservasFuturas }} reserva(s) futura(s)</strong>. Los cambios de precio no afectarán las reservas existentes.
            </p>
        </div>
        @endif

        <!-- Información del sistema -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="font-bold text-gray-800 mb-3">Información</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">ID:</span>
                    <span class="font-mono font-medium text-gray-900">#{{ $instalacion->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Creada:</span>
                    <span class="text-gray-900">{{ $instalacion->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Modificada:</span>
                    <span class="text-gray-900">{{ $instalacion->updated_at->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total reservas:</span>
                    <span class="font-bold text-indigo-600">{{ $instalacion->reservas->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Vista previa del precio -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="font-bold text-gray-800 mb-4">Vista Previa de Precios</h3>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">1 hora:</span>
                    <span id="precio_1h" class="font-bold text-green-600">$0.00</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">2 horas:</span>
                    <span id="precio_2h" class="font-bold text-green-600">$0.00</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">3 horas:</span>
                    <span id="precio_3h" class="font-bold text-green-600">$0.00</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">4 horas:</span>
                    <span id="precio_4h" class="font-bold text-green-600">$0.00</span>
                </div>
            </div>
        </div>

        <!-- Eliminar instalación -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="font-bold text-red-700 mb-3">Zona Peligrosa</h3>
            <p class="text-sm text-gray-600 mb-3">Eliminar esta instalación es permanente y no se puede deshacer.</p>
            
            @if($instalacion->reservas->count() > 0)
                <button disabled class="w-full bg-gray-300 text-gray-500 font-medium py-2 px-4 rounded-lg cursor-not-allowed">
                    <i class="fas fa-trash mr-2"></i>
                    No se puede eliminar
                </button>
                <p class="text-xs text-gray-500 mt-2">Tiene reservas asociadas</p>
            @else
                <form method="POST" action="{{ route('admin.instalaciones.destroy', $instalacion->id) }}" onsubmit="return confirm('¿Estás seguro? Esta acción no se puede deshacer.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">
                        <i class="fas fa-trash mr-2"></i>
                        Eliminar Instalación
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const precioInput = document.getElementById('precio_hora');
    
    function actualizarVistaPrecio() {
        const precio = parseFloat(precioInput.value) || 0;
        
  document.getElementById('precio_1h').textContent = '$' + (precio * 1).toFixed(2);
document.getElementById('precio_2h').textContent = '$' + (precio * 2).toFixed(2);
document.getElementById('precio_3h').textContent = '$' + (precio * 3).toFixed(2);
document.getElementById('precio_4h').textContent = '$' + (precio * 4).toFixed(2);
    }
    
    precioInput.addEventListener('input', actualizarVistaPrecio);
    actualizarVistaPrecio();
});

// Vista previa de imagen
function previewImage(event) {
    const reader = new FileReader();
    const preview = document.getElementById('preview-image');
    const container = document.getElementById('preview-container');
    
    reader.onload = function() {
        preview.src = reader.result;
        container.classList.remove('hidden');
    };
    
    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    } else {
        container.classList.add('hidden');
    }
}
</script>
@endpush
@endsection