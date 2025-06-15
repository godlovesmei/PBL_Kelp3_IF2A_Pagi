@extends('layouts.user')

@section('title', 'About Us')
@section('description', 'Learn about PT Honda Prospect Motor, the sole agent for Honda in Indonesia, established in 1999. Discover our commitment to innovation and quality.')
@section('keywords', 'Honda, PT Honda Prospect Motor, About Us, Company Principles, Management Vision')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    html, body {
      scroll-behavior: smooth;
      box-sizing: border-box;
      width: 100%;
      overflow-x: hidden;
    }
    *, *::before, *::after {
      box-sizing: inherit;
    }
</style>
@endpush

@section('content')

<!-- Header -->
<div class="min-h-screen flex flex-col pt-[55px]">
<header class="py-24 px-4 sm:px-6 bg-gradient-to-r from-white via-white to-rose-100 text-center" data-aos="fade-down">
  <div class="max-w-3xl mx-auto" data-aos="zoom-in" data-aos-delay="200">
    <h1 class="text-4xl md:text-5xl font-semibold mb-6">PT Honda Prospect Motor</h1>
    <p class="text-lg md:text-xl leading-relaxed">
      The sole agent for the Honda brand in Indonesia, established in 1999, bringing innovation and the highest quality.
    </p>
  </div>
</header>

  <!-- Main Content -->
  <main class="flex-1">

    <!-- Company Principles -->
    <section class="py-20 px-4 sm:px-6 flex flex-col md:flex-row gap-12 items-center justify-center max-w-6xl mx-auto w-full">
      <div class="flex-1 max-w-xl w-full" data-aos="fade-right">
        <h2 class="text-3xl font-semibold border-2 border-black inline-block px-6 py-2 rounded-full">Company Principles</h2>
        <p class="mt-6 text-lg leading-relaxed">
          Providing high-quality products at affordable prices to global customers with a spirit of innovation.
        </p>
      </div>
      <div class="flex-1 max-w-md w-full" data-aos="fade-left">
        <img src="{{ asset('images/prinsip.jpg') }}" alt="Honda Building" class="rounded-xl shadow-md w-full object-cover" />
      </div>
    </section>

    <!-- Management Vision -->
<section class="py-20 px-4 sm:px-6 flex flex-col md:flex-row gap-12 items-center justify-center max-w-6xl mx-auto w-full">
  <div class="flex-1 max-w-xl w-full" data-aos="fade-right">
    <h2 class="text-3xl font-semibold border-2 border-black inline-block px-6 py-2 rounded-full">Management Vision</h2>
    <p class="mt-6 text-lg leading-relaxed">
      Striving to be a customer-oriented company and building high-quality standards for the company and its products.
    </p>
    <p class="mt-4 text-lg leading-relaxed">
      Creating partnerships that consistently seek workflow harmony and contribute to the development of Indonesia's automotive industry.
    </p>
    <p class="mt-4 text-lg leading-relaxed">
      Ensuring every employee is proud to work at PT Honda Prospect Motor while respecting every individual.
    </p>
  </div>
  <div class="flex-1 max-w-md w-full" data-aos="fade-left">
    <img src="{{ asset('images/about-2.png') }}" alt="Honda team joining hands" class="rounded-xl shadow-md w-full object-cover" />
  </div>
</section>

    <!-- Branding -->
    <section class="py-20 px-4 sm:px-6 bg-white" data-aos="fade-up">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row justify-center items-center md:gap-10 gap-6 w-full">

          <!-- Left -->
          <div class="text-center md:text-right md:w-1/2 w-full space-y-2">
            <div class="text-4xl font-bold text-[#428b97]">Venus Cars</div>
            <div class="text-lg font-medium tracking-wide text-gray-500">The Power of Dreams</div>
          </div>

          <!-- Right -->
          <div class="text-center md:text-left md:w-1/2 w-full space-y-2">
            <h1 class="text-3xl md:text-4xl font-bold text-black">How we move you.</h1>
            <div class="text-base font-semibold tracking-wider text-[#756b65]">CREATE ▸ TRANSCEND, AUGMENT</div>
          </div>

        </div>
      </section>

<!-- Dreams Chain -->
<section class="py-16 bg-white" data-aos="fade-up">
  <div class="flex flex-wrap justify-center items-start gap-6 sm:gap-10 px-2 sm:px-4 max-w-6xl mx-auto w-full">

    <!-- Dreams -->
    <div class="w-36 sm:w-48 text-center" data-aos="fade-up" data-aos-delay="100">
      <h2 class="text-3xl font-semibold">Dreams</h2>
      <p class="mt-1 text-sm text-gray-700">Every individual's dreams.</p>
    </div>

    <!-- CREATE -->
    <div class="w-36 sm:w-48 text-center" data-aos="fade-up" data-aos-delay="200">
      <h2 class="text-3xl font-semibold">CREATE</h2>
      <p class="mt-1 text-sm text-gray-700">Turning creativity into innovation to realize dreams.</p>
    </div>

    <!-- Arrow -->
    <div class="flex items-center justify-center w-10 pt-5" data-aos="fade-up" data-aos-delay="250">
      <span class="text-xl font-bold text-black">▸</span>
    </div>

    <!-- TRANSCEND -->
    <div class="w-36 sm:w-48 text-center" data-aos="fade-up" data-aos-delay="300">
      <h2 class="text-3xl font-semibold">TRANSCEND</h2>
      <p class="mt-1 text-sm text-gray-700">Surpassing the limitations of time and place.</p>
    </div>

    <!-- AUGMENT -->
    <div class="w-36 sm:w-48 text-center" data-aos="fade-up" data-aos-delay="400">
      <h2 class="text-3xl font-semibold">AUGMENT</h2>
      <p class="mt-1 text-sm text-gray-700">Enhancing human capabilities and potential.</p>
    </div>

  </div>

  <section class="max-w-4xl mx-auto px-2 sm:px-4 py-8 relative w-full">
    <div class="relative overflow-hidden rounded-3xl shadow-lg group">
      <img src="{{ asset('images/created.png') }}" alt="Honda Design" class="w-full object-cover transition-transform duration-700 group-hover:scale-105" />

      <span class="absolute top-4 left-4 bg-white/90 text-[#1a1a1a] text-2xl font-extrabold px-6 py-3 rounded-full shadow-lg tracking-widest
      opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-700">
        CREATE
      </span>

      <p class="absolute bottom-4 right-4 bg-white/90 text-black text-lg px-4 py-2 rounded-lg shadow-md max-w-md text-right leading-snug
      opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-700 delay-200">
        Honda continues to innovate without limits, creating solutions that inspire the future of mobility.
      </p>
    </div>
  </section>

  <section class="max-w-4xl mx-auto px-2 sm:px-4 py-8 relative w-full">
    <div class="relative overflow-hidden rounded-3xl shadow-lg group">
      <img src="{{ asset('images/transced.jpg') }}" alt="Honda Design" class="w-full object-cover transition-transform duration-700 group-hover:scale-105" />

      <span class="absolute top-4 left-4 bg-white/90 text-[#1a1a1a] text-2xl font-extrabold px-6 py-3 rounded-full shadow-lg tracking-widest
      opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-700">
        TRANSCEND
      </span>

      <p class="absolute bottom-4 right-4 bg-white/90 text-black text-lg px-4 py-2 rounded-lg shadow-md max-w-md text-right leading-snug
      opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-700 delay-200">
        Surpassing boundaries, exploring further because every journey is the beginning of new possibilities.
      </p>
    </div>
  </section>

  <section class="max-w-4xl mx-auto px-2 sm:px-4 py-8 relative w-full">
    <div class="relative overflow-hidden rounded-3xl shadow-lg group">
      <img src="{{ asset('images/augment.jpg') }}" alt="Honda Design" class="w-full object-cover transition-transform duration-700 group-hover:scale-105" />

      <span class="absolute top-4 left-4 bg-white/90 text-[#1a1a1a] text-2xl font-extrabold px-6 py-3 rounded-full shadow-lg tracking-widest
      opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-700">
        AUGMENT
      </span>

      <p class="absolute bottom-4 right-4 bg-white/90 text-black text-lg px-4 py-2 rounded-lg shadow-md max-w-md text-right leading-snug
      opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-700 delay-200">
        Transforming visions into reality, bringing technology closer to vivid dreams.
      </p>
    </div>
  </section>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
      duration: 1000,
      once: false
    });
</script>
@endpush
