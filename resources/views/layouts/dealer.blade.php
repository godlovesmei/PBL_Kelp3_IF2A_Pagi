<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Seller Center - Venus Cars, kelola daftar mobil dan order Anda dengan mudah." />
    <meta name="author" content="Venus Cars" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Dealer Dashboard / Venus Cars</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com" defer></script>
    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="shortcut icon" href="images/favicon.ico" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js x-cloak helper -->
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">

@include('partials.side-deal')

        {{-- Mobile sidebar toggle --}}

        {{-- Main layout container --}}
        <div class="flex-1 flex flex-col ml-20 md:ml-60 transition-all duration-300 ease-in-out">

            {{-- Navbar --}}
            @include('partials.nav-deal')

            {{-- Main content --}}
            <main class="flex-1 px-6 pb-10 overflow-auto">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="bg-gray-100 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 text-center py-4 text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} Venus Cars. All rights reserved.
            </footer>

        </div>

    </div>

</body>
</html>

