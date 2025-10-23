@extends('layouts.admin')

@section('title', 'Gestión de Instalaciones')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Gestión de Instalaciones</h2>
            <p class="text-gray-600 mt-1">Administra las instalaciones disponibles para reserva</p>
        </div>
        <a href="{{ route('admin.instalaciones.create') }}" 
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Nueva Instalación
        </a>
    </div>
</div>

<!-- Estadísticas rápidas -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    @php
        $totalInstalaciones = \App\Models\Instalacion::count();
        $activas = \App\Models\Instalacion::where('activa', true)->count();
        $inactivas = \App\Models\Instalacion::where('activa', false)->count();
    @endphp

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Total</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalInstalaciones }}</p>
            </div>
            <div class="bg-indigo-100 rounded-full p-4">
                <i class="fas fa-building text-indigo-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Activas</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $activas }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-4">
                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Inactivas</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $inactivas }}</p>
            </div>
            <div class="bg-red-100 rounded-full p-4">
                <i class="fas fa-times-circle text-red-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Lista de instalaciones -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    @if($instalaciones->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-building text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 text-lg mb-4">No hay instalaciones creadas</p>
            <a href="{{ route('admin.instalaciones.create') }}" 
               class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition">
                <i class="fas fa-plus mr-2"></i>
                Crear Primera Instalación
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @foreach($instalaciones as $instalacion)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition {{ !$instalacion->activa ? 'opacity-60' : '' }}">
                    <!-- Imagen o placeholder -->
                    <div class="h-48 bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center">
                        @if($instalacion->imagen_url)
                            <img src="{{ $instalacion->imagen_url }}" alt="{{ $instalacion->nombre }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-building text-white text-6xl"></i>
                        @endif
                    </div>

                    <!-- Contenido -->
                    <div class="p-5">
                        <!-- Header con nombre y estado -->
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="text-xl font-bold text-gray-800 flex-1">{{ $instalacion->nombre }}</h3>
                            @if($instalacion->activa)
                                <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                    Activa
                                </span>
                            @else
                                <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                    Inactiva
                                </span>
                            @endif
                        </div>

                        <!-- Descripción -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $instalacion->descripcion ?? 'Sin descripción' }}
                        </p>

                        <!-- Información -->
                        <div class="grid grid-cols-2 gap-3 mb-4 text-sm">
                            <div class="flex items-center text-gray-700">
                                <i class="fas fa-users text-indigo-600 mr-2"></i>
                                <span>{{ $instalacion->capacidad }} personas</span>
                            </div>
                            <div class="flex items-center text-green-600 font-semibold">
                                <i class="fas fa-dollar-sign text-green-600 mr-2"></i>
                                <span>${{ number_format($instalacion->precio_hora, 0) }}/h</span>
                            </div>
                        </div>

                        <!-- Estadística de reservas -->
                        <div class="bg-gray-50 rounded-lg p-3 mb-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Reservas totales:</span>
                                <span class="font-bold text-gray-900">{{ $instalacion->reservas_count }}</span>
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="flex gap-2">
                            <a href="{{ route('admin.instalaciones.show', $instalacion->id) }}" 
                               class="flex-1 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium py-2 px-4 rounded-lg transition text-center text-sm">
                                <i class="fas fa-eye mr-1"></i> Ver
                            </a>
                            <a href="{{ route('admin.instalaciones.edit', $instalacion->id) }}" 
                               class="flex-1 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-2 px-4 rounded-lg transition text-center text-sm">
                                <i class="fas fa-edit mr-1"></i> Editar
                            </a>
                            
                            <!-- Toggle activa/inactiva -->
                            <form method="POST" action="{{ route('admin.instalaciones.toggle', $instalacion->id) }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-3 rounded-lg transition text-sm"
                                        title="{{ $instalacion->activa ? 'Desactivar' : 'Activar' }}">
                                    <i class="fas fa-power-off"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $instalaciones->links() }}
        </div>
    @endif
</div>
@endsection