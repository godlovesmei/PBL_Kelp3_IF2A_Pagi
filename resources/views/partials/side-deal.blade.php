<aside
    x-data
    :class="$store.sidebar.open ? 'w-60' : 'w-20'"
    class="hidden md:flex fixed top-0 left-0 h-screen bg-white dark:bg-gray-900 flex-col transition-[width] duration-300 ease-in-out overflow-y-auto border-r border-gray-200 dark:border-gray-700 shadow-lg z-40"
    style="transition-property: width;"
    x-cloak
>
    <!-- Header: Logo & Toggle -->
    <div class="flex items-center justify-between h-24 px-6 border-b border-gray-200 dark:border-gray-700">
        <x-logo class="w-10 h-10 text-indigo-600 dark:text-indigo-400" />
        <button
            @click="$store.sidebar.open = !$store.sidebar.open"
            class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
            :aria-label="$store.sidebar.open ? 'Collapse sidebar' : 'Expand sidebar'"
            :aria-expanded="$store.sidebar.open.toString()"
        >
            <svg
                x-show="$store.sidebar.open"
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6 transform rotate-180 transition-transform duration-300"
                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                x-cloak
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <svg
                x-show="!$store.sidebar.open"
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6 transition-transform duration-300"
                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                x-cloak
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
    <!-- Navigation -->
    <nav class="flex-1 flex flex-col mt-6 px-2 space-y-1" role="menu" aria-label="Sidebar navigation">
        @php
            $navItems = [
                ['label' => 'Dashboard', 'route' => 'pages.dealer.dashboard', 'icon' => 'M10 20v-6h4v6h5v-8h3L10 0 2 12h3v8z'],
                ['label' => 'Products',  'route' => 'pages.dealer.index',     'icon' => 'M20 7l-8-4-8 4m16 0v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0L12 13 4 7'],
                ['label' => 'Orders',    'route' => 'pages.dealer.order-index', 'icon' => 'M4 4h16v2H4zm0 7h16v2H4zm0 7h16v2H4z'],
                ['label' => 'Brochures', 'route' => 'pages.dealer.brochure.index', 'icon' => 'M3 4a1 1 0 011-1h11l5 5v11a1 1 0 01-1 1H4a1 1 0 01-1-1V4z'],
            ];
            $currentRoute = Route::currentRouteName();
        @endphp

        @foreach ($navItems as $item)
            <a href="{{ route($item['route']) }}"
                role="menuitem"
                class="group flex items-center p-3 rounded-lg transition-colors duration-200
                hover:bg-indigo-50 dark:hover:bg-indigo-900 text-gray-700 dark:text-gray-300
                hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500
                {{ $currentRoute === $item['route'] ? 'bg-indigo-100 dark:bg-indigo-800 text-indigo-700 dark:text-indigo-300' : '' }}"
                x-tooltip="!$store.sidebar.open ? '{{ $item['label'] }}' : ''"
            >
                <svg class="w-6 h-6 flex-shrink-0 text-indigo-500 dark:text-indigo-400 transition-transform group-hover:scale-110"
                    fill="currentColor" viewBox="0 0 24 24" stroke="none" aria-hidden="true">
                    <path d="{{ $item['icon'] }}" />
                </svg>
                <span
                    x-show="$store.sidebar.open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-2"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-2"
                    class="ml-4 text-sm font-semibold whitespace-nowrap select-none"
                >
                    {{ $item['label'] }}
                </span>
            </a>
        @endforeach
    </nav>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.directive('tooltip', (el, { expression }, { evaluateLater }) => {
                if (!expression) return;
                evaluateLater(expression)((value) => {
                    if (value) el.setAttribute('title', value);
                    else el.removeAttribute('title');
                });
            });
        });
    </script>
</aside>
