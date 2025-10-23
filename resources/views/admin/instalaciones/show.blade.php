@extends('layouts.admin')

@section('title', 'Detalle de Instalación')

@section('content')
<!-- Breadcrumb y acciones -->
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.instalaciones.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm mb-2 inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Volver a la lista
            </a>
            <h2 class="text-3xl font-bold text-gray-800">{{ $instalacion->nombre }}</h2>
            <p class="text-gray-600 mt-1">Información detallada de la instalación</p>
        </div>

        <!-- Estado badge -->
        <div>
            @if($instalacion->activa)
                <span class="inline-flex items-center px-6 py-3 bg-green-100 text-green-800 rounded-lg text-lg font-bold">
                    <i class="fas fa-check-circle mr-2"></i>ACTIVA
                </span>
            @else
                <span class="inline-flex items-center px-6 py-3 bg-red-100 text-red-800 rounded-lg text-lg font-bold">
                    <i class="fas fa-times-circle mr-2"></i>INACTIVA
                </span>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Columna principal -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Imagen -->
        @if($instalacion->imagen_url)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="{{ $instalacion->imagen_url }}" alt="{{ $instalacion->nombre }}" class="w-full h-64 object-cover">
        </div>
        @endif

        <!-- Información general -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-info-circle text-indigo-600 mr-2"></i>
                Información General
            </h3>

            <div class="space-y-4">
                <!-- Descripción -->
                <div>
                    <label class="text-sm font-semibold text-gray-600">Descripción</label>
                    @if($instalacion->descripcion)
                        <p class="text-gray-800 mt-1">{{ $instalacion->descripcion }}</p>
                    @else
                        <p class="text-gray-400 italic mt-1">Sin descripción</p>
                    @endif
                </div>

                <hr class="border-gray-200">

                <!-- Detalles en grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Capacidad -->
                    <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-indigo-600 font-medium mb-1">Capacidad</p>
                                <p class="text-2xl font-bold text-indigo-900">{{ $instalacion->capacidad }}</p>
                                <p class="text-xs text-indigo-700 mt-1">personas</p>
                            </div>
                            <i class="fas fa-users text-3xl text-indigo-400"></i>
                        </div>
                    </div>

                    <!-- Precio -->
                    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-green-600 font-medium mb-1">Precio/Hora</p>
                                <p class="text-2xl font-bold text-green-900">${{ number_format($instalacion->precio_hora, 2) }}</p>
                                <p class="text-xs text-green-700 mt-1">por hora</p>
                            </div>
                            <i class="fas fa-dollar-sign text-3xl text-green-400"></i>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 font-medium mb-1">Estado</p>
                                @if($instalacion->activa)
                                    <p class="text-2xl font-bold text-green-600">Activa</p>
                                    <p class="text-xs text-gray-600 mt-1">Disponible</p>
                                @else
                                    <p class="text-2xl font-bold text-red-600">Inactiva</p>
                                    <p class="text-xs text-gray-600 mt-1">No disponible</p>
                                @endif
                            </div>
                            <i class="fas fa-toggle-{{ $instalacion->activa ? 'on' : 'off' }} text-3xl text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas de reservas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-chart-bar text-indigo-600 mr-2"></i>
                Estadísticas de Reservas
            </h3>

            @php
                $totalReservas = $instalacion->reservas->count();
                $pendientes = $instalacion->reservas->where('estado', 'pendiente')->count();
                $aceptadas = $instalacion->reservas->where('estado', 'aceptada')->count();
                $canceladas = $instalacion->reservas->where('estado', 'cancelada')->count();
                $ingresoTotal = $instalacion->reservas->where('estado', 'aceptada')->sum('precio_total');
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-3xl font-bold text-gray-900">{{ $totalReservas }}</p>
                    <p class="text-sm text-gray-600 mt-1">Total</p>
                </div>
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <p class="text-3xl font-bold text-yellow-600">{{ $pendientes }}</p>
                    <p class="text-sm text-gray-600 mt-1">Pendientes</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-3xl font-bold text-green-600">{{ $aceptadas }}</p>
                    <p class="text-sm text-gray-600 mt-1">Aceptadas</p>
                </div>
                <div class="text-center p-4 bg-red-50 rounded-lg">
                    <p class="text-3xl font-bold text-red-600">{{ $canceladas }}</p>
                    <p class="text-sm text-gray-600 mt-1">Canceladas</p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                <div class="flex items-center justify-between">
                    <span class="text-green-800 font-semibold">Ingresos Totales (Aceptadas):</span>
                    <span class="text-2xl font-bold text-green-900">${{ number_format($ingresoTotal, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Reservas recientes -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-calendar-check text-indigo-600 mr-2"></i>
                    Reservas Recientes
                </h3>
                <a href="{{ route('admin.reservas.index', ['instalacion' => $instalacion->id]) }}" class="text-indigo-600 hover:underline text-sm">
                    Ver todas →
                </a>
            </div>

            @if($reservasRecientes->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-3"></i>
                    <p>No hay reservas para esta instalación</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($reservasRecientes as $reserva)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $reserva->nombre_cliente }}</p>
                                    <p class="text-sm text-gray-600">{{ $reserva->email_cliente }}</p>
                                </div>
                                @if($reserva->estado === 'pendiente')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                        Pendiente
                                    </span>
                                @elseif($reserva->estado === 'aceptada')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                        Aceptada
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                        Cancelada
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="text-gray-600">
                                    <i class="far fa-calendar mr-1"></i>
                                    {{ $reserva->fecha_inicio->format('d/m/Y') }} · 
                                    {{ $reserva->fecha_inicio->format('H:i') }} - {{ $reserva->fecha_fin->format('H:i') }}
                                </div>
                                <a href="{{ route('admin.reservas.show', $reserva->id) }}" class="text-indigo-600 hover:text-indigo-800">
                                    Ver detalle →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Columna lateral -->
    <div class="space-y-6">
        <!-- Acciones rápidas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Acciones</h3>
            
            <div class="space-y-3">
                <a href="{{ route('admin.instalaciones.edit', $instalacion->id) }}" 
                   class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition text-center">
                    <i class="fas fa-edit mr-2"></i>
                    Editar Instalación
                </a>

                <form method="POST" action="{{ route('admin.instalaciones.toggle', $instalacion->id) }}">
                    @csrf
                    @if($instalacion->activa)
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition">
                            <i class="fas fa-toggle-off mr-2"></i>
                            Desactivar
                        </button>
                    @else
                        <button type="submit" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition">
                            <i class="fas fa-toggle-on mr-2"></i>
                            Activar
                        </button>
                    @endif
                </form>

                <a href="{{ route('reservas.create', $instalacion->id) }}" 
                   target="_blank"
                   class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition text-center text-sm">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Ver en sitio público
                </a>
            </div>
        </div>

        <!-- Información del sistema -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Información del Sistema</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">ID:</span>
                    <span class="font-mono font-medium text-gray-900">#{{ $instalacion->id }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">Creada:</span>
                    <span class="text-gray-900">{{ $instalacion->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">Modificada:</span>
                    <span class="text-gray-900">{{ $instalacion->updated_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Total Reservas:</span>
                    <span class="font-bold text-indigo-600">{{ $instalacion->reservas_count }}</span>
                </div>
            </div>
        </div>

        <!-- Simulador de precios -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Simulador de Precios</h3>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">1 hora:</span>
                    <span class="font-bold text-green-600">${{ number_format($instalacion->precio_hora * 1, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">2 horas:</span>
                    <span class="font-bold text-green-600">${{ number_format($instalacion->precio_hora * 2, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">3 horas:</span>
                    <span class="font-bold text-green-600">${{ number_format($instalacion->precio_hora * 3, 2) }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">4 horas:</span>
                    <span class="font-bold text-green-600">${{ number_format($instalacion->precio_hora * 4, 2) }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Día completo (8h):</span>
                    <span class="font-bold text-green-600">${{ number_format($instalacion->precio_hora * 8, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Zona peligrosa -->
        @if($instalacion->reservas->count() == 0)
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <h3 class="font-bold text-red-900 mb-3 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Zona Peligrosa
            </h3>
            <p class="text-sm text-red-800 mb-3">Eliminar esta instalación es permanente.</p>
            <form method="POST" action="{{ route('admin.instalaciones.destroy', $instalacion->id) }}" onsubmit="return confirm('¿Estás completamente seguro? Esta acción NO se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition text-sm">
                    <i class="fas fa-trash mr-2"></i>
                    Eliminar Instalación
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection