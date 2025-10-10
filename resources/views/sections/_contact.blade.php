<!-- Sección de Contacto -->
<section id="contacto" class="py-16 bg-gray-200">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">Contacto</h2>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
      <p class="text-gray-600 text-center mb-6">
        Envíanos tu consulta y te responderemos a la brevedad.
      </p>
      <form action="#" method="POST" class="space-y-5">
        <div>
          <label for="nombre" class="block text-gray-700 mb-2 font-semibold text-indigo-600">Nombre Completo</label>
          <input type="text" id="nombre" name="nombre"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            required>
        </div>
        <div>
          <label for="email" class="block text-gray-700 mb-2 font-semibold text-indigo-600">Correo Electrónico</label>
          <input type="email" id="email" name="email"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            required>
        </div>
        <div>
          <label for="mensaje" class="block text-gray-700 mb-2 font-semibold text-indigo-600">Mensaje</label>
          <textarea id="mensaje" name="mensaje" rows="4"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            required></textarea>
        </div>
        <div class="text-center">
          <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105">
            Enviar Mensaje
          </button>
        </div>
        
        <!-- 🚨 Contenedor para los errores -->
        <div id="errores" class="hidden text-red-600 font-semibold mt-4"></div>
      </form>
    </div>
  </div>
</section>

<!-- Sección de Información y Ubicación -->
<section id="info" class="py-16 bg-gray-100">
  <div class="container mx-auto px-4">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full">
      <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Información de contacto</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Datos -->
        <div>
          <p class="text-gray-700 mb-2"><span class="font-semibold text-indigo-600">Dirección:</span> Av. Ávalos 1201, Ciudad de Resistencia</p>
          <p class="text-gray-700 mb-2"><span class="font-semibold text-indigo-600">Teléfono:</span> (362) 4123456</p>
          <p class="text-gray-700 mt-4 mb-2"><span class="font-semibold text-indigo-600">Redes sociales:</span></p>
          <div class="flex space-x-6 mt-2">
            <!-- Facebook -->
            <a href="https://www.facebook.com" target="_blank" aria-label="Facebook" class="text-blue-600 hover:text-blue-800 transition-transform duration-200 hover:scale-110">
              <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24">
                <path d="M22 12a10 10 0 10-11.5 9.9v-7H8v-3h2.5V9c0-2.4 1.5-3.8 3.7-3.8 1.1 0 2.2.2 2.2.2v2.5H15c-1.2 0-1.6.8-1.6 1.6v2h2.7l-.4 3h-2.3v7A10 10 0 0022 12z"/>
              </svg>
            </a>
            <!-- Instagram -->
            <a href="https://www.instagram.com" target="_blank" aria-label="Instagram" class="text-pink-600 hover:text-pink-800 transition-transform duration-200 hover:scale-110">
              <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24">
                <path d="M7 2C4.8 2 3 3.8 3 6v12c0 2.2 1.8 4 4 4h10c2.2 0 4-1.8 4-4V6c0-2.2-1.8-4-4-4H7zm10 2c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H7c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2h10zm-5 3a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6zm4.5-.5a1 1 0 100 2 1 1 0 000-2z"/>
              </svg>
            </a>
          </div>
        </div>

        <!-- Mapa -->
        <div>
          <h3 class="text-lg font-semibold text-gray-800 mb-2">Ubicación:</h3>
          <div class="rounded-xl overflow-hidden shadow-lg border border-gray-200 h-80">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14164.251663395164!2d-58.9837011!3d-27.4361499!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94450c5cbe2e4801%3A0x84b63e6dcf3647c0!2sClub%20Chaco%20Vial!5e0!3m2!1ses-419!2sar!4v1758634448321!5m2!1ses-419!2sar" 
              width="100%" 
              height="100%" 
              style="border:0;" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>