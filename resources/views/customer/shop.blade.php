@extends('layouts.customer')

@section('title', 'Shop')

@section('content')
<div class="flex flex-row gap-8 pt-[85px] px-4 max-w-screen-xl mx-auto">
    <!-- Sidebar -->
    <form action="{{ route('customer.shop') }}" method="GET" class="w-1/4 bg-white shadow-md rounded-lg p-4">
        <!-- CATEGORY Section -->
        <h3 class="font-semibold text-lg mb-4 text-gray-800">Category</h3>
        <ul class="space-y-2">
            @foreach ($categories as $category)
            <li class="flex items-center">
                <input id="category-{{ $category }}" type="checkbox" name="category[]" value="{{ $category }}"
                       class="mr-2 accent-blue-500 focus:ring focus:ring-blue-300"
                       {{ in_array($category, request()->get('category', [])) ? 'checked' : '' }}>
                <label for="category-{{ $category }}" class="text-sm font-medium text-gray-700 hover:text-blue-500 cursor-pointer">
                    {{ $category }}
                </label>
            </li>
            @endforeach
        </ul>

        <!-- PRICE Section -->
        <h3 class="font-semibold text-lg mt-6 mb-4 text-gray-800">Price</h3>
        <ul class="space-y-2">
            <li class="flex items-center">
                <input id="price-below-300" type="checkbox" name="price[]" value="<300"
                       class="mr-2 accent-green-500 focus:ring focus:ring-green-300"
                       {{ in_array('<300', request()->get('price', [])) ? 'checked' : '' }}>
                <label for="price-below-300" class="text-sm font-medium text-gray-700 hover:text-green-500 cursor-pointer">
                    Below 300 Million
                </label>
            </li>
            <li class="flex items-center">
                <input id="price-above-300" type="checkbox" name="price[]" value=">300"
                       class="mr-2 accent-green-500 focus:ring focus:ring-green-300"
                       {{ in_array('>300', request()->get('price', [])) ? 'checked' : '' }}>
                <label for="price-above-300" class="text-sm font-medium text-gray-700 hover:text-green-500 cursor-pointer">
                    Above 300 Million
                </label>
            </li>
            <li class="flex items-center">
                <input id="price-above-900" type="checkbox" name="price[]" value=">900"
                       class="mr-2 accent-green-500 focus:ring focus:ring-green-300"
                       {{ in_array('>900', request()->get('price', [])) ? 'checked' : '' }}>
                <label for="price-above-900" class="text-sm font-medium text-gray-700 hover:text-green-500 cursor-pointer">
                    Above 900 Million
                </label>
            </li>
        </ul>

        <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
            Apply Filters
        </button>
    </form>

    <!-- Car Catalog Content -->
    <div class="flex-2">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-7 pt-6">
            @foreach ($cars as $car)
            <div class="text-center">
                <div class="flex items-center justify-center h-40 w-full bg-white">
                    <img src="{{ asset('images/' . $car->image) }}"
                         alt="{{ $car->brand }} {{ $car->model }}"
                         class="h-full object-contain">
                </div>

                <h2 class="text-lg font-semibold mb-1 mt-4">{{ $car->model }}</h2>
                <p class="text-sm text-gray-600 mb-1">{{ $car->category }} - {{ $car->year }}</p>
                <p class="font-semibold">Rp{{ number_format($car->price, 0, ',', '.') }}</p>

                @if($car->colors->count())
                <div class="mt-2">
                    <span class="text-sm font-medium">Colors:</span>
                    <ul class="flex flex-wrap justify-center gap-1 mt-1">
                        @foreach ($car->colors as $color)
                        <li class="px-2 py-1 text-xs rounded bg-gray-200">{{ $color->color_name }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Wishlist & Detail Button -->
                <div class="mt-4 flex justify-center gap-2">
                    <a href="{{ route('customer.cars.show', $car->id) }}"
                       class="border-2 border-black rounded-full px-4 py-2 text-sm hover:bg-black hover:text-white transition">
                        Details
                    </a>
                    <button class="addToWishlistBtn border-2 border-black rounded-full px-4 py-2 text-sm hover:bg-black hover:text-white transition"
                            data-car-id="{{ $car->id }}" data-car-model="{{ $car->model }}">
                        Add To Wishlist
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $cars->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.addToWishlistBtn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const carId = this.getAttribute('data-car-id');
            const carModel = this.getAttribute('data-car-model');

            // Optional: Add AJAX functionality for adding to wishlist
            alert(`Added ${carModel} to your wishlist!`);
        });
    });
</script>
@endpush