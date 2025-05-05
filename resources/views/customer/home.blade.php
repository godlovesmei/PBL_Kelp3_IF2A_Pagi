@extends('layouts.customer')

@section('title', 'Home')

@section('content')
<!-- BANNER -->
<div class="min-h-screen flex flex-col pt-[63px] relative">
    <img src="{{ asset('images/banner_about.jpg') }}" alt="Banner" class="w-full shadow-md" />
</div>
<!-- HERO SECTION -->
<section class="w-full bg-cover bg-center h-[600px] pt-[80px]" style="background-image: url('{{ asset('images/hero-background.jpg') }}');">
    <div class="flex justify-center items-center w-full h-full bg-black bg-opacity-50" data-aos="fade-up">
        <div class="text-center text-white px-6">
            <h2 class="text-4xl font-bold mb-4" data-aos="fade-down">Find Your Dream Car</h2>
            <p class="text-lg mb-6" data-aos="fade-up" data-aos-delay="200">Browse our wide selection of the best cars to suit your lifestyle and needs. Explore now to discover the perfect ride for you!</p>
            <a href="{{ route('customer.shop') }}" class="inline-block bg-[#2D3748] text-white font-bold px-12 py-4 rounded-full font-semibold text-xl shadow-lg hover:bg-[#4A5568] hover:shadow-xl transition-all duration-300 ease-in-out" data-aos="zoom-in">
                Shop Now
            </a>
        </div>
    </div>
</section>

<!-- SECTION CAR LIST -->
<div class="w-full px-6 mt-10 pt-[150px] center mx-auto">
    <!-- Swiper -->
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            @foreach ($popularCars as $car)
            <div class="swiper-slide" data-aos="fade-up" data-aos-duration="1000">
                <img src="{{ asset('images/' . $car->image) }}" alt="{{ $car->brand }} {{ $car->model }}" class="w-full object-cover" data-aos="zoom-in" data-aos-duration="1000">
                <div class="p-4">
                    <h3 class="text-sm font-semibold text-black" data-aos="fade-up" data-aos-delay="100">{{ $car->model }}</h3>
                    <p class="text-xs text-black" data-aos="fade-up" data-aos-delay="200">{{ $car->category }} | Year {{ $car->year }}</p>
                    <p class="text-black font-bold mt-2" data-aos="fade-up" data-aos-delay="300">Rp {{ number_format($car->price, 0, ',', '.') }}</p>
                    <a href="{{ route('customer.cars.show', $car->id) }}" class="mt-4 inline-block bg-[#bfae91] text-white px-4 py-1 rounded-full text-sm hover:bg-[#a08f77] transition" data-aos="fade-up" data-aos-delay="400">
                        View Details
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Navigation buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
<!-- Floating Menu -->
<x-floating-menu />

@endsection

@push('styles')
<!-- AOS CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    /* Style for the swiper buttons */
    .swiper-button-next,
    .swiper-button-prev {
        background-color: rgba(0, 0, 0, 0.3);
        padding: 10px;
        border-radius: 50%;
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    /* Hover effect for swiper buttons */
    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        transform: scale(1.2);
        background-color: rgba(0, 0, 0, 0.5);
    }

    /* Hover effect for car images */
    .swiper-slide img {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .swiper-slide:hover img {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Hover effect for the "View Details" button */
    a:hover {
        background-color: #d1baa8;
        transform: scale(1.05);
        transition: transform 0.3s ease, background-color 0.3s ease;
    }
</style>
@endpush

@push('scripts')
<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,  // Duration for animation
        once: false       // Whether the animation should happen only once
    });

    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 },
        }
    });
</script>
@endpush