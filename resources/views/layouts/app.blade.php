<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Chaco Vial</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQqG4VqUuxmI-I-eJj-1E6J9R3B3G5F4lJ29161B1L3b0L6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-100 font-sans">
    
    @include('sections._header')

    <main class="container mx-auto p-4">
        @yield('content')
    </main>

    @include('sections._footer')
        <a href="#" id="scroll-to-top" class="fixed bottom-6 right-6 p-4 bg-indigo-600 text-white rounded-full shadow-lg opacity-0 invisible transition-all duration-300 ease-in-out z-50">
            <i class="fas fa-arrow-up"></i>
        </a>

    <script src="{{ asset('main.js') }}"></script>

</body>
</html>