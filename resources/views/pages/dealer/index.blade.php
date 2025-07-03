@extends('layouts.dealer')

@section('content')
<div class="mt-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <h2 class="mb-6 text-2xl font-bold uppercase text-blue-900 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2-2m0 0l7-7 7 7M13 5v6h6" />
        </svg>
        Products
    </h2>
    <div class="border-t-4 border-blue-700 mb-6"></div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
        <a href="{{ route('pages.dealer.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded flex items-center justify-center sm:justify-start w-full sm:w-auto transition duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add new product
        </a>
        <form method="GET" class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search brand/model..."
                class="w-full sm:w-60 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400"
            >
            <select
                name="category"
                onchange="this.form.submit()"
                class="w-full sm:w-40 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-600"
            >
                <option value="">All Categories</option>
                <option value="SUV" {{ request('category') == 'SUV' ? 'selected' : '' }}>SUV</option>
                <option value="Sedan" {{ request('category') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                <option value="MPV" {{ request('category') == 'MPV' ? 'selected' : '' }}>MPV</option>
                <option value="Sports" {{ request('category') == 'Sports' ? 'selected' : '' }}>Sports</option>
                <option value="Hatchback" {{ request('category') == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
            </select>
        </form>
    </div>

    <!-- GRID CARD VIEW -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse($cars as $car)
        <div class="bg-white border rounded-lg shadow p-4 flex flex-col transition-transform duration-200 hover:scale-105 hover:shadow-lg relative overflow-hidden group">
            <!-- OUT OF STOCK BADGE -->
            @if($car->stock == 0)
                <span class="absolute top-3 right-3 bg-red-600 text-white text-xs px-3 py-1 rounded-full z-10 font-bold shadow-lg animate-pulse">
                    OUT OF STOCK
                </span>
            @endif
            <!-- MAIN IMAGE -->
            <div class="relative mb-3">
                <a href="{{ $car->image ? asset('images/' . $car->image) : asset('images/no-image.png') }}" data-lightbox="car-{{ $car->id }}" data-title="{{ $car->brand }} {{ $car->model }}">
                    <img
                        src="{{ $car->image ? asset('images/' . $car->image) : asset('images/no-image.png') }}"
                        alt="{{ $car->brand }} {{ $car->model }}"
                        class="w-full h-40 object-cover rounded-md main-car-image transition-transform duration-200 group-hover:scale-105"
                    >
                </a>

                @php
                  $exteriors = $car->galleries->where('type', 'eksterior');
                  $interiors = $car->galleries->where('type', 'interior');
                @endphp

                <div class="flex gap-3 mt-2">
                  {{-- Exterior Thumbnail & Link --}}
                  <div class="flex gap-1 items-center">
                    @if($exteriors->count() > 0)
                      <img src="{{ asset('storage/galleries/' . $exteriors->first()->image_path) }}" alt="Exterior"
                           class="w-10 h-10 object-cover rounded border-2 border-blue-200 shadow" />
                    @endif
                    <a href="{{ route('dealer.gallery.index', ['car_id' => $car->id, 'type' => 'eksterior']) }}"
                       class="text-xs text-blue-700 underline hover:text-blue-900">
                      {{ $exteriors->count() > 0 ? 'View all ('.$exteriors->count().') Exterior' : 'Edit Exterior' }}
                    </a>
                  </div>
                  {{-- Interior Thumbnail & Link --}}
                  <div class="flex gap-1 items-center">
                    @if($interiors->count() > 0)
                      <img src="{{ asset('storage/galleries/' . $interiors->first()->image_path) }}" alt="Interior"
                           class="w-10 h-10 object-cover rounded border-2 border-pink-200 shadow" />
                    @endif
                    <a href="{{ route('dealer.gallery.index', ['car_id' => $car->id, 'type' => 'interior']) }}"
                       class="text-xs text-pink-700 underline hover:text-pink-900">
                      {{ $interiors->count() > 0 ? 'View all ('.$interiors->count().') Interior' : 'Edit Interior' }}
                    </a>
                  </div>
                </div>
            </div>
            <!-- CAR INFO -->
            <div class="flex-1">
                <div class="flex items-center justify-between mb-1">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">{{ $car->category }}</span>
                    <span class="text-gray-500 text-xs">{{ $car->year }}</span>
                </div>
                <div class="font-bold text-lg text-blue-900 mb-1">{{ $car->brand }} {{ $car->model }}</div>
                <div class="mb-2">
                    <span class="text-sm text-gray-600">Stock: </span>
                    <span class="font-semibold {{ $car->stock == 0 ? 'text-red-600' : 'text-green-700' }}">{{ $car->stock }}</span>
                </div>
                <div class="text-xl font-bold {{ $car->stock == 0 ? 'text-gray-400 line-through' : 'text-green-700' }} mb-2">Rp {{ number_format($car->price, 0, ',', '.') }}</div>
            </div>
            <!-- ACTIONS -->
            <div class="flex gap-2 mt-2">
                <a href="{{ route('pages.dealer.edit', $car->id) }}"
                   class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-2 rounded text-xs font-semibold flex items-center justify-center gap-1 transition duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-2.036a2.5 2.5 0 113.536 3.536L7.5 21H3v-4.5L16.732 6.732z"/></svg>
                    Edit
                </a>
                <form action="{{ route('pages.dealer.destroy', $car->id) }}" method="POST" class="flex-1 inline-block form-delete">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-xs font-semibold flex items-center justify-center gap-1 delete-btn transition duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-6 text-gray-500">No cars found.</div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $cars->appends(request()->query())->links() }}
    </div>
</div>

<!-- SweetAlert2 + Lightbox2 -->
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2/dist/css/lightbox.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2/dist/js/lightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                Swal.fire({
                    title: 'Are you sure you want to delete?',
                    text: "This car data will be permanently deleted.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });
        // No custom JS for gallery/lightbox needed!
    });
</script>
@endsection
