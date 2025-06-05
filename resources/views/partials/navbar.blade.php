<nav x-data="{ open: false }" class="bg-[#f2f2f2] dark:bg-gray-900 shadow-md fixed top-0 left-0 w-full z-50 border-b border-gray-300 dark:border-gray-700">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('pages.home') }}" class="flex items-center shrink-0">
            <x-logo />
        </a>

        <!-- Search -->
        <div class="hidden md:block w-full max-w-md mx-4">
            <x-search />
        </div>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex items-center gap-x-6 text-gray-700 dark:text-gray-300 text-sm font-medium">
            @foreach ([
                'pages.home' => 'Home',
                'pages.shop' => 'Shop',
                'pages.about' => 'About',
                'pages.contact' => 'Contact',
            ] as $route => $label)
                <a href="{{ route($route) }}" class="hover:text-[#8a7f6f] transition-colors focus:outline-none focus:border-b-2 focus:border-[#a3b8b0]">
                    {{ $label }}
                </a>
            @endforeach
             <a href="{{ route('pages.wishlist') }}" class="hover:text-[#8a7f6f]">
                <i class="fas fa-heart"></i>
            </a>
            <a href="{{ route('pages.user.transactions') }}" class="hover:text-[#8a7f6f]">
                <x-bell />
            </a>

        </div>

        <!-- Auth / Profile -->
        <div class="hidden lg:flex items-center gap-x-4">
            @auth
                @if (Auth::user()->role_id === \App\Constants\RoleConstant::CUSTOMER)
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center text-sm text-gray-700 dark:text-gray-300 focus:outline-none hover:text-gray-900 dark:hover:text-white">
                                {{ Auth::user()->name }}
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('pages.profile.edit') }}">{{ __('Profile') }}</x-dropdown-link>
                            <x-dropdown-link href="{{ route('user.orders.index') }}">{{ __('My Orders') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endif
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition">Login</a>
                <a href="{{ route('register') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition">Register</a>
            @endauth
        </div>

        <!-- Mobile Hamburger -->
        <div class="lg:hidden">
            <button @click="open = !open"
                    :aria-expanded="open"
                    aria-label="Toggle menu"
                    class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition class="lg:hidden px-4 pb-4 pt-2 space-y-2 bg-[#f2f2f2] dark:bg-gray-900 text-gray-700 dark:text-gray-300 text-sm">
        @foreach ([
            'pages.home' => 'Home',
            'pages.shop' => 'Shop',
            'pages.about' => 'About',
            'pages.contact' => 'Contact',
        ] as $route => $label)
            <x-responsive-nav-link :href="route($route)">
                {{ $label }}
            </x-responsive-nav-link>
        @endforeach

        @auth
            <x-responsive-nav-link :href="route('pages.profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('user.orders.index')">{{ __('My Orders') }}</x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        @else
            <x-responsive-nav-link :href="route('login')">{{ __('Login') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')">{{ __('Register') }}</x-responsive-nav-link>
        @endauth
    </div>
</nav>

