@extends('layouts.user')

@section('title', 'Brochures')

@section('content')
<style>
.brochure-card {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.6s ease, transform 0.6s ease, box-shadow 0.3s ease, transform 0.3s ease;
  cursor: pointer;
}
.brochure-card.visible {
  opacity: 1;
  transform: translateY(0);
}
.brochure-card:hover {
  transform: scale(1.05);
  box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}
</style>

<!-- Hero Section -->
<div class="relative bg-cover bg-center py-20 pt-[120px]" style="background-image: url('{{ asset('images/brochure.jpg') }}');">
    <div class="absolute inset-0 bg-gray-200 bg-opacity-60"></div>
    <div class="relative container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-[#585858] mb-2">Venus Cars Brochures</h1>
        <p class="text-lg text-[#777]">Find a brochure that fits your interest</p>
    </div>
</div>

<!-- Brochure Grid -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse($brochures as $brochure)
                <div class="brochure-card text-center bg-gray-50 rounded shadow p-4">
                    <img src="{{ asset('storage/' . $brochure->image_path) }}" alt="{{ $brochure->title }}"
                        class="w-full h-48 object-cover rounded mb-3">
                    <h3 class="font-semibold text-lg mb-1">{{ $brochure->title }}</h3>
                    <p class="text-sm text-gray-500 mb-3">{{ $brochure->size }} MB</p>
                    <a href="{{ asset('storage/' . $brochure->pdf_path) }}" target="_blank"
                        class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 transition duration-200">
                        DOWNLOAD
                    </a>
                </div>
            @empty
                <p class="text-center col-span-full text-gray-500">Belum ada brosur yang tersedia.</p>
            @endforelse
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const cards = document.querySelectorAll('.brochure-card');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.1
  });

  cards.forEach(card => observer.observe(card));
});
</script>
@include('components.floating-menu')
@endsection

