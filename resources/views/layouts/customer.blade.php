<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venus Cars | @yield('title')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles') <!-- Tambahkan ini untuk memuat CSS khusus per halaman -->
</head>

<body class="bg-[#f2f2f2] text-gray-900 flex flex-col min-h-screen">
    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Main content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')
    @stack('scripts') <!-- Tambahkan ini untuk memuat JS khusus per halaman -->
</body>

</html>
