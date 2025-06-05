<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Venus Cars - Find your dream car with modern and sophisticated designs." />
    <meta name="author" content="Venus Cars" />
    <meta name="keywords" content="Cars, Modern Cars, Luxury Cars, Venus Cars" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title') / Venus Cars </title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="images/favicon.ico" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- Tailwind CSS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- x-cloak rule for Alpine.js -->
    <style>
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')
</head>
<body class="flex flex-col min-h-screen bg-white text-gray-900">


    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Scripts -->

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js" defer></script>
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js" defer></script>

    @stack('scripts')
</body>
</html>
