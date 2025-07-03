<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Seller Center - Venus Cars, manage your car listings and orders easily." />
    <meta name="author" content="Venus Cars" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', 'Dealer Dashboard / Venus Cars')</title>

    {{-- ✅ Load Tailwind & JS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />

    {{-- ✅ Alpine.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- ✅ Alpine.js x-cloak helper --}}
    <style>[x-cloak] { display: none !important; }</style>

    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />

    {{-- 🟢 Styles stack for per-page CSS --}}
    @stack('styles')
</head>
<body
    class="bg-gray-100 font-sans antialiased min-h-screen"
    x-data
    x-init="
        Alpine.store('sidebar', {
            open: (localStorage.getItem('sidebarOpen') === null) ? true : localStorage.getItem('sidebarOpen') === 'true'
        });
        $watch('$store.sidebar.open', value => localStorage.setItem('sidebarOpen', value));
    "
>
    <!-- Alert (Success & Error) -->
    @if(session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    {{-- Sidebar --}}
    @include('partials.side-deal')

    <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out"
        :class="{
                'ml-0': true,
                'md:ml-60': $store.sidebar.open,
                'md:ml-20': !$store.sidebar.open
        }">

        {{-- Navbar --}}
        @include('partials.nav-deal')

        <main class="flex-1 sm:px-6 px-3 pb-32 pt-4 overflow-x-auto">
            @yield('content')
        </main>

        <footer class="bg-gray-100 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 text-center py-4 text-sm text-gray-500 dark:text-gray-400 mt-auto" style="position: static;">
            &copy; {{ date('Y') }} Venus Cars. All rights reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js" defer></script>
    {{-- 🟢 Scripts stack for per-page JS --}}
    @stack('scripts')

    {{-- Optional: Auto scroll to first error --}}
    @if ($errors->any())
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const errorInput = document.querySelector('.is-invalid, .border-red-500');
        if (errorInput) {
          errorInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
          errorInput.focus();
        }
      });
    </script>
    @endif
</body>
</html>
