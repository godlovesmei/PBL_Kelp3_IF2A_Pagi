<header
    x-data="{ open: false, profileOpen: false }"
    @keydown.escape="open = false; profileOpen = false"
    class="bg-gray-50 dark:bg-gray-900 shadow-lg w-full z-30 border-b border-gray-200 dark:border-gray-800"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo + Title -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('pages.dealer.dashboard') }}" class="flex items-center group focus:outline-none focus:ring-2 focus:ring-blue-200 rounded">
                    <x-application-logo class="h-8 w-auto mr-3 fill-current text-blue-600 dark:text-blue-400" />
                    <span class="hidden sm:block text-xl font-bold text-gray-700 dark:text-white tracking-tight group-hover:text-blue-600 dark:group-hover:text-blue-300 transition select-none">
                        Dashboard
                    </span>
                </a>
            </div>
            <!-- Right Side -->
            <div class="flex items-center space-x-2">
                <!-- User Dropdown -->
                <div class="relative" x-data @keydown.escape="profileOpen = false" @click.away="profileOpen = false">
                    <button
                        @click="profileOpen = !profileOpen"
                        type="button"
                        class="flex items-center gap-2 px-3 py-2 rounded-md bg-gray-100 dark:bg-blue-900/10 hover:bg-gray-200 dark:hover:bg-blue-900/30 text-gray-700 dark:text-gray-300 font-medium focus:outline-none shadow transition"
                        aria-haspopup="true"
                        :aria-expanded="profileOpen.toString()"
                        aria-label="User menu"
                    >
                        <span class="hidden lg:inline">{{ Auth::user()->name }}</span>
                        <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0L5.293 8.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div
                        x-cloak
                        x-show="profileOpen"
                        x-transition
                        class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-xl bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-30"
                        role="menu"
                        aria-orientation="vertical"
                        tabindex="-1"
                    >
                        <div class="py-3 px-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="font-semibold text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                        </div>
                        <x-dropdown-link :href="route('pages.profile.edit')" class="hover:bg-blue-50 dark:hover:bg-blue-900/20">
                            <i class="fas fa-user-cog mr-2 text-blue-400"></i>
                            Profile & Settings
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="hover:bg-blue-50 dark:hover:bg-blue-900/20">
                                <i class="fas fa-sign-out-alt mr-2 text-red-400"></i>
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>
                <!-- Mobile Hamburger -->
                <div class="flex items-center md:hidden ml-2">
                    <button
                        @click="open = !open"
                        :aria-expanded="open.toString()"
                        aria-label="Toggle menu"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-200 transition"
                    >
                        <svg :class="{ 'hidden': open, 'block': !open }" class="block h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg :class="{ 'block': open, 'hidden': !open }" class="hidden h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu: now with Main Navigation -->
    <div
        x-cloak
        x-show="open"
        x-transition
        id="mobile-menu"
        class="md:hidden bg-white dark:bg-gray-900 shadow-lg border-t border-gray-200 dark:border-gray-700"
    >
        <nav class="px-4 pt-4 pb-4 space-y-1">
            @php
                $currentRoute = Route::currentRouteName();
                $menuSections = [
                    [
                        'title' => 'MENU',
                        'items' => [
                            [
                                'label' => 'Dashboard',
                                'route' => 'pages.dealer.dashboard',
                                'icon' => 'M10 20v-6h4v6h5v-8h3L10 0 2 12h3v8z',
                            ],
                            [
                                'label' => 'Analytics',
                                'route' => 'pages.dealer.analytics',
                                'icon' => 'M3 3v18h18V3H3zm16 16H5V5h14v14zm-7-3a5 5 0 100-10 5 5 0 000 10z',
                            ],
                            [
                                'label' => 'Sales',
                                'route' => 'pages.dealer.sales',
                                'icon' => 'M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0-6C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z',
                            ],
                        ]
                    ],
                    [
                        'title' => 'MANAGEMENT',
                        'items' => [
                            [
                                'label' => 'Products',
                                'route' => 'pages.dealer.index',
                                'icon' => 'M20 7l-8-4-8 4m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0L12 13 4 7',
                            ],
                            [
                                'label' => 'Orders',
                                'icon' => 'M4 4h16v2H4zm0 7h16v2H4zm0 7h16v2H4z',
                                'children' => [
                                    [
                                        'label' => 'All Orders',
                                        'route' => 'pages.dealer.order-index',
                                        'icon' => 'M3 4a1 1 0 011-1h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm3 3h12v2H6V7zm0 4h12v2H6v-2z',
                                    ],
                                    [
                                        'label' => 'Payments',
                                        'route' => 'pages.dealer.payments',
                                        'icon' => 'M2 7h20M5 10h14M4 14h4m2 0h10M3 18h18',
                                    ],
                                    [
                                        'label' => 'Installments',
                                        'route' => 'pages.dealer.installments',
                                        'icon' => 'M12 6v6l4 2m-4-8a10 10 0 110 20 10 10 0 010-20z',
                                    ],
                                ]
                            ],
                            [
                                'label' => 'Brochures',
                                'route' => 'pages.dealer.brochure.index',
                                'icon' => 'M3 4a1 1 0 011-1h11l5 5v11a1 1 0 01-1 1H4a1 1 0 01-1-1V4z',
                            ],
                           // [
                               // 'label' => 'Customers',
                               // 'route' => 'pages.dealer.order-index',
                               // 'icon' => 'M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5s-3 1.34-3 3 1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 2.08 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z',
                           // ],
                        ]
                    ]
                ];
            @endphp
            @foreach ($menuSections as $section)
                <div>
                    <div class="pl-2 pb-1 text-xs text-blue-700 dark:text-blue-300 font-bold tracking-wider select-none uppercase">
                        {{ $section['title'] }}
                    </div>
                    @foreach ($section['items'] as $item)
                        @if (isset($item['children']))
                            <div x-data="{ openChild: {{ collect($item['children'])->pluck('route')->contains($currentRoute) ? 'true' : 'false' }} }" class="mb-1">
                                <button @click="openChild = !openChild"
                                    class="flex items-center px-3 py-2 w-full rounded-lg text-sm font-semibold
                                        text-gray-700 dark:text-gray-200
                                        hover:bg-blue-50 dark:hover:bg-blue-900/20
                                        transition"
                                    :aria-expanded="openChild.toString()">
                                    <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="{{ $item['icon'] }}" />
                                    </svg>
                                    <span class="ml-3">{{ $item['label'] }}</span>
                                    <svg class="ml-auto w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                         :class="{ 'rotate-90': openChild }">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                                <div x-show="openChild" x-collapse class="ml-8">
                                    @foreach ($item['children'] as $child)
                                        <a href="{{ route($child['route']) }}"
                                            class="block px-3 py-2 rounded-lg text-sm font-medium
                                                {{ $currentRoute === $child['route'] ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-200' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-blue-900/20' }}">
                                            {{ $child['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ route($item['route']) }}"
                               class="flex items-center px-3 py-2 rounded-lg text-sm font-semibold transition
                                    {{ $currentRoute === $item['route'] ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-200' : 'text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-blue-900/20' }}">
                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="{{ $item['icon'] }}" />
                                </svg>
                                <span class="ml-3">{{ $item['label'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endforeach
            <hr class="my-2 border-blue-200 dark:border-blue-800">
            <!-- Profile & Logout -->
            <div class="flex items-center gap-3 mb-2">
                <div>
                    <p class="text-gray-800 dark:text-white font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-gray-500 dark:text-blue-200 text-sm truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <a href="{{ route('pages.profile.edit') }}"
                class="block px-3 py-2 rounded-lg text-base font-semibold text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-900/20 transition flex items-center gap-2"
            >
                <i class="fas fa-user-cog text-blue-400"></i> Profile & Settings
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full text-left px-3 py-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-blue-100 dark:hover:bg-blue-900/20 transition font-semibold flex items-center gap-2"
                >
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </button>
            </form>
        </nav>
    </div>
</header>
