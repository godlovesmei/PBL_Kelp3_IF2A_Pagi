@extends('layouts.dealer')

@section('content')
<div class="w-full max-w-7xl mx-auto mt-10 px-2 sm:px-4 lg:px-8">
  <h2 class="text-3xl font-extrabold text-blue-900 mb-8">Edit Product</h2>
  <form action="{{ route('pages.dealer.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow-lg space-y-8">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
      <div>
        <label for="brand" class="block text-sm font-semibold text-gray-700 mb-1">Brand</label>
        <input type="text" id="brand" name="brand" required value="{{ old('brand', $car->brand) }}"
          class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div>
        <label for="model" class="block text-sm font-semibold text-gray-700 mb-1">Model</label>
        <input type="text" id="model" name="model" required value="{{ old('model', $car->model) }}"
          class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div>
        <label for="year" class="block text-sm font-semibold text-gray-700 mb-1">Year</label>
        <input type="number" id="year" name="year" required min="1900" max="{{ now()->year }}" value="{{ old('year', $car->year) }}"
          class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div>
        <label for="category" class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
        <select id="category" name="category" required
          class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="" disabled>-- Select Category --</option>
          @foreach (['MPV', 'Sedan', 'Sports', 'SUV', 'Hatchback'] as $cat)
            <option value="{{ $cat }}" {{ old('category', $car->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Price</label>
        <input type="number" id="price" name="price" required min="0" value="{{ old('price', $car->price) }}"
          class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div>
        <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1">Stock</label>
        <input type="number" id="stock" name="stock" required min="0" value="{{ old('stock', $car->stock) }}"
          class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
    </div>

    <div>
      <label for="image" class="block text-sm font-semibold text-gray-700 mb-1">Main Image <span class="text-gray-400">(leave blank if not changing)</span></label>
      <input type="file" id="image" name="image" accept="image/*"
        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        onchange="previewMainImage()" />
      <div id="main-image-preview" class="mt-2"></div>
      @if($car->image)
        <div class="mt-2">
          <label class="block text-xs text-gray-500 mb-0.5">Current Main Image</label>
          <img src="{{ asset('images/' . $car->image) }}" alt="Car Image"
            class="w-40 h-28 object-contain rounded-lg border border-gray-300 bg-gray-50 shadow-sm" />
        </div>
      @endif
    </div>

    <div>
      <label for="specifications" class="block text-sm font-semibold text-gray-700 mb-1">Specifications</label>
      <textarea id="specifications" name="specifications" required rows="4"
        class="w-full rounded-md border border-gray-300 px-4 py-2 resize-y focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('specifications', $car->specifications) }}</textarea>
    </div>

    {{-- Colors --}}
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">Colors</label>
      <div id="colors-wrapper" class="space-y-4">
        @php
          $oldColors = old('colors', $car->colors ?? []);
        @endphp
        @forelse($oldColors as $idx => $color)
        <div class="flex space-x-3 items-center">
          <input type="text" name="colors[{{ $idx }}][color_name]" placeholder="Color name" required value="{{ old("colors.$idx.color_name", is_array($color) ? $color['color_name'] : $color->color_name ?? '') }}"
            class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          <input type="text" name="colors[{{ $idx }}][hex]" placeholder="#hexcode" pattern="^#([A-Fa-f0-9]{6})$" title="Hex format like #FFFFFF" required value="{{ old("colors.$idx.hex", is_array($color) ? $color['hex'] : $color->hex ?? '') }}"
            class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 color-hex-input" oninput="updateColorPreview(this)" />
          <span class="inline-block w-8 h-8 rounded border ml-1 color-preview" style="background: {{ old("colors.$idx.hex", is_array($color) ? $color['hex'] : $color->hex ?? '') }}"></span>
          <input type="text" name="colors[{{ $idx }}][alt_hex]" placeholder="#alt_hex" pattern="^#([A-Fa-f0-9]{6})$" title="Hex format like #FFFFFF" required value="{{ old("colors.$idx.alt_hex", is_array($color) ? $color['alt_hex'] : $color->alt_hex ?? '') }}"
            class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 color-hex-input" oninput="updateColorPreview(this)" />
          <span class="inline-block w-8 h-8 rounded border ml-1 color-preview" style="background: {{ old("colors.$idx.alt_hex", is_array($color) ? $color['alt_hex'] : $color->alt_hex ?? '') }}"></span>
          <button type="button" onclick="removeColor(this)" class="text-red-600 font-bold text-xl px-2">&times;</button>
        </div>
        @empty
        <div class="flex space-x-3 items-center">
          <input type="text" name="colors[0][color_name]" placeholder="Color name" required
            class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          <input type="text" name="colors[0][hex]" placeholder="#hexcode" pattern="^#([A-Fa-f0-9]{6})$" title="Hex format like #FFFFFF" required
            class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 color-hex-input" oninput="updateColorPreview(this)" />
          <span class="inline-block w-8 h-8 rounded border ml-1 color-preview"></span>
          <input type="text" name="colors[0][alt_hex]" placeholder="#alt_hex" pattern="^#([A-Fa-f0-9]{6})$" title="Hex format like #FFFFFF" required
            class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 color-hex-input" oninput="updateColorPreview(this)" />
          <span class="inline-block w-8 h-8 rounded border ml-1 color-preview"></span>
          <button type="button" onclick="removeColor(this)" class="text-red-600 font-bold text-xl px-2">&times;</button>
        </div>
        @endforelse
      </div>
      <button type="button" onclick="addColor()"
        class="mt-3 bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700 transition">
        + Add Color
      </button>
    </div>

    <div class="flex justify-end">
      <button type="submit"
        class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-8 py-2 rounded-md shadow-md transition-colors duration-300 text-lg">
        Update
      </button>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/product/edit.js') }}"></script>
@endpush
