@extends('layouts.dealer')

@section('content')
<div class="max-w-3xl mx-auto mt-10 px-4 sm:px-6 lg:px-8">
  <h2 class="text-3xl font-extrabold text-blue-900 mb-6 flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M3 13l2-2m0 0l7-7 7 7M13 5v6h6" />
    </svg>
    Edit
  </h2>
  <hr class="border-t-4 border-blue-700 mb-8 rounded">

  <form action="{{ route('pages.dealer.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg space-y-6">
    @csrf
    @method('PUT')

    <!-- Brand -->
    <div>
      <label for="brand" class="block text-sm font-semibold text-gray-700 mb-1">Brand</label>
      <input type="text" id="brand" name="brand" value="{{ $car->brand }}" required
        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Model -->
    <div>
      <label for="model" class="block text-sm font-semibold text-gray-700 mb-1">Model</label>
      <input type="text" id="model" name="model" value="{{ $car->model }}" required
        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Year -->
    <div>
      <label for="year" class="block text-sm font-semibold text-gray-700 mb-1">Year</label>
      <input type="number" id="year" name="year" value="{{ $car->year }}" required min="1900" max="{{ date('Y') }}"
        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Image -->
    <div>
      <label for="image" class="block text-sm font-semibold text-gray-700 mb-1">Image <span class="text-gray-400">(leave blank if not changing)</span></label>
      <input type="file" id="image" name="image" accept="image/*"
        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Current Image Preview -->
    @if($car->image)
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-2">Current Image</label>
      <img src="{{ asset('images/' . $car->image) }}" alt="Car Image"
        class="w-48 rounded-lg border border-gray-300 shadow-sm object-contain" />
    </div>
    @endif

    <!-- Category -->
    <div>
      <label for="category" class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
      <input type="text" id="category" name="category" value="{{ $car->category }}" required
        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Specifications -->
    <div>
      <label for="specifications" class="block text-sm font-semibold text-gray-700 mb-1">Specifications</label>
      <input type="text" id="specifications" name="specifications" value="{{ $car->specifications }}" required
        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Colors -->
    <div>
      <label for="color" class="block text-sm font-semibold text-gray-700 mb-1">Colors <span class="text-gray-400">(separate with commas)</span></label>
      @php
          $combinedColors = $car->colors->pluck('color_name')->implode(', ');
      @endphp
      <input type="text" id="color" name="color" value="{{ $combinedColors }}" required placeholder="Example: Red, Blue, Black"
        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Price -->
    <div>
      <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Price</label>
      <input type="number" id="price" name="price" value="{{ $car->price }}" required min="0"
        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Stock -->
    <div>
      <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1">Stock</label>
      <input type="number" id="stock" name="stock" value="{{ $car->stock }}" required min="0"
        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end">
      <button type="submit" 
        class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2 rounded-md shadow-md transition-colors duration-300">
        Update
      </button>
    </div>
  </form>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const form = document.querySelector('form');
      const imageInput = document.querySelector('input[name="image"]');

      form.addEventListener('submit', function (e) {
        const file = imageInput.files[0];
        if (file) {
          const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
          if (!allowedTypes.includes(file.type)) {
            e.preventDefault();
            Swal.fire({
              icon: 'error',
              title: 'Unsupported format',
              text: 'Please upload an image file (JPEG, JPG, or PNG).'
            });
            return;
          }

          if (file.size > 2 * 1024 * 1024) { // 2MB
            e.preventDefault();
            Swal.fire({
              icon: 'warning',
              title: 'File too large',
              text: 'The file size must not exceed 2MB.'
            });
            return;
          }
        }
      });
    });
  </script>
</div>
@endsection
