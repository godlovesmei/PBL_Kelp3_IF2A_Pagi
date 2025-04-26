@extends('layouts.customer')

@section('title', 'Car-Detail')

@section('content')

<div class="bg-gray-50 py-10 px-4 flex justify-center">
    <div class="text-center max-w-xl">
        <h1 class="text-2xl font-bold mb-10">{{ $car->brand }} {{ $car->model }}</h1>

        <!-- Carousel -->
        <div id="banner-carousel" class="relative overflow-hidden w-full">
            <div class="carousel-inner flex transition-transform duration-1000 ease-in-out">
                @foreach($car->gallery as $image)
                    <img src="{{ asset('images/' . $image) }}" 
                         alt="{{ $car->brand }} {{ $car->model }}" 
                         class="flex-shrink-0 w-full h-auto">
                @endforeach
            </div>
        </div>

        <!-- Harga -->
        <p class="text-xl font-bold mt-6">Rp{{ number_format($car->price, 0, ',', '.') }}</p>

        <!-- Spesifikasi -->
        <h2 class="text-xl font-semibold mb-4 mt-10">Spesifikasi</h2>
        <div class="bg-gray-100 p-6 rounded-lg text-left">
            <ul class="text-sm text-gray-800 space-y-2 list-disc list-inside">
                <li>{{ $car->engine ?? 'N/A' }}</li>
                <li>{{ $car->transmission ?? 'N/A' }}</li>
                <li>{{ $car->driving_mode ?? 'N/A' }}</li>
                <li>{{ $car->wheels ?? 'N/A' }}</li>
                <li>{{ $car->features ?? 'N/A' }}</li>
            </ul>
        </div>
    </div>
</div>

<!-- Script untuk carousel -->
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
@endsection