@extends('layouts.dealer')

@section('content')
<div class="max-w-6xl mx-auto px-4 pt-8">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-2">
            <a href="{{ route('pages.dealer.index') }}" class="text-blue-700 hover:underline flex items-center">
                <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to products
            </a>
            <h2 class="text-2xl font-bold text-blue-900">
                Gallery {{ ucfirst($type) }} &mdash; {{ $car->brand }} {{ $car->model }}
            </h2>
        </div>
        <a href="{{ route('dealer.gallery.create', ['car_id' => $car->id, 'type' => $type]) }}"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow text-sm">
            + Add Image
        </a>
    </div>

    @if($galleries->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            @foreach($galleries as $gallery)
                <div class="bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-lg shadow hover:shadow-md transition">
                    <a href="{{ asset('storage/galleries/' . $gallery->image_path) }}"
                       data-lightbox="gallery-{{ $type }}-{{ $car->id }}"
                       data-title="{{ $gallery->caption }}">
                        <img src="{{ asset('storage/galleries/' . $gallery->image_path) }}"
                             class="w-full h-36 object-cover rounded-t-lg"
                             alt="Gallery Image">
                    </a>
                    <div class="px-3 py-2 text-xs text-gray-600 dark:text-gray-300 flex justify-between items-start">
                        <span class="truncate w-32" title="{{ $gallery->caption ?? 'No caption' }}">
                            {{ $gallery->caption ?? 'No caption' }}
                        </span>
                        <div class="flex gap-2">
                            <a href="{{ route('dealer.gallery.edit', $gallery->id) }}"
                               class="text-blue-600 hover:text-blue-800 transition" title="Edit">
                                ✏️
                            </a>
                            <form action="{{ route('dealer.gallery.destroy', $gallery->id) }}" method="POST"
                                  onsubmit="return confirm('Delete this image?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Delete">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="py-10 text-center text-gray-400 text-lg">
            No images found for this type.
        </div>
    @endif
</div>

<!-- Lightbox2 -->
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2/dist/css/lightbox.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2/dist/js/lightbox.min.js"></script>
@endsection
