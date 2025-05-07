<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Venus Cars - Find your dream car with modern and sophisticated designs.">
    <meta name="author" content="Venus Cars">
    <meta name="keywords" content="Cars, Modern Cars, Luxury Cars, Venus Cars">
    <title>Venus Cars | @yield('title')</title>
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- x-cloak rule -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @stack('styles') <!-- Memuat CSS khusus per halaman -->
</head>
<body class="flex flex-col min-h-screen bg-white text-gray-900">
    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Memuat script khusus per halaman -->
    @stack('scripts')

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js" defer></script>
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs" defer></script>
</body>
</html>
