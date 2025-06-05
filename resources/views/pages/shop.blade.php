@extends('layouts.user')

@section('title', 'Shop')
@section('description', 'Explore our car catalog featuring the latest models, detailed specifications, and stunning images. Find your perfect car today!')

@section('content')
<div class="pt-[85px] px-4 max-w-screen-xl mx-auto">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filter -->
        <x-sidebar-filter :categories="$categories" />

        <!-- Car Catalog Content -->
        <div class="flex-1">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pt-6">
                @foreach ($cars as $car)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition duration-300" data-aos="zoom-in">
                    <!-- Car Image -->
                    <div class="relative">
                        <div class="flex items-center justify-center h-40 w-full bg-gray-100 overflow-hidden rounded-t-lg">
                            <img src="{{ asset('images/' . $car->image) }}" alt="{{ $car->brand }} {{ $car->model }}" class="h-full object-contain transition-transform duration-300 hover:scale-105">
                        </div>
                        <span class="absolute top-2 right-2 bg-gray-400 text-white text-xs px-2 py-1 rounded">{{ $car->year }}</span>
                    </div>

                    <!-- Car Info -->
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ $car->brand }} {{ $car->model }}</h2>
                        <p class="text-sm text-gray-600 mb-1">{{ $car->category }}</p>
                        <p class="font-semibold text-lg text-gray-900">Rp{{ number_format($car->price, 0, ',', '.') }}</p>

                        <!-- Car Colors -->
                        @if($car->colors->count())
                        <div class="mt-3">
                            <span class="text-sm font-medium text-gray-700">Colors:</span>
                            <ul class="flex flex-wrap gap-2 mt-2">
                                @foreach ($car->colors as $color)
                                <li class="px-2 py-1 text-xs rounded bg-gray-200">{{ $color->color_name }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Buttons -->
                        <div class="mt-4 flex flex-wrap gap-3 justify-between items-center">
                            <a href="{{ route('pages.cars.show', $car->id) }}" class="border-2 border-black rounded-full px-4 py-2 text-sm font-medium text-gray-800 hover:bg-black hover:text-white transition">Details</a>
                            @auth
                            <button class="addToWishlistBtn group border border-blue-300 text-pink-400 rounded-full p-2 hover:bg-pink-50 hover:text-pink-300 transition-all duration-300 ease-in-out shadow-sm hover:shadow-md transform hover:scale-105" data-car-id="{{ $car->id }}" title="Add to Wishlist" aria-label="Add to Wishlist">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.001 4.529c2.349-2.294 6.148-2.294 8.497 0 2.325 2.272 2.364 5.95.108 8.278l-7.915 8.095a.75.75 0 0 1-1.08 0l-7.916-8.095C1.137 10.479 1.175 6.8 3.5 4.529c2.349-2.294 6.148-2.294 8.501 0z" />
                                </svg>
                            </button>
                            @else
                            <a href="{{ route('login') }}" class="border-2 border-gray-500 text-gray-500 rounded-full px-4 py-2 text-sm font-medium hover:bg-gray-500 hover:text-white transition">Login to Add to Wishlist</a>
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
@include('components.floating-menu')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.querySelectorAll('.addToWishlistBtn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const carId = this.getAttribute('data-car-id');
            const originalContent = this.innerHTML;
            this.disabled = true;
            this.innerHTML = '<span class="animate-pulse">Processing...</span>';

            axios.post('{{ route('pages.wishlist.store') }}', {
                car_id: carId
            }, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                alert(response.data.message);
            })
            .catch(error => {
                if (error.response) {
                    alert(error.response.data.message || 'An unexpected error occurred.');
                    if (error.response.status === 401) {
                        window.location.href = '{{ route("login") }}';
                    }
                }
            })
            .finally(() => {
                this.disabled = false;
                this.innerHTML = originalContent;
            });
        });
    });
</script>
@endpush
