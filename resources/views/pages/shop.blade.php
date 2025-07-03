@extends('layouts.user')

@section('title', 'Shop')
@section('description', 'Explore our car catalog featuring the latest models, detailed specifications, and stunning images. Find your perfect car today!')

@section('content')
<div class="pt-[85px] px-4 max-w-screen-xl mx-auto">
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- Sidebar Filter -->
        <x-sidebar-filter :categories="$categories" :cars="$cars" />

        <!-- Car Catalog Content -->
        <div class="pt-[35px] flex-1">
            @if($cars->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 text-center space-y-4 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <svg class="w-16 h-16 text-pink-500 dark:text-pink-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75h.008v.008H9.75V9.75zm4.5 0h.008v.008h-.008V9.75zM21 12a9 9 0 11-18 0 9 9 0 0118 0zM8.25 15s1.125-1.5 3.75-1.5 3.75 1.5 3.75 1.5" />
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                        No results found
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        We couldn't find any cars matching your search. Try adjusting the filters.
                    </p>
                    <a href="{{ route('pages.shop') }}"
                        class="mt-2 inline-flex items-center px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white text-sm font-medium rounded-lg transition focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-offset-2">
                        Reset Filters
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 pt-6">
                @foreach ($cars as $car)
                    @php
                        $exterior = optional($car->galleries->firstWhere('type', 'exterior'))->image_path ?? $car->image;
                        $interior = optional($car->galleries->firstWhere('type', 'interior'))->image_path ?? $car->image;
                        $isWishlisted = isset($wishlistedCarIds) && in_array($car->id, $wishlistedCarIds);
                    @endphp
                    <div
                        class="car-card bg-white dark:bg-gray-900 rounded-xl shadow-sm transition-all duration-300 group hover:shadow-2xl hover:-translate-y-2 hover:border-cyan-600 hover:bg-stone-50 dark:hover:bg-gray-800/80 border border-white dark:border-gray-800 relative overflow-hidden"
                        data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}"
                        style="will-change: transform;"
                    >
                        <!-- Car Image Swap on hover -->
                        <div class="relative h-40 w-full bg-white dark:bg-gray-800 overflow-hidden rounded-t-xl">

                            <img src="{{ asset('images/' . $exterior) }}"
                                alt="{{ $car->brand }} {{ $car->model }} exterior"
                                class="car-exterior-img absolute inset-0 h-32 w-full object-contain transition-all duration-500 group-hover:opacity-0 group-hover:scale-110"
                                draggable="false"
                                loading="lazy"
                            >
                            <!-- Ribbon for Stock -->
                        @if($car->stock == 0)
                        <span class="absolute top-4 left-0 right-0 mx-auto w-max bg-gradient-to-r from-yellow-400 via-orange-400 to-amber-600 text-gray-900 font-bold text-xs px-4 py-1 rounded-b-md shadow-md tracking-wide z-10 font-bold">OUT OF STOCK</span>
                        @endif
                            <img src="{{ asset('storage/galleries/' . $interior) }}"
                                alt="{{ $car->brand }} {{ $car->model }} interior"
                                class="absolute inset-0 w-full h-full object-cover opacity-0 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500"
                                draggable="false"
                                loading="lazy"
                            >
                            <span class="absolute top-3 left-3 bg-gray-100 dark:bg-gray-800/90 text-gray-700 dark:text-gray-300 text-xs px-2.5 py-1 rounded shadow-sm ring-1 ring-gray-100 dark:ring-gray-700 tracking-widest z-20" style="letter-spacing: 0.12em;">{{ $car->year }}</span>
                        </div>

                        <!-- Car Info -->
                        <div class="px-5 py-4">
                            <!-- Brand & Model -->
                            <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-1 truncate" style="letter-spacing: 0.01em;">
                                {{ $car->brand }} {{ $car->model }}
                            </h2>

                            <!-- Price -->
                            <div class="flex items-end gap-2 mb-1">
                                <span class="text-[14px] font-bold {{ $car->stock == 0 ? 'text-gray-300 line-through' : 'text-yellow-700 dark:text-gray-100' }}">
                                    Rp{{ number_format($car->price, 0, ',', '.') }}
                                </span>
                                @if($car->stock == 0)
                                    <span class="text-xs text-rose-500 font-medium">Unavailable</span>
                                @endif
                            </div>

                            <!-- Category -->
                            <span class="inline-block mb-2 py-0.5 text-xs font-medium text-gray-700 dark:text-gray-200 rounded tracking-wide" style="letter-spacing: 0.07em;">
                                {{ $car->category }}
                            </span>

                            <!-- Colors -->
                            @if($car->colors->count())
                            <div>
                                <span class="text-xs font-medium text-gray-600 dark:text-gray-300">Colors:</span>
                                <ul class="flex flex-wrap gap-2 mt-1">
                                    @foreach ($car->colors as $color)
                                    <li class="flex items-center gap-1 px-2 py-0.5 text-xs rounded bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                                        <span class="inline-block w-3.5 h-3.5 rounded-full border border-gray-300 dark:border-gray-600" style="background: {{ $color->hex }}"></span>
                                        <span class="font-normal text-gray-700 dark:text-gray-300" style="font-size: 11.5px;">{{ $color->color_name }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <!-- Buttons -->
                            <div class="mt-5 flex justify-between items-center">
                                <a href="{{ route('pages.cars.show', $car->id) }}"
                                    class="text-xs font-semibold text-blue-900 dark:text-gray-100 hover:underline hover:text-cyan-600 dark:hover:text-cyan-400 transition"
                                    style="letter-spacing: 0.05em;">
                                    View Details →
                                </a>
                                <!-- Wishlist -->
                                @auth
                                <button
                                    class="wishlist-toggle-btn bg-transparent border-0 shadow-none outline-none p-0 m-0 ml-2 text-xl transition"
                                    data-car-id="{{ $car->id }}"
                                    aria-pressed="{{ $isWishlisted ? 'true' : 'false' }}"
                                    title="{{ $isWishlisted ? 'Remove from Wishlist' : 'Add to Wishlist' }}"
                                    style="line-height:1"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        class="w-6 h-6 align-middle transition
                                            {{ $isWishlisted ? 'fill-pink-500 stroke-pink-600' : 'fill-none stroke-gray-400 dark:stroke-gray-500' }}"
                                        stroke-width="1.7"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 3.75c-1.77 0-3.12 1.04-4.03 2.13C11.57 4.79 10.18 3.75 8.5 3.75A4.75 4.75 0 0 0 3.75 8.5c0 2.88 2.61 5.12 6.55 8.67l.57.5a2 2 0 0 0 2.26 0l.57-.5c3.94-3.55 6.55-5.79 6.55-8.67A4.75 4.75 0 0 0 16.5 3.75z"/>
                                    </svg>
                                </button>
                                @else
                                <a href="{{ route('login') }}" title="Login to wishlist"
                                    class="bg-transparent border-0 shadow-none outline-none p-0 m-0 ml-2 text-xl hover:text-pink-500 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        class="w-6 h-6 align-middle stroke-gray-300 dark:stroke-gray-500"
                                        fill="none" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 3.75c-1.77 0-3.12 1.04-4.03 2.13C11.57 4.79 10.18 3.75 8.5 3.75A4.75 4.75 0 0 0 3.75 8.5c0 2.88 2.61 5.12 6.55 8.67l.57.5a2 2 0 0 0 2.26 0l.57-.5c3.94-3.55 6.55-5.79 6.55-8.67A4.75 4.75 0 0 0 16.5 3.75z"/>
                                    </svg>
                                </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10 flex justify-center">
                {{ $cars->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Wishlist Toast Notification --}}
<div id="wishlist-toast"
    class="fixed z-50 left-1/2 -translate-x-1/2 bottom-6 bg-white dark:bg-gray-900 border border-pink-300 shadow-lg rounded-lg px-4 py-2 flex items-center space-x-2 text-pink-700 dark:text-pink-200 text-sm font-semibold opacity-0 pointer-events-none transition-all duration-300"
    style="min-width: 200px;"
    x-cloak>
    <i class="fa fa-heart"></i>
    <span id="wishlist-toast-message">Added to your Wishlist</span>
</div>
@endsection

@push('styles')
<style>
.car-card {
    transition: box-shadow 0.3s, transform 0.3s, border 0.3s, background 0.25s;
    will-change: transform;
}
.car-card:hover {
    box-shadow: 0 10px 32px 0 rgba(0,188,255,.11), 0 1.5px 8px 0 rgba(0,188,255,.08);
    border-color: #06b6d4 !important; /* cyan-600 */
    background: linear-gradient(120deg, #f0fdfa 0%, #f5f7fa 100%);
}
.car-exterior-img,
.car-interior-img {
    pointer-events: none;
    user-select: none;
    transition: opacity 0.5s, transform 0.5s;
}
.car-exterior-img { z-index: 10; }
.car-interior-img { z-index: 20; }
.wishlist-toggle-btn[aria-pressed="true"] svg {
    fill: #ec4899 !important;
    stroke: #db2777 !important;
}
.wishlist-toggle-btn[aria-pressed="false"] svg {
    fill: none !important;
    stroke: #c1c4c9 !important;
}
.wishlist-toggle-btn {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
}
.wishlist-toggle-btn:disabled {
    opacity: 0.5;
    pointer-events: none;
}
.wishlist-toggle-btn svg { transition: all 0.2s; }
@keyframes fade-in-down {
    0% { opacity: 0; transform: translateY(-10px);}
    100% { opacity: 1; transform: translateY(0);}
}
.animate-fade-in-down { animation: fade-in-down 0.7s cubic-bezier(.4,0,.2,1) both; }
@keyframes fade-in-slow { 0% { opacity: 0;} 100% { opacity: 1;} }
.animate-fade-in-slow { animation: fade-in-slow 1.2s ease-in; }
#wishlist-toast.show {
    opacity: 1 !important;
    pointer-events: auto;
    transform: translate(-50%, 0) scale(1);
}
#wishlist-toast {
    opacity: 0;
    pointer-events: none;
    transform: translate(-50%, 20px) scale(0.98);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
function showWishlistToast(message = "Added to your Wishlist") {
    const toast = document.getElementById('wishlist-toast');
    const toastMsg = document.getElementById('wishlist-toast-message');
    if (!toast || !toastMsg) return;
    toastMsg.textContent = message;
    toast.classList.add('show');
    setTimeout(() => {
        toast.classList.remove('show');
    }, 1800);
}
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.wishlist-toggle-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const carId = this.getAttribute('data-car-id');
            const isWishlisted = this.getAttribute('aria-pressed') === 'true';
            const url = isWishlisted
                ? '{{ url("/wishlist/remove") }}/' + carId
                : '{{ route('pages.wishlist.store') }}';

            this.disabled = true;
            let loaderSpan = document.getElementById(`wishlist-loader-${carId}`);
            if(loaderSpan) loaderSpan.classList.remove('hidden');

            if (!isWishlisted) {
                // ADD to wishlist
                axios.post(url, {
                    car_id: carId
                }, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    this.setAttribute('aria-pressed', 'true');
                    this.title = 'Remove from Wishlist';
                    this.querySelector('svg').classList.remove('fill-none', 'stroke-gray-300', 'dark:stroke-gray-500');
                    this.querySelector('svg').classList.add('fill-pink-500', 'stroke-pink-600');
                    showWishlistToast("Added to your Wishlist");
                })
                .catch(error => {
                    if (error.response && error.response.status === 401) {
                        window.location.href = '{{ route("login") }}';
                    } else {
                        alert(error.response?.data?.message || 'An unexpected error occurred.');
                    }
                })
                .finally(() => {
                    this.disabled = false;
                    if(loaderSpan) loaderSpan.classList.add('hidden');
                });
            } else {
                // REMOVE from wishlist
                axios.delete('/wishlist/' + carId, {
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(response => {
                    this.setAttribute('aria-pressed', 'false');
                    this.title = 'Add to Wishlist';
                    this.querySelector('svg').classList.remove('fill-pink-500', 'stroke-pink-600');
                    this.querySelector('svg').classList.add('fill-none', 'stroke-gray-300', 'dark:stroke-gray-500');
                    showWishlistToast("Removed from your Wishlist");
                })
                .catch(error => {
                    alert(error.response?.data?.message || 'An unexpected error occurred.');
                })
                .finally(() => {
                    this.disabled = false;
                    if(loaderSpan) loaderSpan.classList.add('hidden');
                });
            }
        });
    });
});
</script>
<script>
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        window.location.reload();
    }
});
</script>
@endpush
