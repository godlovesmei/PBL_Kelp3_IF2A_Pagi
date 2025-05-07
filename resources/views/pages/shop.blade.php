@extends('layouts.customer')

@section('title', 'Shop')

@section('content')
<div class="flex flex-row gap-8 pt-[85px] px-4 max-w-screen-xl mx-auto">
   <!-- Sidebar Filter -->
   <x-sidebar-filter :categories="$categories" />

   <!-- Car Catalog Content -->
   <div class="flex-2">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-7 pt-6">
         @foreach ($cars as $car)
         <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300" data-aos="zoom-in">
            <!-- Car Image -->
            <div class="relative">
               <div class="flex items-center justify-center h-40 w-full bg-gray-100 overflow-hidden rounded-t-lg">
                  <img src="{{ asset('images/' . $car->image) }}" 
                       alt="{{ $car->brand }} {{ $car->model }}" 
                       class="h-full object-contain transition-transform duration-300 hover:scale-105">
               </div>
               <span class="absolute top-2 right-2 bg-black text-white text-xs px-2 py-1 rounded">
                  {{ $car->year }}
               </span>
            </div>

            <!-- Car Info -->
            <div class="p-4">
               <h2 class="text-lg font-semibold mb-1 text-gray-800">{{ $car->model }}</h2>
               <p class="text-sm text-gray-600 mb-1">{{ $car->category }}</p>
               <p class="font-semibold text-lg text-gray-900">Rp{{ number_format($car->price, 0, ',', '.') }}</p>

               <!-- Car Colors -->
               @if($car->colors->count())
               <div class="mt-3">
                  <span class="text-sm font-medium text-gray-700">Available Colors:</span>
                  <ul class="flex flex-wrap gap-2 mt-2">
                     @foreach ($car->colors as $color)
                     <li class="w-5 h-5 rounded-full border border-gray-300" style="background-color: {{ $color->hex_code }};"></li>
                     @endforeach
                  </ul>
               </div>
               @endif

               <!-- Wishlist & Detail Button -->
               <div class="mt-4 flex justify-between items-center">
                  <a href="{{ route('pages.cars.show', $car->id) }}"
                     class="border-2 border-black rounded-full px-4 py-2 text-sm font-medium text-gray-800 hover:bg-black hover:text-white transition">
                     Details
                  </a>
                  <button class="addToWishlistBtn border-2 border-red-500 text-red-500 rounded-full px-4 py-2 text-sm font-medium hover:bg-red-500 hover:text-white transition"
                          data-car-id="{{ $car->id }}" data-car-model="{{ $car->model }}">
                     Add To Wishlist
                  </button>
               </div>
            </div>
         </div>
         @endforeach
      </div>

      <!-- Pagination -->
      <div class="mt-8 flex justify-center">
         {{ $cars->links() }}
      </div>
   </div>
</div>
<x-floating-menu />
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
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
   AOS.init({
      duration: 1000, // Duration for animation
      once: false // Animation triggers every time it appears in the viewport
   });
</script>
@endpush