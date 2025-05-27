@extends('layouts.user')

@section('title', 'Home')

@section('content')
<!-- BANNER -->

<div class="relative min-h-screen flex flex-col pt-[63px]">
    <img src="{{ asset('images/accord3color.jpg') }}" alt="Banner" class="w-full shadow-md object-cover" />
    <div class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-30">
        <!-- Teks -->
        <div class="text-center sm:text-left px-4" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl font-bold mb-4">SOPHISTICATED
                MODERN INTERIOR</h2>
            <p class="text-sm sm:text-base text-gray-300 mb-6">
                It's totally new design with modern and sporty touch, that gives you a comfortable feeling wherever you go.
            </p>
            <a href="{{ route('pages.shop') }}" class="inline-block bg-black text-white font-bold px-6 py-2 rounded-full text-sm sm:text-base shadow-md hover:bg-red-600 hover:shadow-lg transition-all duration-300 ease-in-out">
                Learn More
            </a>
        </div>
    </div>
</div>

<!-- HERO SECTION -->
<section class="w-full bg-cover bg-center h-[500px] sm:h-[600px] pt-[80px]" style="background-image: url('{{ asset('images/banner_about.jpg') }}');">
    <div class="flex justify-center items-center w-full h-full bg-black bg-opacity-50" data-aos="fade-up">
        <div class="text-center text-white px-6">
            <h2 class="text-3xl sm:text-5xl font-bold mb-4" data-aos="fade-down">Find Your Dream Car</h2>
            <p class="text-sm sm:text-lg mb-6" data-aos="fade-up" data-aos-delay="200">Browse our wide selection of the best cars to suit your lifestyle and needs. Explore now to discover the perfect ride for you!</p>
            <a href="{{ route('pages.shop') }}" class="inline-block bg-black text-white font-bold px-8 sm:px-12 py-3 sm:py-4 rounded-full font-semibold text-lg sm:text-xl shadow-lg hover:bg-red-600 hover:shadow-xl transition-all duration-300 ease-in-out">
                Learn More
            </a>
        </div>
    </div>
</section>

<!-- Section with Two Images and Text -->
<section class="w-full bg-gray-100 py-10">
    <div class="container mx-auto grid grid-cols-1 sm:grid-cols-3 gap-6 items-center px-4">
        <!-- Gambar 1 -->
        <div class="flex justify-center" data-aos="fade-right">
            <img src="{{ asset('images/bumper.jpg') }}" alt="Image 1" class="rounded-lg shadow-lg object-cover h-auto max-h-[400px] w-full sm:w-auto">
        </div>

        <!-- Teks -->
        <div class="text-center sm:text-left px-4" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl font-bold mb-4">Sporty Bumper Design with Diffuser</h2>
            <p class="text-sm sm:text-base text-gray-700 mb-6">
                We transform our racing DNA into a sensational sports car that is aerodynamically attractive and stylistically confident than ever.
            </p>
            <a href="{{ route('pages.shop') }}" class="inline-block bg-black text-white font-bold px-6 py-2 rounded-full text-sm sm:text-base shadow-md hover:bg-red-600 hover:shadow-lg transition-all duration-300 ease-in-out">
                Learn More
            </a>
        </div>

        <!-- Gambar 2 -->
        <div class="flex justify-center" data-aos="fade-left">
            <img src="{{ asset('images/bumper2.jpg') }}" alt="Image 2" class="rounded-lg shadow-lg object-cover h-auto max-h-[400px] w-full sm:w-auto">
        </div>
    </div>
</section>

<!-- Section Fullscreen Image with Text -->
<section class="w-full bg-cover bg-center h-[500px] sm:h-[600px] pt-[80px]" style="background-image: url('{{ asset('images/bumper5.jpg') }}');">
    <div class="flex justify-center items-center w-full h-full bg-black bg-opacity-50" data-aos="fade-up">
        <div class="text-center text-white px-6">
            <h2 class="text-3xl sm:text-5xl font-bold mb-4" data-aos="fade-down">SENSATIONAL RACING DNA</h2>
            <p class="text-sm sm:text-lg mb-6" data-aos="fade-up" data-aos-delay="200">We transform our racing DNA into a sensational sports car that more aerodynamically attractive in every side and stylistically confident than ever.</p>
            <a href="{{ route('pages.shop') }}" class="inline-block bg-black text-white font-bold px-8 sm:px-12 py-3 sm:py-4 rounded-full font-semibold text-lg sm:text-xl shadow-lg hover:bg-red-600 hover:shadow-xl transition-all duration-300 ease-in-out">
                Learn More
            </a>
        </div>
    </div>
</section>

<!-- Section with Two Images and Text -->
<section class="w-full bg-gray-100 py-10">
    <div class="container mx-auto grid grid-cols-1 sm:grid-cols-3 gap-6 items-center px-4">
        <!-- Gambar 1 -->
        <div class="flex justify-center" data-aos="fade-right">
            <img src="{{ asset('images/bumper3.jpg') }}" alt="Image 1" class="rounded-lg shadow-lg object-cover h-auto max-h-[400px] w-full sm:w-auto">
        </div>

        <!-- Teks -->
        <div class="text-center sm:text-left px-4" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl font-bold mb-4">Type R Signature Plate</h2>
            <p class="text-sm sm:text-base text-gray-700 mb-6">
                All New Honda Civic Type R didesain dengan pelat nomor seri unik di setiap unitnya. Sehingga setiap kali Anda duduk di dalam kokpit, Anda akan diingatkan sebagai pemilik eksklusif dari edisi terbatas All New Honda Civic Type R.
            </p>
            <a href="{{ route('pages.shop') }}" class="inline-block bg-black text-white font-bold px-6 py-2 rounded-full text-sm sm:text-base shadow-md hover:bg-red-600 hover:shadow-lg transition-all duration-300 ease-in-out">
                Learn More
            </a>
        </div>

        <!-- Gambar 2 -->
        <div class="flex justify-center" data-aos="fade-left">
            <img src="{{ asset('images/bumper4.jpg') }}" alt="Image 2" class="rounded-lg shadow-lg object-cover h-auto max-h-[400px] w-full sm:w-auto">
        </div>
    </div>
</section>
@include('components.floating-menu')
@endsection

@push('styles')
<!-- AOS CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endpush

@push('scripts')
<!-- Alpine.js -->
<script src="https://unpkg.com/alpinejs" defer></script>

<!-- AOS.js -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS with custom options
    AOS.init({
        duration: 1000, // Duration of the animation (in milliseconds)
        once: false      // Animation happens only once
    });
</script>
@endpush