<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin') - Club Chaco Vial</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-100">
    
    <!-- Navbar Admin -->
    <nav class="bg-indigo-900 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo y título -->
                <div class="flex items-center space-x-3">
                    <i class="fas fa-user-shield text-2xl"></i>
                    <div>
                        <h1 class="text-xl font-bold">Panel de Administración</h1>
                        <p class="text-xs text-indigo-300">Club Chaco Vial</p>
                    </div>
                </div>

                <!-- Usuario y logout -->
                <div class="flex items-center space-x-4">
                    <span class="text-sm">
                        <i class="fas fa-user-circle mr-1"></i>
                        {{ Auth::user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm transition">
                            <i class="fas fa-sign-out-alt mr-1"></i>
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <nav class="p-4">
                <ul class="space-y-2">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-50 transition {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-indigo-900 font-semibold' : 'text-gray-700' }}">
                            <i class="fas fa-home w-5"></i>
                            <span>Dashboard o Inicio?</span>
                        </a>
                    </li>

                    <!-- Reservas -->
                    <li>
                        <a href="{{ route('admin.reservas.index') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-50 transition {{ request()->routeIs('admin.reservas.*') ? 'bg-indigo-100 text-indigo-900 font-semibold' : 'text-gray-700' }}">
                            <i class="fas fa-calendar-check w-5"></i>
                            <span>Reservas</span>
                            @php
                                $pendientes = \App\Models\Reserva::where('estado', 'pendiente')->count();
                            @endphp
                            @if($pendientes > 0)
                                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $pendientes }}</span>
                            @endif
                        </a>
                    </li>

                    <!-- Instalaciones -->
                    <li>
                        <a href="{{ route('admin.instalaciones.index') }}" 
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-50 transition {{ request()->routeIs('admin.instalaciones.*') ? 'bg-indigo-100 text-indigo-900 font-semibold' : 'text-gray-700' }}">
                            <i class="fas fa-building w-5"></i>
                            <span>Instalaciones</span>
                        </a>
                    </li>

                    <!-- Divider -->
                    <li class="pt-4 pb-2">
                        <hr class="border-gray-200">
                    </li>

                    <!-- Volver al sitio -->
                    <li>
                        <a href="{{ url('/') }}" 
                           class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-gray-100 transition text-gray-600">
                            <i class="fas fa-arrow-left w-5"></i>
                            <span>Volver al Sitio</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <main class="flex-1 p-8">
            <!-- Mensajes flash -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Errores encontrados:</strong>
                    </div>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Contenido de la página -->
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>