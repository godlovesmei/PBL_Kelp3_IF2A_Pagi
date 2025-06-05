@extends('layouts.user')

@section('title', 'Car Details')

@section('content')

<div x-data="{
    colors: {{ $car->colors->map(fn($color) => [
        'id' => $color->id,
        'name' => $color->color_name,
        'hex' => $color->hex ?? '#FFFFFF',
        'image' => asset('images/' . $color->image_path)
    ])->toJson() }},
    selectedColor: null,
    init() {
        this.selectedColor = this.colors[0] ?? { hex: '#FFFFFF', name: 'Default', image: '{{ asset('images/default-car.jpg') }}' };
    }
}">
    <!-- Car Section with Dynamic Background -->
    <div class="relative flex flex-col justify-between pt-[130px] pb-10">
        <!-- Dynamic Background -->
        <div :style="`background: linear-gradient(to bottom, ${selectedColor.hex.startsWith('#') ? selectedColor.hex : '#' + selectedColor.hex}, #ffffff 80%)`"
             class="absolute inset-0 -z-10 transition-colors duration-500"></div>

        <!-- Car Content Section -->
        <div class="text-center max-w-xl mx-auto">
            <h1 class="text-2xl font-bold mb-10">{{ $car->brand }} {{ $car->model }}</h1>

            <!-- Car Image -->
            <div class="relative overflow-hidden w-full">
                <img :src="selectedColor.image"
                     :alt="selectedColor.name"
                     class="mx-auto w-full max-w-md rounded-lg shadow-lg">
            </div>

            <!-- Color Name -->
            <div class="mt-4 text-center">
                <p class="text-lg font-medium"><span x-text="selectedColor.name"></span></p>
            </div>

            <!-- Price -->
            <p class="text-xl font-bold mt-6">Rp{{ number_format($car->price, 0, ',', '.') }}</p>
        </div>
    </div>

 <!-- Specifications Section -->
    <div class="bg-gray-50 text-center mt-30 p-6">
        <h2 class="text-xl font-semibold mb-4 mt-10">Specifications</h2>
        <div class="bg-gray-100 p-6 rounded-lg shadow-md inline-block text-left">
            @if(!empty($car->specifications))
                <ul class="text-sm text-gray-800 space-y-2 list-disc list-inside">
                    @foreach(explode(',', $car->specifications) as $spec)
                        <li>{{ trim($spec) }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Specifications are not available for this car.</p>
            @endif
        </div>
    </div>
</div>

    <!-- Form Section pakai komponen -->
<x-car-purchase-form :car="$car" :carPrice="$carPrice" />

    <!-- Notes -->
    <div class="bg-gray-50 text-center p-10">
        <h3 class="text-md font-semibold text-gray-800 mt-20">**Notes</h3>
        <ul class="text-xs text-gray-800 mt-2 space-y-2 list-inside list-disc">
            <li>The displayed price is the OTR Jakarta price for the first car ownership, and may change at any time without prior notice.</li>
            <li>Changes in color, materials, and features may occur at any time without prior notification.</li>
            <li>Specifications, features, and materials may differ from the actual vehicle being sold.</li>
        </ul>
    </div>
</div>

<!-- Script for carousel -->
<script>
    const carouselInner = document.querySelector('.carousel-inner');
    const totalSlides = carouselInner.children.length;
    let currentIndex = 0;

    function slideTo(index) {
        carouselInner.style.transform = `translateX(-${index * 100}%)`;
    }

    function autoSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        slideTo(currentIndex);
    }

    setInterval(autoSlide, 4000);
</script>
@include('components.floating-menu')
@endsection

