<nav x-data="{ open: false }" class="bg-[#f2f2f2] shadow-md px-10 py-3 fixed top-0 left-0 w-full z-50 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center gap-6">
            <a href="{{ route('dashboard') }}" class="shrink-0 flex items-center">
                <svg class="h-10" width="110" height="110" viewBox="0 0 200 200" fill="black" xmlns="http://www.w3.org/2000/svg">
                    <text x="-100" y="195" font-family="Georgia, serif" font-size="255" font-weight="bold" letter-spacing="-20">V</text>
                    <text x="40" y="170" font-family="Georgia, serif" font-size="225" font-weight="bold" letter-spacing="-20">C</text>
                </svg>
            </a>
        </div>

        <!-- Search Box -->
        <div class="relative">
            <form action="{{ route('customer.shop') }}" method="GET">
                <input 
                    type="text" 
                    name="search"
                    placeholder="Search cars..." 
                    class="pl-10 pr-4 py-2 w-64 text-sm rounded-full border focus:outline-none focus:ring-2 focus:ring-[#bfae91] transition duration-300"
                    style="border-color: #f2f2f2;">
                <i class="fas fa-search absolute left-3 top-2.5 text-gray-500"></i>
            </form>
        </div>

        <!-- Navigation Links -->
        <div class="hidden sm:flex items-center gap-8 text-gray-800 text-sm font-medium tracking-wide">
            <a href="{{ route('customer.home') }}" class="hover:text-[#7d5a3e] transition">Home</a>
            
            <!-- Dropdown Shop -->
            <div class="relative group">
                <a href="{{ route('customer.shop') }}" class="hover:text-[#7d5a3e] transition">Shop</a>
                @if(request()->routeIs('customer.shop'))
                <div id="dropdown-menu" class="absolute left-0 hidden group-hover:block bg-white shadow-lg rounded-md w-48 mt-2 border border-gray-200">
                    <a href="{{ route('customer.shop') }}?category=Sedan" class="block px-4 py-2 text-gray-700 hover:bg-[#f7f7f7]">Sedan</a>
                    <a href="{{ route('customer.shop') }}?category=SUV" class="block px-4 py-2 text-gray-700 hover:bg-[#f7f7f7]">SUV</a>
                    <a href="{{ route('customer.shop') }}?category=Hatchback" class="block px-4 py-2 text-gray-700 hover:bg-[#f7f7f7]">Hatchback</a>
                    <a href="{{ route('customer.shop') }}?category=Sports" class="block px-4 py-2 text-gray-700 hover:bg-[#f7f7f7]">Sports</a>
                </div>
                @endif
            </div>

            <a href="{{ route('customer.about') }}" class="hover:text-[#7d5a3e] transition">About</a>
            <a href="{{ route('customer.contact') }}" class="hover:text-[#7d5a3e] transition">Contact</a>
            <a href="{{ route('profile.show') }}" class="hover:text-[#7d5a3e] transition relative group">
                <i class="fas fa-user text-sm"></i>
                <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-300">Profile</span>
            </a>
            <a href="{{ route('customer.wishlist') }}" class="hover:text-[#7d5a3e] transition relative group">
                <i class="fas fa-heart text-sm"></i>
                <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition duration-300">Wishlist</span>
            </a>
        </div>

        <!-- Settings Dropdown -->
        <div class="hidden sm:flex sm:items-center sm:ml-6">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

        <!-- Hamburger Menu for Mobile -->
        <div class="-mr-2 flex items-center sm:hidden">
            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150">
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
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>