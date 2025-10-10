@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 md:p-8 mt-4 md:mt-20 max-w-lg">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-indigo-800 tracking-tight sm:text-5xl">Acceso de Administrador</h1>
        <p class="mt-4 text-lg text-gray-600">Por favor, ingresa tus credenciales.</p>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-lg">
        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label for="email" class="block text-base font-semibold text-gray-800 mb-2">Correo Electrónico:</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-base font-semibold text-gray-800 mb-2">Contraseña:</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <div class="text-center">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                    Iniciar Sesión
                </button>
            </div>
        </form>
    </div>
</div>
@endsection