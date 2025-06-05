@extends('layouts.dealer')

@section('content')
    <div class="mt-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <h2 class="mb-6 text-2xl font-bold uppercase text-blue-900 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-700" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2-2m0 0l7-7 7 7M13 5v6h6" />
            </svg>
            Brochures
        </h2>
        <div class="border-t-4 border-blue-700 mb-6"></div>

        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
            <!-- Tombol Add -->
            <a href="{{ route('pages.dealer.brochure.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded flex items-center justify-center sm:justify-start w-full sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add new brochure
            </a>

            <!-- Form Search -->
            <form action="{{ route('pages.dealer.brochure.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                    class="border border-gray-300 rounded px-3 py-2 w-full sm:w-64">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Search
                </button>
            </form>
        </div>

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

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-blue-100 text-blue-900 text-sm select-none">
                        <th class="px-4 py-3 border text-center">No</th>
                        <th class="px-4 py-3 border text-center">Image</th>
                        <th class="px-4 py-3 border text-center">PDF</th>
                        <th class="px-4 py-3 border">Title</th>
                        <th class="px-4 py-3 border text-center">Size</th>
                        <th class="px-4 py-3 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @forelse($brochures as $brochure)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 border text-center">
                                @if ($brochure->image_path)
                                    <img src="{{ asset('storage/' . $brochure->image_path) }}" class="max-h-20 mx-auto">
                                @else
                                    <span class="text-gray-400 italic">No image</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border text-center">
                                @if ($brochure->pdf_path)
                                    <a href="{{ asset('storage/' . $brochure->pdf_path) }}" target="_blank"
                                        class="text-blue-600 underline">
                                        View PDF
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">No file</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 border">{{ $brochure->title }}</td>
                            <td class="px-4 py-3 border text-center">{{ $brochure->size }} MB</td>
                            <td class="px-4 py-3 border text-center space-x-1">
                                <a href="{{ route('pages.dealer.brochure.edit', $brochure->id) }}"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs">
                                    Edit
                                </a>
                                <form action="{{ route('pages.dealer.brochure.destroy', $brochure->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="delete-btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">No brochures found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This brochure will be deleted.",
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
        });
    </script>
@endsection
