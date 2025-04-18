@extends('layouts.dealer')

@section('content')
<div class="content">
    <h2 class="mb-4">Tambah Mobil</h2>
    <form action="{{ route('dealer.mobil.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 shadow-sm rounded">
        @csrf

        <!-- Merek -->
        <div class="mb-3">
            <label class="form-label">Merek</label>
            <input type="text" name="brand" class="form-control" required>
        </div>

        <!-- Model -->
        <div class="mb-3">
            <label class="form-label">Model</label>
            <input type="text" name="model" class="form-control" required>
        </div>

        <!-- Tahun -->
        <div class="mb-3">
            <label class="form-label">Tahun</label>
            <input type="number" name="year" class="form-control" required>
        </div>

        <!-- Gambar -->
        <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>

        <!-- Kategori -->
        <div class="mb-3">
            <label class="form-label" for="category">Kategori</label>
            <select name="category" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="MPV">MPV</option>
                <option value="Sedan">Sedan</option>
                <option value="Sports">Sports</option>
                <option value="SUV">SUV</option>
            </select>
        </div>

        <!-- Spesifikasi -->
        <div class="mb-3">
            <label class="form-label">Spesifikasi</label>
            <textarea name="specifications" class="form-control" required></textarea>
        </div>

        <!-- Warna -->
        <div class="mb-3">
            <label class="form-label">Warna (bisa lebih dari satu, pisahkan dengan koma)</label>
            <input type="text" name="color" class="form-control" required placeholder="Contoh: Merah, Biru, Hitam">
        </div>

        <!-- Harga -->
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <!-- Stok -->
        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" required>
        </div>

        <!-- Tombol Simpan -->
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

{{-- Tambahkan script hanya sekali --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const imageInput = document.querySelector('input[name="image"]');

        form.addEventListener('submit', function (e) {
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

                if (file.size > 2 * 1024 * 1024) { // 2MB
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