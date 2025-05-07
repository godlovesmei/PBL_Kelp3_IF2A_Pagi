@extends('layouts.dealer')

@section('content')
<div class="mt-8">
    <h2 class="mb-6 text-2xl font-bold uppercase text-blue-900 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2-2m0 0l7-7 7 7M13 5v6h6" />
        </svg>
        Daftar Mobil
    </h2>
    <div class="border-t-4 border-blue-700 mb-6"></div>

    <!-- Actions -->
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('dealer.mobil.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Mobil
        </a>
        <div class="w-72">
            <input type="text" placeholder="Cari mobil..." class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                showConfirmButton: false,
                timer: 2000
            });
        });
    </script>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-blue-100 text-blue-900 text-sm">
                    <th class="px-4 py-3 border">No</th>
                    <th class="px-4 py-3 border">Gambar</th>
                    <th class="px-4 py-3 border">Merek</th>
                    <th class="px-4 py-3 border">Model</th>
                    <th class="px-4 py-3 border">Tahun</th>
                    <th class="px-4 py-3 border">Kategori</th>
                    <th class="px-4 py-3 border">Harga</th>
                    <th class="px-4 py-3 border">Stok</th>
                    <th class="px-4 py-3 border">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                @foreach($cars as $car)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 border text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 border">
                        <img src="{{ asset('images/' . $car->image) }}" class="w-20 h-14 object-cover rounded" alt="{{ $car->brand }} {{ $car->model }}">
                    </td>
                    <td class="px-4 py-3 border">{{ $car->brand }}</td>
                    <td class="px-4 py-3 border">{{ $car->model }}</td>
                    <td class="px-4 py-3 border text-center">{{ $car->year }}</td>
                    <td class="px-4 py-3 border">{{ $car->category }}</td>
                    <td class="px-4 py-3 border">Rp {{ number_format($car->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 border text-center">{{ $car->stock }}</td>
                    <td class="px-4 py-3 border text-center">
                        <a href="{{ route('dealer.mobil.edit', $car->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs">
                            Edit
                        </a>
                        <form action="{{ route('dealer.mobil.destroy', $car->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data mobil akan dihapus permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
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
