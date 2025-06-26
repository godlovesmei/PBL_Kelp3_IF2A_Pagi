<!-- Sidebar (Desktop Only) -->
<aside
    x-data
    :class="$store.sidebar.open ? 'w-60' : 'w-20'"
    class="fixed top-0 left-0 h-screen bg-slate-300 dark:bg-gray-900 flex-col transition-all duration-300 ease-in-out overflow-y-auto border-r border-gray-200 dark:border-gray-700 shadow-lg z-40 hidden md:flex"
    style="transition-property: width;"
    x-cloak
>
    <!-- Header: Logo & Toggle -->
    <div class="flex items-center h-16 px-2 border-b border-gray-400 dark:border-gray-700">
        <!-- Logo hanya muncul saat sidebar open -->
        <div class="flex-1 flex items-center justify-center"
            x-show="$store.sidebar.open"
            x-transition.opacity
        >
            <x-logo class="w-auto h-8" />
        </div>
        <!-- Toggle button selalu muncul -->
        <button
            @click="$store.sidebar.open = !$store.sidebar.open"
            class="flex items-center justify-center w-8 h-8 rounded-md hover:bg-blue-50 dark:hover:bg-blue-900/20 focus:outline-none focus:ring-2 focus:ring-blue-800 transition ml-0"
            :aria-label="$store.sidebar.open ? 'Collapse sidebar' : 'Expand sidebar'"
            :aria-expanded="$store.sidebar.open.toString()"
        >
            <svg
                x-show="!$store.sidebar.open"
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5"
                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                x-cloak
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <svg
                x-show="$store.sidebar.open"
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 transform rotate-180 transition-transform duration-300"
                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                x-cloak
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 flex flex-col mt-6 px-2 space-y-6" role="menu" aria-label="Sidebar navigation">
        @php
        $currentRoute = Route::currentRouteName();
        $menuSections = [
            [
                'title' => 'MENU',
                'items' => [
                    [
                        'label' => 'Dashboard',
                        'route' => 'pages.dealer.dashboard',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6  text-blue-800 dark:text-blue-400">
                        // <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        // </svg>
                        ',
                    ],
                    [
                        'label' => 'Analytics',
                        'route' => 'pages.dealer.analytics',
                        'icon' => '<svg class="w-6 h-6 text-blue-800 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 19V7m4 12V3m4 16v-7m4 7v-4m4 4v-9"/></svg>',
                    ],

                   /*
[
    'label' => 'Sales',
    'route' => 'pages.dealer.sales',
    'icon' => '<svg class="w-6 h-6 text-blue-800 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
    // <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.891 15.107 15.11 8.89m-5.183-.52h.01m3.089 7.254h.01M14.08 3.902a2.849 2.849 0 0 0 2.176.902 2.845 2.845 0 0 1 2.94 2.94 2.849 2.849 0 0 0 .901 2.176 2.847 2.847 0 0 1 0 4.16 2.848 2.848 0 0 0-.901 2.175 2.843 2.843 0 0 1-2.94 2.94 2.848 2.848 0 0 0-2.176.902 2.847 2.847 0 0 1-4.16 0 2.85 2.85 0 0 0-2.176-.902 2.845 2.845 0 0 1-2.94-2.94 2.848 2.848 0 0 0-.901-2.176 2.848 2.848 0 0 1 0-4.16 2.849 2.849 0 0 0 .901-2.176 2.845 2.845 0 0 1 2.941-2.94 2.849 2.849 0 0 0 2.176-.901 2.847 2.847 0 0 1 4.159 0Z"/>
    // </svg>
    ',
],
*/

                ]
            ],
            [
                'title' => 'MANAGEMENT',
                'items' => [
[
    'label' => 'Products',
    'route' => 'pages.dealer.index',
    'icon' => '<svg class="w-6 h-6 text-blue-800 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
        <path d="M192,0 L384,110.85V332.55L192,443.4 0,332.55V110.85L192,0Z M128,206.918V357.189L170.667,381.824V231.552L128,206.918ZM42.667,157.653V307.92L85.333,332.555V182.286L42.667,157.653ZM275.991,97.759L150.413,170.595 192,194.606 317.867,121.936 275.991,97.759ZM192,49.267L66.133,121.936 107.795,145.989 233.374,73.154 192,49.267Z"/>
    </svg>',
],

                   [
    'label' => 'Orders',
    'icon' => '<svg class="w-6 h-6 text-blue-800 dark:text-blue-400" viewBox="0 0 1024 1024" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M300 462.4h424.8v48H300v-48zM300 673.6H560v48H300v-48z"/>
        <path d="M818.4 981.6H205.6c-12.8 0-24.8-2.4-36.8-7.2-11.2-4.8-21.6-11.2-29.6-20-8.8-8.8-15.2-18.4-20-29.6-4.8-12-7.2-24-7.2-36.8V250.4c0-12.8 2.4-24.8 7.2-36.8 4.8-11.2 11.2-21.6 20-29.6 8.8-8.8 18.4-15.2 29.6-20 12-4.8 24-7.2 36.8-7.2h92.8v47.2H205.6c-25.6 0-47.2 20.8-47.2 47.2v637.6c0 25.6 20.8 47.2 47.2 47.2h612c25.6 0 47.2-20.8 47.2-47.2V250.4c0-25.6-20.8-47.2-47.2-47.2H725.6v-47.2h92.8c12.8 0 24.8 2.4 36.8 7.2 11.2 4.8 21.6 11.2 29.6 20 8.8 8.8 15.2 18.4 20 29.6 4.8 12 7.2 24 7.2 36.8v637.6c0 12.8-2.4 24.8-7.2 36.8-4.8 11.2-11.2 21.6-20 29.6-8.8 8.8-18.4 15.2-29.6 20-12 5.6-24 8-36.8 8z"/>
        <path d="M747.2 297.6H276.8V144c0-32.8 26.4-59.2 59.2-59.2h60.8c21.6-43.2 66.4-71.2 116-71.2 49.6 0 94.4 28 116 71.2h60.8c32.8 0 59.2 26.4 59.2 59.2l-1.6 153.6z m-423.2-47.2h376.8V144c0-6.4-5.6-12-12-12H595.2l-5.6-16c-11.2-32.8-42.4-55.2-77.6-55.2-35.2 0-66.4 22.4-77.6 55.2l-5.6 16H335.2c-6.4 0-12 5.6-12 12v106.4z"/>
    </svg>',
    'children' => [
        [
            'label' => 'All Orders',
            'route' => 'pages.dealer.order-index',
            'icon' => '<svg class="w-4 h-4 text-blue-800 dark:text-blue-400" viewBox="0 0 1024 1024" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M300 462.4h424.8v48H300v-48zM300 673.6H560v48H300v-48z"/>
                <path d="M818.4 981.6H205.6c-12.8 0-24.8-2.4-36.8-7.2-11.2-4.8-21.6-11.2-29.6-20-8.8-8.8-15.2-18.4-20-29.6-4.8-12-7.2-24-7.2-36.8V250.4c0-12.8 2.4-24.8 7.2-36.8 4.8-11.2 11.2-21.6 20-29.6 8.8-8.8 18.4-15.2 29.6-20 12-4.8 24-7.2 36.8-7.2h92.8v47.2H205.6c-25.6 0-47.2 20.8-47.2 47.2v637.6c0 25.6 20.8 47.2 47.2 47.2h612c25.6 0 47.2-20.8 47.2-47.2V250.4c0-25.6-20.8-47.2-47.2-47.2H725.6v-47.2h92.8c12.8 0 24.8 2.4 36.8 7.2 11.2 4.8 21.6 11.2 29.6 20 8.8 8.8 15.2 18.4 20 29.6 4.8 12 7.2 24 7.2 36.8v637.6c0 12.8-2.4 24.8-7.2 36.8-4.8 11.2-11.2 21.6-20 29.6-8.8 8.8-18.4 15.2-29.6 20-12 5.6-24 8-36.8 8z"/>
                <path d="M747.2 297.6H276.8V144c0-32.8 26.4-59.2 59.2-59.2h60.8c21.6-43.2 66.4-71.2 116-71.2 49.6 0 94.4 28 116 71.2h60.8c32.8 0 59.2 26.4 59.2 59.2l-1.6 153.6z m-423.2-47.2h376.8V144c0-6.4-5.6-12-12-12H595.2l-5.6-16c-11.2-32.8-42.4-55.2-77.6-55.2-35.2 0-66.4 22.4-77.6 55.2l-5.6 16H335.2c-6.4 0-12 5.6-12 12v106.4z"/>
            </svg>',
        ],
                            [
                                'label' => 'Payments',
                                'route' => 'pages.dealer.payments',
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-blue-800 dark:text-blue-400">
                                // <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                // </svg>
                                ',
                            ],
                            [
                                'label' => 'Installments',
                                'route' => 'pages.dealer.installments',
                                'icon' => '<svg class="w-4 h-4 text-blue-800 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path stroke="currentColor" stroke-width="2" d="M12 8v4l3 3"/></svg>',
                            ],
                        ]
                    ],
                    [
                        'label' => 'Brochures',
                        'route' => 'pages.dealer.brochure.index',
                        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6  text-blue-800 dark:text-blue-400">
                        // <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        // </svg>
                        ',
                    ],
                    //
                    //[//
                      //  'label' => 'Customers',
                      //  'route' => 'pages.dealer.order-index',
                      //  'icon' => '<svg class="w-6 h-6 text-blue-800 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle cx="8" cy="8" r="4" stroke="currentColor" stroke-width="2"/><circle cx="16" cy="8" r="4" stroke="currentColor" stroke-width="2"/><path stroke="currentColor" stroke-width="2" d="M2 20c0-2.21 3.58-4 8-4s8 1.79 8 4"/><path stroke="currentColor" stroke-width="2" d="M16 16c4.42 0 8 1.79 8 4"/></svg>',
                   // ],
                    //
                ]
            ]
        ];
        @endphp

        @foreach ($menuSections as $section)
            <div>
                <div x-show="$store.sidebar.open" class="pl-3 pb-1 text-xs text-gray-800 dark:text-blue-300 font-bold tracking-wider select-none uppercase">
                    {{ $section['title'] }}
                </div>
                @foreach ($section['items'] as $item)
                    @if (isset($item['children']))
                        @php
                            $isOpen = collect($item['children'])->pluck('route')->contains($currentRoute);
                        @endphp
                        <div x-data="{ open: {{ $isOpen ? 'true' : 'false' }} }">
                            <button @click="open = !open"
                                class="group flex items-center p-3 rounded-lg w-full text-left transition
                                    hover:bg-blue-50 dark:hover:bg-blue-900/20
                                    text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-300
                                    focus:outline-none"
                                :aria-expanded="open.toString()"
                                x-tooltip="!$store.sidebar.open ? '{{ $item['label'] }}' : ''">
                                {!! $item['icon'] !!}
                                <span x-show="$store.sidebar.open" class="ml-4 text-sm font-semibold select-none">{{ $item['label'] }}</span>
                                <svg x-show="$store.sidebar.open" class="ml-auto w-4 h-4 transform transition-transform text-blue-400" :class="{ 'rotate-90': open }"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                            <div x-show="open" x-collapse class="ml-10 mt-1 space-y-1" x-cloak>
                                @foreach ($item['children'] as $child)
                                    <a href="{{ route($child['route']) }}"
                                        class="group flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition
                                            {{ $currentRoute === $child['route'] ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-200' : 'hover:bg-blue-50 dark:hover:bg-blue-900/20 text-gray-700 dark:text-gray-200' }}">
                                        {!! $child['icon'] !!}
                                        <span>{{ $child['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Single Item -->
                        <a href="{{ route($item['route']) }}"
                            class="group flex items-center p-3 rounded-lg transition
                                hover:bg-blue-50 dark:hover:bg-blue-900/20
                                text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-300
                                {{ $currentRoute === $item['route'] ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-200' : '' }}"
                            x-tooltip="!$store.sidebar.open ? '{{ $item['label'] }}' : ''">
                            {!! $item['icon'] !!}
                            <span x-show="$store.sidebar.open" class="ml-4 text-sm font-semibold select-none">{{ $item['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        @endforeach
    </nav>

    <!-- Tooltip logic -->
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
