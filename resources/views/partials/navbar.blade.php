<!-- Navbar -->
<nav x-data="{ open: false }"
    class="bg-[#F5F5F5] dark:bg-gray-900 shadow-sm fixed top-0 left-0 w-full z-50 border-b border-[#d2e3ea] dark:border-gray-800">
    <div class="container mx-auto px-4 py-2 flex items-center justify-between min-h-[60px]">

        <!-- Logo -->
        <a href="{{ route('pages.home') }}" class="flex items-center gap-2 group">
            <x-logo class="w-9 h-9 transition-transform group-hover:scale-105 duration-200" />
        </a>

        <!-- Search -->
        <div class="hidden md:block w-full max-w-md mx-4">
            <x-search />
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center gap-5 text-sm font-medium">
            @foreach ([
        'pages.home' => 'Home',
        'pages.shop' => 'Shop',
        'pages.about' => 'About',
        'pages.contact' => 'Contact',
    ] as $route => $label)
                <a href="{{ route($route) }}"
                    class="px-3 py-2 rounded-md transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-[#f5f5f5]
                    {{ request()->routeIs($route)
                        ? 'underline underline-offset-8 decoration-2 text-[#188e9c] dark:text-[#7de2d1] font-semibold'
                        : 'hover:bg-[#e0f4f7] hover:text-[#0f766e] dark:hover:bg-[#183c3d] text-gray-600 dark:text-gray-300' }}"
                    aria-current="{{ request()->routeIs($route) ? 'page' : false }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- Auth (No Avatar) -->
        <div class="hidden lg:flex items-center gap-3">
            @auth
                @if (Auth::user()->role_id === \App\Constants\RoleConstant::CUSTOMER)
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="px-3 py-2 rounded-lg text-sm text-gray-700 dark:text-gray-300 hover:bg-[#e0f4f7] dark:hover:bg-[#183c3d] transition focus:outline-none focus:ring-2 focus:ring-[#8ee4d9]">
                                {{ Auth::user()->name }}
                                <svg class="ml-1 h-4 w-4 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0L5.293 8.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('pages.profile.edit') }}">Profile</x-dropdown-link>
                            <x-dropdown-link href="{{ route('user.orders.index') }}">My Orders</x-dropdown-link>
                            <x-dropdown-link href="{{ route('pages.wishlist') }}">My Wishlist</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="text-sm px-3 py-2 rounded-lg text-[#188e9c] dark:text-[#7de2d1] hover:bg-[#e0f4f7] dark:hover:bg-[#183c3d] transition focus:outline-none focus:ring-2 focus:ring-[#8ee4d9]">Log
                    in</a>
                <a href="{{ route('register') }}"
                    class="text-sm px-3 py-2 rounded-lg text-[#188e9c] dark:text-[#7de2d1] hover:bg-[#e0f4f7] dark:hover:bg-[#183c3d] transition focus:outline-none focus:ring-2 focus:ring-[#8ee4d9]">Register</a>
            @endauth
        </div>

        <!-- Mobile Toggle -->
        <div class="lg:hidden">
            <button @click="open = !open"
                class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-[#daf7f0] dark:hover:bg-[#183c3d] transition focus:outline-none focus:ring-2 focus:ring-[#8ee4d9]">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Dropdown -->
    <div x-show="open" x-transition
        class="lg:hidden px-4 pb-6 pt-3 space-y-2 bg-gradient-to-b from-[#f7fafc] via-[#e6f6f8] to-[#e6f7f2] dark:from-gray-900 dark:to-gray-800 text-gray-700 dark:text-gray-300 text-sm shadow-md border-b border-[#d2e3ea] dark:border-gray-700"
        @click.away="open = false" @keydown.escape.window="open = false">
        @foreach ([
        'pages.home' => 'Home',
        'pages.shop' => 'Shop',
        'pages.about' => 'About',
        'pages.contact' => 'Contact',
    ] as $route => $label)
            <x-responsive-nav-link :href="route($route)" :active="request()->routeIs($route)"
                class="block py-2 border-b border-[#e0f4f7] dark:border-[#2acfc9] hover:bg-[#daf7f0] dark:hover:bg-[#183c3d] focus:outline-none focus:ring-2 focus:ring-[#8ee4d9]">
                {{ $label }}
            </x-responsive-nav-link>
        @endforeach

        @auth
            @if (Auth::user()->role_id === \App\Constants\RoleConstant::CUSTOMER)
                <x-responsive-nav-link :href="route('pages.profile.edit')"
                    class="block py-2 border-b border-gray-200 dark:border-gray-700">{{ __('Profile') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user.orders.index')"
                    class="block py-2 border-b border-gray-200 dark:border-gray-700">{{ __('My Orders') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pages.wishlist')"
                    class="block py-2 border-b border-gray-200 dark:border-gray-700">{{ __('Wishlist') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="block py-2 border-b border-gray-200 dark:border-gray-700">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            @endif
        @else
            <x-responsive-nav-link :href="route('login')">Login</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')">Register</x-responsive-nav-link>
        @endauth
    </div>
</nav>
