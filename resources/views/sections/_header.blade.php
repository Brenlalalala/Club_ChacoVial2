<header class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-indigo-700 text-white p-4 shadow-lg sticky top-0 z-50">
    <nav class="container mx-auto flex justify-between items-center flex-wrap">
        <a href="/" class="flex items-center space-x-3 py-2">
            <img src="{{ asset('images/logo.jpg') }}" class="h-16 rounded-full shadow-md">
            <span class="text-2xl font-extrabold tracking-wide">Club Chaco Vial</span>
        </a>

        <button id="menu-button" class="text-white text-3xl md:hidden focus:outline-none">
            &#9776;
        </button>

        <ul id="menu" class="hidden md:flex flex-col md:flex-row md:space-x-6 text-lg font-medium w-full md:w-auto mt-4 md:mt-0">
            <li><a href="#nosotros" class="hover:text-green-300 transition-colors block py-2 px-4 md:p-0">Nosotros</a></li>
            <li><a href="#instalaciones" class="hover:text-green-300 transition-colors block py-2 px-4 md:p-0">Instalaciones</a></li>
            <li><a href="#contacto" class="hover:text-green-300 transition-colors block py-2 px-4 md:p-0">Contacto</a></li>
            <li>
                <a href="{{ route('login') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full shadow-md transition-colors block text-center mt-2 md:mt-0">
                    Iniciar Sesión
                </a>
            </li>
        </ul>
    </nav>
</header>

<script>
    document.getElementById('menu-button').addEventListener('click', function() {
        document.getElementById('menu').classList.toggle('hidden');
    });
</script>