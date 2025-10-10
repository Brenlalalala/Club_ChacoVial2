@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 md:p-8 mt-4 md:mt-20 max-w-4xl">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-indigo-800 tracking-tight sm:text-5xl">Realizar una Reserva</h1>
        <p class="mt-4 text-lg text-gray-600">Completa el formulario para reservar tu turno en nuestras instalaciones.</p>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-lg">
        <form action="{{ route('reservas.guardar') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label for="nombre" class="block text-base font-semibold text-gray-800 mb-2">Nombre Completo:</label>
                <input type="text" name="nombre" id="nombre" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <div class="mb-5">
                <label for="instalacion" class="block text-base font-semibold text-gray-800 mb-2">Instalación a Reservar:</label>
                <select name="instalacion" id="instalacion" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <option value="">-- Selecciona una opción --</option>
                    <option value="cancha-futbol">Cancha de Fútbol</option>
                    <option value="cancha-tenis">Cancha de Tenis</option>
                    <option value="gimnasio">Gimnasio</option>
                    <option value="quincho">Quincho</option>
                </select>
            </div>

            <div class="flex flex-col md:flex-row gap-5 mb-5">
                <div class="w-full md:w-1/2">
                    <label for="fecha" class="block text-base font-semibold text-gray-800 mb-2">Fecha:</label>
                    <input type="date" name="fecha" id="fecha" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="w-full md:w-1/2">
                    <label for="hora" class="block text-base font-semibold text-gray-800 mb-2">Hora:</label>
                    <input type="time" name="hora" id="hora" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
            </div>

            <div class="mb-6">
                <label for="comentarios" class="block text-base font-semibold text-gray-800 mb-2">Comentarios (opcional):</label>
                <textarea name="comentarios" id="comentarios" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                    Confirmar Reserva
                </button>
            </div>
        </form>
    </div>
</div>
@endsection