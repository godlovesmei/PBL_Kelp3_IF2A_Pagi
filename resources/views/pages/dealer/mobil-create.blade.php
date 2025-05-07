@extends('layouts.dealer')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Mobil</h2>
    <form action="{{ route('dealer.mobil.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-1">Merek</label>
            <input type="text" name="brand" class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-1">Model</label>
            <input type="text" name="model" class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-1">Tahun</label>
            <input type="number" name="year" class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-1">Gambar</label>
            <input type="file" name="image" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-1">Kategori</label>
            <select name="category" class="w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="MPV">MPV</option>
                <option value="Sedan">Sedan</option>
                <option value="Sports">Sports</option>
                <option value="SUV">SUV</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-1">Spesifikasi</label>
            <textarea name="specifications" class="w-full border-gray-300 rounded-md shadow-sm" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-1">Warna (pisahkan dengan koma)</label>
            <input type="text" name="color" class="w-full border-gray-300 rounded-md shadow-sm" required placeholder="Contoh: Merah, Biru, Hitam">
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-1">Harga</label>
            <input type="number" name="price" class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="mb-6">
            <label class="block font-medium text-gray-700 mb-1">Stok</label>
            <input type="number" name="stock" class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const imageInput = document.querySelector('input[name="image"]');

        form.addEventListener('submit', function(e) {
            const file = imageInput.files[0];
            if (file) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!allowedTypes.includes(file.type)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Format tidak didukung',
                        text: 'Silakan unggah file gambar JPEG, JPG, atau PNG.'
                    });
                    return;
                }
                if (file.size > 2 * 1024 * 1024) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ukuran terlalu besar',
                        text: 'Ukuran file maksimal 2MB.'
                    });
                    return;
                }
            }
        });
    });
</script>
@endsection