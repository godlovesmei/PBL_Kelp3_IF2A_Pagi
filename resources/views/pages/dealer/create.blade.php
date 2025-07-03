@extends('layouts.dealer')

@section('content')
<div class="w-full max-w-7xl mx-auto mt-10 px-2 sm:px-4 lg:px-8">
  <h2 class="text-3xl font-extrabold text-blue-900 mb-8">Add New Product</h2>
  <form action="{{ route('pages.dealer.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow-lg space-y-8">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
      <div>
        <label for="brand" class="block text-sm font-semibold text-gray-700 mb-1">Brand</label>
        <input type="text" id="brand" name="brand" required value="{{ old('brand') }}"
          class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div>
        <label for="model" class="block text-sm font-semibold text-gray-700 mb-1">Model</label>
        <input type="text" id="model" name="model" required value="{{ old('model') }}"
          class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div>
        <label for="year" class="block text-sm font-semibold text-gray-700 mb-1">Year</label>
        <input type="number" id="year" name="year" required min="1900" max="{{ now()->year }}" value="{{ old('year') }}"
          class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div>
        <label for="category" class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
        <select id="category" name="category" required
          class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="" disabled selected>-- Select Category --</option>
          @foreach (['MPV', 'Sedan', 'Sports', 'SUV', 'Hatchback'] as $cat)
            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Price</label>
        <input type="number" id="price" name="price" required min="0" value="{{ old('price') }}"
          class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
      <div>
        <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1">Stock</label>
        <input type="number" id="stock" name="stock" required min="0" value="{{ old('stock') }}"
          class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>
    </div>

    <div>
      <label for="image" class="block text-sm font-semibold text-gray-700 mb-1">Main Image</label>
      <input type="file" id="image" name="image" accept="image/*" required
        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
        onchange="previewMainImage()" />
      <div id="main-image-preview" class="mt-2"></div>
    </div>

    <div>
      <label for="specifications" class="block text-sm font-semibold text-gray-700 mb-1">Specifications</label>
      <textarea id="specifications" name="specifications" required rows="4"
        class="w-full rounded-md border border-gray-300 px-4 py-2 resize-y focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('specifications') }}</textarea>
    </div>

    {{-- Colors --}}
    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">Colors</label>
      <div id="colors-wrapper" class="space-y-4">
        <div class="flex space-x-3 items-center">
          <input type="text" name="colors[0][color_name]" placeholder="Color name" required value="{{ old('colors.0.color_name') }}"
            class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          <input type="text" name="colors[0][hex]" placeholder="#hexcode" pattern="^#([A-Fa-f0-9]{6})$" title="Hex format like #FFFFFF" required value="{{ old('colors.0.hex') }}"
            class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 color-hex-input" oninput="updateColorPreview(this)" />
          <span class="inline-block w-8 h-8 rounded border ml-1 color-preview" style="background: {{ old('colors.0.hex') }}"></span>
          <input type="text" name="colors[0][alt_hex]" placeholder="#alt_hex" pattern="^#([A-Fa-f0-9]{6})$" title="Hex format like #FFFFFF" required value="{{ old('colors.0.alt_hex') }}"
            class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 color-hex-input" oninput="updateColorPreview(this)" />
          <span class="inline-block w-8 h-8 rounded border ml-1 color-preview" style="background: {{ old('colors.0.alt_hex') }}"></span>
          <button type="button" onclick="removeColor(this)" class="text-red-600 font-bold text-xl px-2">&times;</button>
        </div>
      </div>
      <button type="button" onclick="addColor()"
        class="mt-3 bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700 transition">
        + Add Color
      </button>
    </div>

    <div class="flex justify-end">
      <button type="submit"
        class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-8 py-2 rounded-md shadow-md transition-colors duration-300 text-lg">
        Save
      </button>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/product/create.js') }}"></script>
@endpush
