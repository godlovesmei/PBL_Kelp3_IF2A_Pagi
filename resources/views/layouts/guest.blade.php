<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Venus Cars', 'Venus Cars') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="images/favicon-96x96.png" sizes="96x96" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 relative px-4 sm:px-0" style="background: url('/images/pexels-mikebirdy-192364.jpg') no-repeat center center / cover;">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <a href="/home" class="hover:opacity-90 transition duration-300 ease-in-out">
                <x-logo class="w-20 h-20 sm:w-24 sm:h-24 fill-current text-gray-50 hover:text-blue-50 drop-shadow-md" />
            </a>
        </div>

        <div class="w-full max-w-md mt-6 px-4 sm:px-6 py-8 bg-gray-50/40 backdrop-blur-md border border-white/30 shadow-xl rounded-2xl">
            {{ $slot }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>
