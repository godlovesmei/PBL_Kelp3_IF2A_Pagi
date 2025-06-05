@extends('layouts.dealer')

@section('content')
<div class="max-w-3xl mx-auto mt-12 bg-white p-8 rounded-xl shadow-lg">
  <h2 class="text-3xl font-extrabold text-blue-900 mb-8">Add new product</h2>

  <form action="{{ route('pages.dealer.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div>
      <label for="brand" class="block text-sm font-semibold text-gray-700 mb-1">Brand</label>
      <input type="text" id="brand" name="brand" required
        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <div>
      <label for="model" class="block text-sm font-semibold text-gray-700 mb-1">Model</label>
      <input type="text" id="model" name="model" required
        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <div>
      <label for="year" class="block text-sm font-semibold text-gray-700 mb-1">Year</label>
      <input type="number" id="year" name="year" required min="1900" max="{{ date('Y') }}"
        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <div>
      <label for="image" class="block text-sm font-semibold text-gray-700 mb-1">Image</label>
      <input type="file" id="image" name="image" accept="image/*" required
        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <div>
      <label for="category" class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
      <select id="category" name="category" required
        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="" disabled selected>-- Select Category --</option>
        <option value="MPV">MPV</option>
        <option value="Sedan">Sedan</option>
        <option value="Sports">Sports</option>
        <option value="SUV">SUV</option>
      </select>
    </div>

    <div>
      <label for="specifications" class="block text-sm font-semibold text-gray-700 mb-1">Specifications</label>
      <textarea id="specifications" name="specifications" required rows="4"
        class="w-full rounded-md border border-gray-300 px-4 py-2 resize-y focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
    </div>

    <div>
      <label class="block text-sm font-semibold text-gray-700 mb-1">Colors</label>

      <div id="colors-wrapper" class="space-y-4">
        <div class="flex space-x-3 items-center">
          <input type="text" name="colors[0][color_name]" placeholder="Color name" required
            class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          <input type="text" name="colors[0][hex]" placeholder="#hexcode" pattern="^#([A-Fa-f0-9]{6})$" required
            class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          <input type="text" name="colors[0][alt_hex]" placeholder="#alt_hex" pattern="^#([A-Fa-f0-9]{6})$" required
            class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
          <button type="button" onclick="removeColor(this)" class="text-red-600 font-bold text-xl px-2">&times;</button>
        </div>
      </div>

      <button type="button" onclick="addColor()"
        class="mt-3 bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700 transition">
        + Add color
      </button>
    </div>

    <div>
      <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Price</label>
      <input type="number" id="price" name="price" required min="0"
        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <div>
      <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1">Stock</label>
      <input type="number" id="stock" name="stock" required min="0"
        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <div class="flex justify-end">
      <button type="submit"
        class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2 rounded-md shadow-md transition-colors duration-300">
        Save
      </button>
    </div>
  </form>
</div>

<script>
  let colorIndex = 1;

  function addColor() {
    const wrapper = document.getElementById('colors-wrapper');
    const div = document.createElement('div');
    div.className = 'flex space-x-3 items-center mt-2';

    div.innerHTML = `
      <input type="text" name="colors[${colorIndex}][color_name]" placeholder="Color name" required
        class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      <input type="text" name="colors[${colorIndex}][hex]" placeholder="#hexcode" pattern="^#([A-Fa-f0-9]{6})$" required
        class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      <input type="text" name="colors[${colorIndex}][alt_hex]" placeholder="#alt_hex" pattern="^#([A-Fa-f0-9]{6})$" required
        class="w-1/3 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      <button type="button" onclick="removeColor(this)" class="text-red-600 font-bold text-xl px-2">&times;</button>
    `;

    wrapper.appendChild(div);
    colorIndex++;
  }

  function removeColor(button) {
    const div = button.parentElement;
    div.remove();
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'success',
      title: 'Success!',
      text: '{{ session("success") }}',
      showConfirmButton: false,
      timer: 2000
    });
  });
</script>
@endif
@endsection
