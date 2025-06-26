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
        <svg class="w-16 h-16 text-cyan-600 dark:text-cyan-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75h.008v.008H9.75V9.75zm4.5 0h.008v.008h-.008V9.75zM21 12a9 9 0 11-18 0 9 9 0 0118 0zM8.25 15s1.125-1.5 3.75-1.5 3.75 1.5 3.75 1.5" />
        </svg>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            No results found
        </h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm">
            We couldn't find any cars matching your search. Try adjusting the filters.
        </p>
        <a href="{{ route('pages.shop') }}"
           class="mt-2 inline-flex items-center px-4 py-2 bg-cyan-700 hover:bg-cyan-900 text-white text-sm font-medium rounded-lg transition focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2">
            Reset Filters
        </a>
    </div>
@endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pt-6">
            @foreach ($cars as $car)
                @php
                    $isWishlisted = isset($wishlistedCarIds) && in_array($car->id, $wishlistedCarIds);
                @endphp
                <div
                    class="bg-white rounded-lg shadow transition duration-300 group hover:shadow-xl hover:scale-[1.025] hover:border-slate-400 border border-transparent relative overflow-hidden"
                    data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}"
                    style="will-change: transform;"
                >
                    <!-- Car Image -->
                    <div class="relative">
                        <div class="flex items-center justify-center h-40 w-full bg-white overflow-hidden rounded-t-lg">
                            <img src="{{ asset('images/' . $car->image) }}"
                                 alt="{{ $car->brand }} {{ $car->model }}"
                                 class="h-full object-contain transition-transform duration-300 group-hover:scale-110 group-hover:brightness-110 group-hover:contrast-125"
                            >
                        </div>
                        <span class="absolute top-2 right-2 bg-gray-500/80 text-white text-xs px-2 py-1 rounded animate-fade-in-down">{{ $car->year }}</span>
                    </div>

                    <!-- Car Info -->
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800 mb-1 group-hover:text-cyan-700 transition-colors duration-200">
                            {{ $car->brand }} {{ $car->model }}
                        </h2>
                        <p class="font-semibold text-lg text-gray-900 group-hover:text-cyan-600 transition-colors duration-200">
                            Rp{{ number_format($car->price, 0, ',', '.') }}
                        </p>

                        <!-- Car Colors -->
                        @if($car->colors->count())
                        <div class="mt-3">
                            <span class="text-sm font-medium text-gray-700">Colors:</span>
                            <ul class="flex flex-wrap gap-2 mt-2">
                                @foreach ($car->colors as $color)
                                <li class="px-2 py-1 text-xs rounded bg-gray-200 animate-fade-in-slow">
                                    {{ $color->color_name }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

<!-- Buttons -->
<div class="mt-4 flex justify-between items-center">
    <a href="{{ route('pages.cars.show', $car->id) }}"
        class="text-sm font-medium text-cyan-700 hover:underline">
        View Details →
    </a>

    <!-- Wishlist -->
    @auth
    <button
        class="wishlist-toggle-btn p-2 rounded-full hover:bg-pink-50 transition"
        data-car-id="{{ $car->id }}"
        aria-pressed="{{ $isWishlisted ? 'true' : 'false' }}"
        title="{{ $isWishlisted ? 'Remove from Wishlist' : 'Add to Wishlist' }}"
    >
        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             class="w-5 h-5 transition
             {{ $isWishlisted ? 'fill-pink-500 stroke-pink-500' : 'fill-none stroke-pink-400' }}"
             stroke-width="2"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16.5 3.75c-1.77 0-3.12 1.04-4.03 2.13C11.57 4.79 10.18 3.75 8.5 3.75A4.75 4.75 0 0 0 3.75 8.5c0 2.88 2.61 5.12 6.55 8.67l.57.5a2 2 0 0 0 2.26 0l.57-.5c3.94-3.55 6.55-5.79 6.55-8.67A4.75 4.75 0 0 0 16.5 3.75z"/>
        </svg>
    </button>
    @else
    <a href="{{ route('login') }}" title="Login to wishlist"
        class="p-2 rounded-full hover:bg-gray-100 transition">
        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             class="w-5 h-5 stroke-pink-400"
             fill="none" stroke-width="2" stroke="currentColor">
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
     class="fixed z-50 left-1/2 -translate-x-1/2 bottom-6 bg-white dark:bg-gray-900 border border-pink-300 shadow-lg rounded-lg px-4 py-2 flex items-center space-x-2 text-pink-700 dark:text-pink-300 text-sm font-semibold opacity-0 pointer-events-none transition-all duration-300"
     style="min-width: 200px;"
     x-cloak>
    <i class="fa fa-heart"></i>
    <span id="wishlist-toast-message">Added to your Wishlist</span>
</div>
@endsection

@push('styles')
<style>
.wishlist-toggle-btn[aria-pressed="true"] svg {
    fill: #ec4899 !important; /* tailwind pink-500 */
    stroke: #ec4899 !important;
}
.wishlist-toggle-btn[aria-pressed="false"] svg {
    fill: none !important;
    stroke: #f472b6 !important; /* tailwind pink-400 */
}
.wishlist-toggle-btn[aria-pressed="true"] {
    background: #fdf2f8 !important; /* pink-50 */
    border-color: #f472b6 !important; /* pink-400 */
}
.wishlist-toggle-btn[aria-pressed="false"] {
    background: #fff !important;
    border-color: #e5e7eb !important; /* gray-200 */
}
.wishlist-toggle-btn:disabled {
    opacity: 0.6;
    pointer-events: none;
}
@keyframes fade-in-down {
    0% {
        opacity: 0;
        transform: translateY(-10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fade-in-down {
    animation: fade-in-down 0.7s cubic-bezier(.4,0,.2,1) both;
}
@keyframes fade-in-slow {
    0% { opacity: 0; }
    100% { opacity: 1; }
}
.animate-fade-in-slow {
    animation: fade-in-slow 1.2s ease-in;
}
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
                    this.querySelector('svg').classList.remove('fill-none', 'stroke-pink-400');
                    this.querySelector('svg').classList.add('fill-pink-500', 'stroke-pink-500');
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
                    this.querySelector('svg').classList.remove('fill-pink-500', 'stroke-pink-500');
                    this.querySelector('svg').classList.add('fill-none', 'stroke-pink-400');
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
