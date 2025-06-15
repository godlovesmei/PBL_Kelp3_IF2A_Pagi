<nav x-data="{ open: false }" class="bg-[#f2f2f2] dark:bg-gray-900 shadow fixed top-0 left-0 w-full z-50 border-b border-gray-300 dark:border-gray-700">
    <div class="container mx-auto px-3 py-2 flex items-center justify-between min-h-[56px]">
        <!-- Logo -->
        <a href="{{ route('pages.home') }}" class="flex items-center shrink-0 focus:outline-none" aria-label="Go to Home">
            <x-logo class="w-8 h-8" />
        </a>

        <!-- Desktop Search (hidden on mobile) -->
        <div class="hidden md:block w-full max-w-sm mx-3">
            <x-search />
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center gap-x-4 text-gray-700 dark:text-gray-300 text-[14px] font-medium">
            @foreach([
                'pages.home' => 'Home',
                'pages.shop' => 'Shop',
                'pages.about' => 'About',
                'pages.contact' => 'Contact',
            ] as $route => $label)
                <a href="{{ route($route) }}"
                   class="flex items-center px-3 py-1.5 rounded hover:bg-[#d2e1f0] dark:hover:bg-[#2d3f3d] focus:outline-none focus:ring-2 focus:ring-[#a3cfc5] transition-colors duration-150 h-10"
                   aria-current="{{ request()->routeIs($route) ? 'page' : false }}">
                    {{ $label }}
                </a>
            @endforeach

            <!-- Wishlist Icon -->
            <a href="{{ route('pages.wishlist') }}"
               class="flex items-center justify-center w-10 h-10 rounded hover:bg-[#d2e1f0] dark:hover:bg-[#2d3f3d] transition focus:outline-none focus:ring-2 focus:ring-[#a3cfc5]"
               aria-label="Wishlist">
                <svg class="w-5 h-5 text-[#4a5250] dark:text-[#cfeeea]" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                </svg>
            </a>

            <!-- Notification Dropdown -->
            <x-notification-dropdown :notifications="$notifications" :unread-count="$unreadCount" />
        </div>

        <!-- Desktop Auth/Profile -->
        <div class="hidden lg:flex items-center gap-x-3">
            @auth
                @if (Auth::user()->role_id === \App\Constants\RoleConstant::CUSTOMER)
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center text-[15px] text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-1.5 rounded hover:bg-[#d2e1f0] dark:hover:bg-[#2d3f3d] transition h-10 focus:outline-none focus:ring-2 focus:ring-[#a3cfc5]">
                                {{ Auth::user()->name }}
                                <svg class="ml-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('pages.profile.edit') }}">{{ __('Profile') }}</x-dropdown-link>
                            <x-dropdown-link href="{{ route('user.orders.index') }}">{{ __('My Orders') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endif
            @else
                <a href="{{ route('login') }}" class="text-[15px] text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-1.5 rounded hover:bg-[#d2e1f0] dark:hover:bg-[#2d3f3d] transition h-10 focus:outline-none focus:ring-2 focus:ring-[#a3cfc5]">Log in</a>
                <a href="{{ route('register') }}" class="text-[15px] text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-1.5 rounded hover:bg-[#d2e1f0] dark:hover:bg-[#2d3f3d] transition h-10 focus:outline-none focus:ring-2 focus:ring-[#a3cfc5]">Register</a>
            @endauth
        </div>

        <!-- Mobile Hamburger -->
        <div class="lg:hidden">
            <button @click="open = !open"
                    :aria-expanded="open"
                    aria-label="Toggle menu"
                    class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-[#d2e1f0] dark:hover:bg-[#2d3f3d] transition w-10 h-10 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-[#a3cfc5]">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open"
         x-transition
         class="lg:hidden px-4 pb-5 pt-3 space-y-2 bg-[#f2f2f2] dark:bg-gray-900 text-gray-700 dark:text-gray-300 text-[15px]"
         @click.away="open = false"
         @keydown.escape.window="open = false"
    >
        @foreach([
            'pages.home' => 'Home',
            'pages.shop' => 'Shop',
            'pages.about' => 'About',
            'pages.contact' => 'Contact',
        ] as $route => $label)
            <x-responsive-nav-link :href="route($route)"
                                   class="block py-2 border-b border-gray-200 dark:border-gray-700"
                                   :active="request()->routeIs($route)">
                {{ $label }}
            </x-responsive-nav-link>
        @endforeach

        <!-- Wishlist Mobile -->
        <x-responsive-nav-link :href="route('pages.wishlist')" class="flex items-center gap-2 py-2 border-b border-gray-200 dark:border-gray-700">
            <svg class="w-5 h-5 text-[#4a5250] dark:text-[#cfeeea]" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
            </svg>
            Wishlist
        </x-responsive-nav-link>

        <!-- Notifications Mobile -->
        <div class="py-2 border-b border-gray-200 dark:border-gray-700">
            <span class="block font-semibold mb-1">Notifications</span>
            <x-notification-dropdown :notifications="$notifications" :unread-count="$unreadCount" mobile="true" />
        </div>

        @auth
            <x-responsive-nav-link :href="route('pages.profile.edit')" class="block py-2 border-b border-gray-200 dark:border-gray-700">{{ __('Profile') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('user.orders.index')" class="block py-2 border-b border-gray-200 dark:border-gray-700">{{ __('My Orders') }}</x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block py-2 border-b border-gray-200 dark:border-gray-700">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        @else
            <x-responsive-nav-link :href="route('login')" class="block py-2 border-b border-gray-200 dark:border-gray-700">{{ __('Login') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')" class="block py-2 border-b border-gray-200 dark:border-gray-700">{{ __('Register') }}</x-responsive-nav-link>
        @endauth
    </div>
</nav>
