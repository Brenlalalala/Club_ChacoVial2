@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold text-gray-800">¡Bienvenido de vuelta!</h2>
    <p class="text-gray-600 mt-1">Resumen general del sistema</p>
</div>

<!-- Tarjetas de estadísticas -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Reservas Pendientes -->
    @php
        $pendientes = \App\Models\Reserva::where('estado', 'pendiente')->count();
        $aceptadas = \App\Models\Reserva::where('estado', 'aceptada')->count();
        $canceladas = \App\Models\Reserva::where('estado', 'cancelada')->count();
        $totalReservas = \App\Models\Reserva::count();
    @endphp

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Pendientes</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $pendientes }}</p>
            </div>
            <div class="bg-yellow-100 rounded-full p-4">
                <i class="fas fa-clock text-yellow-600 text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('admin.reservas.index', ['estado' => 'pendiente']) }}" class="text-yellow-600 text-sm mt-4 inline-block hover:underline">
            Ver reservas →
        </a>
    </div>

    <!-- Reservas Aceptadas -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Aceptadas</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $aceptadas }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-4">
                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('admin.reservas.index', ['estado' => 'aceptada']) }}" class="text-green-600 text-sm mt-4 inline-block hover:underline">
            Ver reservas →
        </a>
    </div>

    <!-- Reservas Canceladas -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Canceladas</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $canceladas }}</p>
            </div>
            <div class="bg-red-100 rounded-full p-4">
                <i class="fas fa-times-circle text-red-600 text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('admin.reservas.index', ['estado' => 'cancelada']) }}" class="text-red-600 text-sm mt-4 inline-block hover:underline">
            Ver reservas →
        </a>
    </div>

    <!-- Total Reservas -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium">Total</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalReservas }}</p>
            </div>
            <div class="bg-indigo-100 rounded-full p-4">
                <i class="fas fa-calendar-alt text-indigo-600 text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('admin.reservas.index') }}" class="text-indigo-600 text-sm mt-4 inline-block hover:underline">
            Ver todas →
        </a>
    </div>
</div>

<!-- Reservas recientes -->
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-gray-800">Reservas Recientes</h3>
        <a href="{{ route('admin.reservas.index') }}" class="text-indigo-600 hover:underline text-sm">
            Ver todas →
        </a>
    </div>

    @php
        $reservasRecientes = \App\Models\Reserva::with('instalacion')
            ->latest()
            ->take(5)
            ->get();
    @endphp

    @if($reservasRecientes->isEmpty())
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-inbox text-4xl mb-3"></i>
            <p>No hay reservas aún</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 text-left text-sm text-gray-600">
                        <th class="pb-3 font-semibold">Cliente</th>
                        <th class="pb-3 font-semibold">Instalación</th>
                        <th class="pb-3 font-semibold">Fecha</th>
                        <th class="pb-3 font-semibold">Estado</th>
                        <th class="pb-3 font-semibold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservasRecientes as $reserva)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-4">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $reserva->nombre_cliente }}</p>
                                    <p class="text-sm text-gray-500">{{ $reserva->email_cliente }}</p>
                                </div>
                            </td>
                            <td class="py-4 text-gray-700">{{ $reserva->instalacion->nombre }}</td>
                            <td class="py-4 text-gray-700">{{ $reserva->fecha_inicio->format('d/m/Y H:i') }}</td>
                            <td class="py-4">
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
                            </td>
                            <td class="py-4 text-right">
                                <a href="{{ route('admin.reservas.show', $reserva->id) }}" 
                                   class="text-indigo-600 hover:text-indigo-800">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection