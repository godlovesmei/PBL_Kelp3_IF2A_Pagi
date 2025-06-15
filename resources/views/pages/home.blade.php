@extends('layouts.user')

@section('title', 'Home')
@section('description', 'Discover the latest in modern and sporty car designs with Venus Cars. Explore our collection of sophisticated interiors and advanced features.')
@section('keywords', 'Venus Cars, Modern Cars, Sporty Cars, Sophisticated Interiors, Car Collection')

@section('content')

<!-- BANNER -->
<div class="relative min-h-screen flex flex-col pt-[55px]">
    <img src="{{ asset('images/accord3color.jpg') }}" alt="Banner" class="w-full shadow-md object-cover" />
    <div class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-30">
        <div class="text-center sm:text-left px-4 sm:px-12 max-w-screen-xl w-full" data-aos="fade-up">
            <h2 class="text-xl sm:text-3xl md:text-4xl font-bold mb-6 leading-tight">SOPHISTICATED MODERN INTERIOR</h2>
            <p class="text-base sm:text-lg text-gray-300 mb-8 max-w-xl leading-relaxed tracking-wide">
                It's totally new design with modern and sporty touch, that gives you a comfortable feeling wherever you go.
            </p>
            <a href="{{ route('pages.shop') }}"
               class="inline-block w-full sm:w-auto bg-black text-white font-bold px-8 py-3 rounded-full text-base sm:text-lg shadow-md hover:bg-red-600 hover:shadow-lg transition-all duration-300 ease-in-out">
               Learn More
            </a>
        </div>
    </div>
</div>

<!-- HERO SECTION -->
<section class="w-full bg-cover bg-center min-h-[500px] sm:min-h-[600px] pt-[80px]" style="background-image: url('{{ asset('images/banner_about.jpg') }}');">
    <div class="flex justify-center items-center w-full h-full bg-black bg-opacity-50" data-aos="fade-up">
        <div class="text-center text-white px-4 sm:px-12 max-w-screen-xl w-full">
            <h2 class="text-3xl sm:text-5xl font-bold mb-6 leading-tight" data-aos="fade-down">Find Your Dream Car</h2>
            <p class="text-base sm:text-lg mb-8 leading-relaxed tracking-wide" data-aos="fade-up" data-aos-delay="200">
                Browse our wide selection of the best cars to suit your lifestyle and needs. Explore now to discover the perfect ride for you!
            </p>
            <a href="{{ route('pages.shop') }}"
               class="inline-block w-full sm:w-auto bg-black text-white font-bold px-12 py-4 rounded-full text-lg sm:text-xl shadow-lg hover:bg-red-600 hover:shadow-xl transition-all duration-300 ease-in-out">
               Learn More
            </a>
        </div>
    </div>
</section>

<!-- SECTION 1 -->
<section class="w-full bg-gray-100 py-12">
    <div class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-y-10 md:gap-y-0 gap-x-6 md:gap-x-12 items-center px-4 sm:px-12">
        <!-- Image 1 -->
        <div class="aspect-[16/9] w-full max-w-md mx-auto md:mx-0 rounded-xl overflow-hidden shadow-lg" data-aos="fade-right">
            <img src="{{ asset('images/bumper.jpg') }}" alt="Sporty Bumper Design" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" />
        </div>

        <!-- Text -->
        <div class="text-center md:text-left px-0" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-6 leading-tight">Sporty Bumper Design with Diffuser</h2>
            <p class="text-base md:text-lg text-gray-700 mb-8 max-w-md mx-auto md:mx-0 leading-relaxed tracking-wide">
                We transform our racing DNA into a sensational sports car that is aerodynamically attractive and stylistically confident than ever.
            </p>
            <a href="{{ route('pages.shop') }}"
               class="inline-block w-full sm:w-auto bg-black text-white font-bold px-8 py-3 rounded-full text-base sm:text-lg shadow-md hover:bg-red-600 hover:shadow-lg transition-all duration-300 ease-in-out">
               Learn More
            </a>
        </div>

        <!-- Image 2 -->
        <div class="aspect-[16/9] w-full max-w-md mx-auto md:mx-0 rounded-xl overflow-hidden shadow-lg" data-aos="fade-left">
            <img src="{{ asset('images/bumper2.jpg') }}" alt="Sporty Bumper Diffuser" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" />
        </div>
    </div>
</section>

<!-- SECTION 2 -->
<section class="w-full bg-cover bg-center min-h-[500px] sm:min-h-[600px] pt-[80px]" style="background-image: url('{{ asset('images/bumper5.jpg') }}');">
    <div class="flex justify-center items-center w-full h-full bg-black bg-opacity-50" data-aos="fade-up">
        <div class="text-center text-white px-4 sm:px-12 max-w-screen-xl w-full">
            <h2 class="text-3xl sm:text-5xl font-bold mb-6 leading-tight" data-aos="fade-down">SENSATIONAL RACING DNA</h2>
            <p class="text-base sm:text-lg mb-8 max-w-xl mx-auto leading-relaxed tracking-wide" data-aos="fade-up" data-aos-delay="200">
                We transform our racing DNA into a sensational sports car that is more aerodynamically attractive on every side and stylistically confident than ever.
            </p>
            <a href="{{ route('pages.shop') }}"
               class="inline-block w-full sm:w-auto bg-black text-white font-bold px-12 py-4 rounded-full text-lg sm:text-xl shadow-lg hover:bg-red-600 hover:shadow-xl transition-all duration-300 ease-in-out">
               Learn More
            </a>
        </div>
    </div>
</section>

<!-- SECTION 3 -->
<section class="w-full bg-gray-100 py-12">
    <div class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-y-10 md:gap-y-0 gap-x-6 md:gap-x-12 items-center px-4 sm:px-12">
        <!-- Image 1 -->
        <div class="aspect-[16/9] w-full max-w-md mx-auto md:mx-0 rounded-xl overflow-hidden shadow-lg" data-aos="fade-right">
            <img src="{{ asset('images/bumper3.jpg') }}" alt="Type R Signature Plate" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" />
        </div>

        <!-- Text -->
        <div class="text-center md:text-left px-0" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-6 leading-tight">Type R Signature Plate</h2>
            <p class="text-base md:text-lg text-gray-700 mb-8 max-w-md mx-auto md:mx-0 leading-relaxed tracking-wide">
                The All New Honda Civic Type R is designed with a unique serial number plate on each unit. So every time you sit in the cockpit, you will be reminded of being the exclusive owner of the limited edition All New Honda Civic Type R.
            </p>
            <a href="{{ route('pages.shop') }}"
               class="inline-block w-full sm:w-auto bg-black text-white font-bold px-8 py-3 rounded-full text-base sm:text-lg shadow-md hover:bg-red-600 hover:shadow-lg transition-all duration-300 ease-in-out">
               Learn More
            </a>
        </div>

        <!-- Image 2 -->
        <div class="aspect-[16/9] w-full max-w-md mx-auto md:mx-0 rounded-xl overflow-hidden shadow-lg" data-aos="fade-left">
            <img src="{{ asset('images/bumper4.jpg') }}" alt="Type R Plate" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" />
        </div>
    </div>
</section>
@endsection

@push('styles')
<!-- AOS CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<!-- optional: global box-sizing for full safety -->
<style>
html, body {
  box-sizing: border-box;
  width: 100%;
  overflow-x: hidden;
}
*, *::before, *::after {
  box-sizing: inherit;
}
</style>
@endpush

@push('scripts')
<!-- Alpine.js -->
<script src="https://unpkg.com/alpinejs" defer></script>

<!-- AOS.js -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: false
    });
</script>
@endpush
