@extends('layouts.user')

@section('title', 'Order History')

@section('content')
@php
    // Texts in the status array are now in English
    $statuses = [
        ''           => 'All',
        'pending'    => 'Pending',
        'confirm'    => 'Confirmed',
        'processing' => 'Processing',
        'shipped'    => 'Shipped',
        'completed'  => 'Completed',
        'cancelled'  => 'Cancelled',
    ];
    $statusActive = request('status', '');
@endphp
<div class="min-h-screen pt-[55px] bg-[#f2f2f2]">

    <div class="bg-gray-200 text-center py-14 mb-2 shadow">
        <h2 class="text-4xl md:text-5xl font-bold text-black">My Orders</h2>
        <p class="text-[#777] mt-4 text-lg">
            View all your purchases and their status here.
        </p>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="flex border-b border-gray-200 overflow-x-auto no-scrollbar">
            @foreach($statuses as $key => $text)
                @php
                    $isActive = $statusActive === $key || ($statusActive === null && $key === '');
                @endphp
                <a href="{{ route('user.orders.index', array_merge(request()->except('page'), ['status' => $key ?: null])) }}"
                   class="whitespace-nowrap px-5 py-3 text-base font-semibold border-b-2 transition-all duration-200
                   {{ $isActive ? 'border-red-500 text-red-600 bg-white' : 'border-transparent text-gray-600 hover:text-red-500' }}">
                    {{ $text }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 mb-6">
        <form method="GET" class="relative">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                {{-- Placeholder text is now in English --}}
                placeholder="You can search by Car Name, Order No., or Code"
                class="w-full pl-10 pr-4 py-2 text-sm rounded-lg border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-300 focus:outline-none bg-white"
            />
            <span class="absolute left-3 top-2.5 text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
                </svg>
            </span>
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
        </form>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if ($orders->isEmpty())
          <div class="flex flex-col items-center justify-center text-center py-16">
    <div id="emptyLottie" class="w-64 h-64 mb-6 mx-auto"></div>
    <p class="text-gray-500 text-base sm:text-lg">
        It looks like you have no orders at the moment.
    </p>
</div>
        @else
            <div class="flex flex-col gap-6">
                @foreach ($orders as $order)
                    @php
                        $status = strtolower($order->order_status);
                        $statusProps = [
                            'pending'    => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-800', 'border' => 'border-yellow-200', 'icon' => '⏳'],
                            'confirm'    => ['bg' => 'bg-green-50',  'text' => 'text-green-800',  'border' => 'border-green-200',  'icon' => '✅'],
                            'cancelled'  => ['bg' => 'bg-red-50',    'text' => 'text-red-800',    'border' => 'border-red-200',    'icon' => '🚫'],
                            'processing' => ['bg' => 'bg-blue-50',   'text' => 'text-blue-800',   'border' => 'border-blue-200',   'icon' => '🔧'],
                            'shipped'    => ['bg' => 'bg-purple-50', 'text' => 'text-purple-800', 'border' => 'border-purple-200', 'icon' => '🚚'],
                            'completed'  => ['bg' => 'bg-teal-50',   'text' => 'text-teal-800',   'border' => 'border-teal-200',   'icon' => '🎉'],
                        ];
                        $props = $statusProps[$status] ?? [
                            'bg'=>'bg-gray-100',
                            'text'=>'text-gray-800',
                            'border'=>'border-gray-200',
                            'icon'=>'ℹ️'
                        ];
                        $car = $order->car;
                        $imgSrc = $car && $car->image
                            ? (Str::startsWith($car->image, ['http://', 'https://']) ? $car->image : (file_exists(public_path('storage/'.$car->image)) ? asset('storage/'.$car->image) : asset('images/'.$car->image)))
                            : asset('images/car-placeholder.png');
                        $imgSrc = file_exists(public_path(parse_url($imgSrc, PHP_URL_PATH))) ? $imgSrc : asset('images/car-placeholder.png');
                        $step = array_search($status, array_keys($statusProps));
                        $carName = trim(($car->brand ?? '') . ' ' . ($car->model ?? ''));
                    @endphp

                    <a href="{{ route('user.orders.show', $order->order_id) }}" target="_blank"
                       class="block bg-white border {{ $props['border'] }} rounded-2xl shadow-lg p-6 sm:p-8 hover:shadow-xl hover:ring-2 hover:ring-blue-100 transition relative group">

                        <div class="absolute left-0 right-0 top-0 h-2 rounded-t-2xl overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-200 via-blue-400 to-green-200" style="width:{{ 20+($step*16) }}%"></div>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 pt-3">
                            <div class="flex items-start gap-4 w-full md:w-auto">
                                <div class="w-32 h-20 sm:w-44 sm:h-28 flex items-center justify-center rounded-xl border border-gray-200 bg-gray-50 shadow overflow-hidden aspect-[16/9] relative">
                                    <div class="absolute inset-0 bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100 animate-pulse z-0" x-show="!$el.nextElementSibling.complete"></div>
                                    <img
                                        src="{{ $imgSrc }}"
                                        alt="{{ $carName ?: 'Car Image' }}"
                                        class="w-full h-full object-contain z-10 transition-all duration-200"
                                        loading="lazy"
                                        decoding="async"
                                        onerror="this.onerror=null;this.src='{{ asset('images/car-placeholder.png') }}';"
                                    >
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base sm:text-lg font-semibold truncate">
                                        {{ $car->brand ?? 'N/A' }} - {{ $car->model ?? 'N/A' }}
                                    </h3>
                                    @if ($car)
                                        <div class="text-xs text-gray-500 mt-0.5">
                                            {{ $car->variant ?? '' }}
                                            @if($car->car_code)
                                                • Vehicle Code: {{ $car->car_code }}
                                            @endif
                                        </div>
                                    @endif
                                    <div class="text-xs text-gray-500">• Order ID: #{{ $order->order_id }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">• Date: {{ $order->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <span>• Total:</span>
                                        <span class="font-bold text-gray-700">
                                            Rp{{ number_format($order->total_price) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2 items-start md:items-end w-full md:w-auto mt-4 md:mt-0">
                                <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full border {{ $props['bg'] }} {{ $props['text'] }} {{ $props['border'] }}">
                                    <span>{{ $props['icon'] }}</span>
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="pt-10">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@include('components.floating-menu')
@endsection

@push('scripts')
<script src="https://unpkg.com/lottie-web@5.7.4/build/player/lottie.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lottieContainer = document.getElementById('emptyLottie');
        if (lottieContainer) {
            lottie.loadAnimation({
                container: lottieContainer,
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: '{{ asset('lottie/empty-order.json') }}'
            });
        }
    });
</script>
@endpush
