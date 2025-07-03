@extends('layouts.dealer')

@section('content')
    <div class="max-w-3xl mx-auto mt-12 bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-3xl font-extrabold text-blue-900 mb-8">Add New Brochure</h2>

        <form action="{{ route('pages.dealer.brochure.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                <input type="text" id="title" name="title" required
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="month" class="block text-sm font-semibold text-gray-700 mb-1">Release Month</label>
                <select id="month" name="month" required
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Month --</option>
                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $m)
                        <option value="{{ $m }}">{{ $m }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="year" class="block text-sm font-semibold text-gray-700 mb-1">Release Year</label>
                <input type="number" id="year" name="year" value="{{ old('year', date('Y')) }}" min="2000"
                    max="{{ date('Y') }}" required
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="pdf_path" class="block text-sm font-semibold text-gray-700 mb-1">PDF File</label>
                <input type="file" id="pdf_path" name="pdf_path" accept="application/pdf" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="image_path" class="block text-sm font-semibold text-gray-700 mb-1">Image (Optional)</label>
                <input type="file" id="image_path" name="image_path" accept="image/*"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2 rounded-md shadow-md transition-colors duration-300">
                    Save Brochure
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
    @endif
@endsection
