@extends('layouts.dealer')

@section('content')
    <div class="max-w-3xl mx-auto mt-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-blue-900 mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-700" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
            </svg>
            Edit Brochure
        </h2>
        <hr class="border-t-4 border-blue-700 mb-8 rounded">

        <form action="{{ route('pages.dealer.brochure.update', $brochure->id) }}" method="POST"
            enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-lg space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                <input type="text" id="title" name="title" value="{{ $brochure->title }}" required
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            {{-- Release Month --}}
            <div>
                <label for="month" class="block text-sm font-semibold text-gray-700 mb-1">Release Month</label>
                <select id="month" name="month" required
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Select Month --</option>
                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $m)
                        <option value="{{ $m }}" {{ $brochure->month == $m ? 'selected' : '' }}>
                            {{ $m }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Release Year --}}
            <div>
                <label for="year" class="block text-sm font-semibold text-gray-700 mb-1">Release Year</label>
                <input type="number" id="year" name="year" value="{{ old('year', $brochure->year) }}"
                    min="2000" max="{{ date('Y') }}" required
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- File Upload -->
            <div>
                <label for="file" class="block text-sm font-semibold text-gray-700 mb-1">Brochure File <span
                        class="text-gray-400">(leave blank if not changing)</span></label>
                <input type="file" id="file" name="file" accept=".pdf,.doc,.docx"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-1">Brochure Image <span
                        class="text-gray-400">(leave blank if not changing)</span></label>
                <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Current File Preview -->
            @if ($brochure->file)
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Current File</label>
                    <a href="{{ Storage::url($brochure->file) }}" target="_blank" class="text-blue-600 underline">
                        {{ basename($brochure->file) }}
                    </a>
                </div>
            @endif

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
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form');
                const fileInput = document.querySelector('input[name="file"]');
                const imageInput = document.querySelector('input[name="image"]');

                form.addEventListener('submit', function(e) {
                    const file = fileInput.files[0];
                    const image = imageInput.files[0];

                    const docTypes = [
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                    ];
                    const imageTypes = ['image/jpeg', 'image/png'];

                    if (file && !docTypes.includes(file.type)) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Unsupported document format',
                            text: 'Upload must be PDF, DOC, or DOCX.'
                        });
                        return;
                    }

                    if (file && file.size > 5 * 1024 * 1024) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Document too large',
                            text: 'Max size is 5MB.'
                        });
                        return;
                    }

                    if (image && !imageTypes.includes(image.type)) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Unsupported image format',
                            text: 'Image must be JPG or PNG.'
                        });
                        return;
                    }

                    if (image && image.size > 3 * 1024 * 1024) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Image too large',
                            text: 'Max image size is 3MB.'
                        });
                        return;
                    }
                });
            });
        </script>
    </div>
@endsection
