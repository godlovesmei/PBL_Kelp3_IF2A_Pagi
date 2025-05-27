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
           class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded flex items-center justify-center sm:justify-start w-full sm:w-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add new product
        </a>

        <div class="w-full sm:w-72">
            <input 
                type="text" 
                placeholder="Search cars..." 
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>
    </div>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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

    <!-- Table -->
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-blue-100 text-blue-900 text-sm select-none">
                    <th class="px-4 py-3 border whitespace-nowrap text-center">No</th>
                    <th class="px-4 py-3 border whitespace-nowrap text-center">Image</th>
                    <th class="px-4 py-3 border whitespace-nowrap">Brand</th>
                    <th class="px-4 py-3 border whitespace-nowrap">Model</th>
                    <th class="px-4 py-3 border whitespace-nowrap text-center">Year</th>
                    <th class="px-4 py-3 border whitespace-nowrap">Category</th>
                    <th class="px-4 py-3 border whitespace-nowrap text-right">Price</th>
                    <th class="px-4 py-3 border whitespace-nowrap text-center">Stock</th>
                    <th class="px-4 py-3 border whitespace-nowrap text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @foreach($cars as $car)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 border text-center whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 border text-center whitespace-nowrap">
                        <img 
                            src="{{ asset('images/' . $car->image) }}" 
                            alt="{{ $car->brand }} {{ $car->model }}" 
                            class="inline-block max-w-[80px] max-h-[56px] object-contain rounded"
                        >
                    </td>
                    <td class="px-4 py-3 border whitespace-nowrap">{{ $car->brand }}</td>
                    <td class="px-4 py-3 border whitespace-nowrap">{{ $car->model }}</td>
                    <td class="px-4 py-3 border text-center whitespace-nowrap">{{ $car->year }}</td>
                    <td class="px-4 py-3 border whitespace-nowrap">{{ $car->category }}</td>
                    <td class="px-4 py-3 border text-right whitespace-nowrap">Rp {{ number_format($car->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 border text-center whitespace-nowrap">{{ $car->stock }}</td>
                    <td class="px-4 py-3 border text-center whitespace-nowrap space-x-1">
                        <a href="{{ route('pages.dealer.edit', $car->id) }}" 
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs inline-block">
                            Edit
                        </a>
                        <form action="{{ route('pages.dealer.destroy', $car->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($cars->isEmpty())
                <tr>
                    <td colspan="9" class="text-center py-6 text-gray-500">No cars found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
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
    });
</script>
@endsection
