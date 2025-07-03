@extends('layouts.dealer')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow border">
    <h2 class="text-xl font-bold mb-6">
        Add {{ ucfirst($type) }} Image &mdash; {{ $car->brand }} {{ $car->model }}
    </h2>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dealer.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <input type="hidden" name="car_id" value="{{ $car->id }}">
        <input type="hidden" name="type" value="{{ $type }}">

        <div>
            <label for="image" class="block font-semibold mb-1">Image <span class="text-red-500">*</span></label>
            <input
                type="file"
                id="image"
                name="image"
                accept="image/*"
                required
                class="w-full border px-3 py-2 rounded @error('image') border-red-500 @enderror"
            >
        </div>

        <div>
            <label for="caption" class="block font-semibold mb-1">Caption (optional)</label>
            <input
                type="text"
                id="caption"
                name="caption"
                maxlength="255"
                value="{{ old('caption') }}"
                class="w-full border px-3 py-2 rounded @error('caption') border-red-500 @enderror"
            >
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded">
                Save Image
            </button>
            <a href="{{ route('dealer.gallery.index', ['car_id' => $car->id, 'type' => $type]) }}"
               class="text-gray-600 hover:text-blue-800 underline text-sm">Cancel</a>
        </div>
    </form>
</div>
@endsection
