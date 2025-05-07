<nav x-data="{ open: false }" class="bg-[#f2f2f2] dark:bg-gray-900 shadow-md px-6 py-3 fixed top-0 left-0 w-full z-50 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('pages.home') }}" class="shrink-0 flex items-center">
            <svg class="h-10" width="110" height="110" viewBox="0 0 200 200" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <text x="-100" y="195" font-family="Georgia, serif" font-size="255" font-weight="bold" letter-spacing="-20" class="fill-current text-black dark:text-white">V</text>
                <text x="40" y="170" font-family="Georgia, serif" font-size="225" font-weight="bold" letter-spacing="-20" class="fill-current text-black dark:text-white">C</text>
            </svg>
        </a>

        <!-- Search Box -->
        <div class="relative hidden lg:block">
            <form action="{{ route('pages.shop') }}" method="GET" class="flex items-center">
                <i class="fas fa-search absolute left-3 text-gray-500 dark:text-gray-300"></i>
                <input 
                    type="text" 
                    name="search"
                    placeholder="Search cars..." 
                    class="pl-10 pr-4 py-2 w-64 text-sm rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#bfae91] dark:focus:ring-gray-600 transition duration-300"
                >
            </form>
        </div>

        <!-- Navigation Links -->
        <div class="hidden lg:flex items-center gap-6 text-gray-800 dark:text-gray-300 text-sm font-medium">
            <a href="{{ route('pages.home') }}" class="hover:text-[#7d5a3e] dark:hover:text-[#c3a089] transition">Home</a>
            <a href="{{ route('pages.shop') }}" class="hover:text-[#7d5a3e] dark:hover:text-[#c3a089] transition">Shop</a>
            <a href="{{ route('pages.about') }}" class="hover:text-[#7d5a3e] dark:hover:text-[#c3a089] transition">About</a>
            <a href="{{ route('pages.contact') }}" class="hover:text-[#7d5a3e] dark:hover:text-[#c3a089] transition">Contact</a>
            <a href="{{ route('profile.show') }}" class="hover:text-[#7d5a3e] dark:hover:text-[#c3a089] transition relative">
                <x-cart-menu route="profile.show" text="Cart" />
            </a>
            <a href="{{ route('pages.wishlist') }}" class="hover:text-[#7d5a3e] dark:hover:text-[#c3a089] transition">
                <i class="fas fa-heart text-sm"></i>
            </a>
        </div>

        <!-- Authenticated User Dropdown -->
        <div class="hidden sm:flex sm:items-center">
            @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-300 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-200 transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-200">Login</a>
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-200">Register</a>
            @endauth
        </div>

        <!-- Hamburger Menu for Mobile -->
        <div class="flex items-center sm:hidden">
            <button @click="open = ! open" class="p-2 rounded-md text-gray-400 dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('pages.home')">{{ __('Home') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pages.shop')">{{ __('Shop') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pages.about')">{{ __('About') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pages.contact')">{{ __('Contact') }}</x-responsive-nav-link>
        </div>
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">{{ __('Log Out') }}</x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <x-responsive-nav-link :href="route('login')">{{ __('Login') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">{{ __('Register') }}</x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>