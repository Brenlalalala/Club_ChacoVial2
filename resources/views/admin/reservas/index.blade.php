@extends('layouts.admin')

@section('title', 'Gestión de Reservas')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold text-gray-800">Gestión de Reservas</h2>
    <p class="text-gray-600 mt-1">Administra todas las solicitudes de reserva</p>
</div>

<!-- Filtros -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('admin.reservas.index') }}" class="flex flex-wrap gap-4">
        <!-- Filtro por estado -->
        <div class="flex-1 min-w-[200px]">
            <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
            <select name="estado" id="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Todos los estados</option>
                <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="aceptada" {{ request('estado') === 'aceptada' ? 'selected' : '' }}>Aceptada</option>
                <option value="cancelada" {{ request('estado') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>

        <!-- Filtro por fecha -->
        <div class="flex-1 min-w-[200px]">
            <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">Fecha de reserva</label>
            <input type="date" name="fecha" id="fecha" value="{{ request('fecha') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Filtro por instalación -->
        <div class="flex-1 min-w-[200px]">
            <label for="instalacion" class="block text-sm font-medium text-gray-700 mb-2">Instalación</label>
            <select name="instalacion" id="instalacion" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Todas las instalaciones</option>
                @foreach(\App\Models\Instalacion::all() as $inst)
                    <option value="{{ $inst->id }}" {{ request('instalacion') == $inst->id ? 'selected' : '' }}>
                        {{ $inst->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Botones -->
        <div class="flex items-end gap-2">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-filter mr-2"></i>Filtrar
            </button>
            <a href="{{ route('admin.reservas.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition">
                <i class="fas fa-redo mr-2"></i>Limpiar
            </a>
        </div>
    </form>
</div>

<!-- Tabla de reservas -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">
                Reservas 
                <span class="text-sm font-normal text-gray-500">({{ $reservas->total() }} en total)</span>
            </h3>
            
            <!-- Acciones rápidas -->
            <div class="flex gap-2">
                <button onclick="window.print()" class="text-gray-600 hover:text-gray-800 px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">
                    <i class="fas fa-print mr-1"></i>Imprimir
                </button>
            </div>
        </div>
    </div>

    @if($reservas->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg">No se encontraron reservas</p>
            <p class="text-gray-400 text-sm mt-2">Intenta cambiar los filtros de búsqueda</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Cliente</th>
                        <th class="px-6 py-4">Instalación</th>
                        <th class="px-6 py-4">Fecha y Hora</th>
                        <th class="px-6 py-4">Precio</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($reservas as $reserva)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm text-gray-600">#{{ str_pad($reserva->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $reserva->nombre_cliente }}</p>
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-envelope mr-1"></i>{{ $reserva->email_cliente }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-phone mr-1"></i>{{ $reserva->telefono_cliente }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <i class="fas fa-building text-indigo-600 mr-2"></i>
                                    <span class="text-gray-900">{{ $reserva->instalacion->nombre }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">
                                        <i class="far fa-calendar mr-1"></i>{{ $reserva->fecha_inicio->format('d/m/Y') }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        <i class="far fa-clock mr-1"></i>{{ $reserva->fecha_inicio->format('H:i') }} - {{ $reserva->fecha_fin->format('H:i') }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $reserva->horas_reserva }}h</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-green-600">${{ number_format($reserva->precio_total, 2) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($reserva->estado === 'pendiente')
                                    <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                        <i class="fas fa-clock mr-1"></i>Pendiente
                                    </span>
                                @elseif($reserva->estado === 'aceptada')
                                    <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                        <i class="fas fa-check-circle mr-1"></i>Aceptada
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                        <i class="fas fa-times-circle mr-1"></i>Cancelada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Ver detalle -->
                                    <a href="{{ route('admin.reservas.show', $reserva->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-800 transition" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if($reserva->estado === 'pendiente')
                                        <!-- Confirmar -->
                                        <form method="POST" action="{{ route('admin.reservas.confirmar', $reserva->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="text-green-600 hover:text-green-800 transition" 
                                                    title="Confirmar reserva"
                                                    onclick="return confirm('¿Confirmar esta reserva?')">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        </form>

                                        <!-- Cancelar -->
                                        <button onclick="mostrarModalCancelar({{ $reserva->id }})" 
                                                class="text-red-600 hover:text-red-800 transition" 
                                                title="Cancelar reserva">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    @endif

                                    @if($reserva->estado === 'aceptada')
                                        <!-- Editar -->
                                        <a href="{{ route('admin.reservas.edit', $reserva->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 transition" 
                                           title="Editar reserva">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $reservas->links() }}
        </div>
    @endif
</div>

<!-- Modal para cancelar -->
<div id="modalCancelar" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Cancelar Reserva</h3>
            <form id="formCancelar" method="POST">
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
function mostrarModalCancelar(reservaId) {
    const modal = document.getElementById('modalCancelar');
    const form = document.getElementById('formCancelar');
    form.action = `/admin/reservas/${reservaId}/cancelar`;
    modal.classList.remove('hidden');
}

function cerrarModalCancelar() {
    const modal = document.getElementById('modalCancelar');
    modal.classList.add('hidden');
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