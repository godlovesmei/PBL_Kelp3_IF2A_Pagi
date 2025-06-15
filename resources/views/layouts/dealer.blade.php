<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Seller Center - Venus Cars, manage your car listings and orders easily." />
    <meta name="author" content="Venus Cars" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Dealer Dashboard / Venus Cars</title>

    {{-- ✅ Load Tailwind & JS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />

    {{-- ✅ Alpine.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- ✅ Alpine.js x-cloak helper --}}
    <style>[x-cloak] { display: none !important; }</style>

    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
</head>
<body
    class="bg-gray-100 font-sans antialiased"
    x-data
    x-init="
        Alpine.store('sidebar', {
            open: (localStorage.getItem('sidebarOpen') === null) ? true : localStorage.getItem('sidebarOpen') === 'true'
        });
        $watch('$store.sidebar.open', value => localStorage.setItem('sidebarOpen', value));
    "
>
 @include('partials.side-deal')
    <div class="flex min-h-screen">



        <div class="flex-1 flex flex-col transition-all duration-300 ease-in-out"
            :class="$store.sidebar.open ? 'ml-60' : 'ml-20'">

            @include('partials.nav-deal')

            <main class="flex-1 px-6 pb-10 overflow-auto">
                @yield('content')
            </main>

            <footer class="bg-gray-100 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 text-center py-4 text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} Venus Cars. All rights reserved.
            </footer>
        </div>
    </div>
</body>
</html>
