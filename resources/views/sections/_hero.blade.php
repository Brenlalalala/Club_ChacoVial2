<section class="relative h-[70vh] bg-cover bg-center" style="background-image: url('{{ asset('images/entrada.jpg') }}');">
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/40"></div>
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4">
        <p class="text-lg md:text-2xl font-light mb-8 max-w-2xl">
            Tu espacio para el deporte, la recreación y la comunidad.
        </p>
        <a href="{{ route('reservations') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transition-transform hover:scale-105">
            ¡Reservar!
        </a>
    </div>
</section>