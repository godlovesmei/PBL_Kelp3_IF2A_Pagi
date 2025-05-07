@extends('layouts.dealer')

@section('content')
<div class="content mt-7">
    <!-- Tambahkan margin bawah pada header -->
    <h2 class="mb-4 text-uppercase fw-bold" style="color: #1d3557; font-size: 2rem;">
        <i class="fas fa-car me-2" style="color: #457b9d;"></i>Edit Mobil
    </h2>
    <hr class="mb-4" style="border-top: 3px solid #457b9d;">

    <form action="{{ route('dealer.mobil.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 shadow-sm rounded">
        @csrf
        @method('PUT')

        <!-- Merek -->
        <div class="mb-3">
            <label class="form-label">Merek</label>
            <input type="text" name="brand" value="{{ $car->brand }}" class="form-control" required>
        </div>

        <!-- Model -->
        <div class="mb-3">
            <label class="form-label">Model</label>
            <input type="text" name="model" value="{{ $car->model }}" class="form-control" required>
        </div>

        <!-- Tahun -->
        <div class="mb-3">
            <label class="form-label">Tahun</label>
            <input type="number" name="year" value="{{ $car->year }}" class="form-control" required>
        </div>

        <!-- Gambar -->
        <div class="mb-3">
            <label class="form-label">Gambar (biarkan kosong jika tidak ingin mengubah)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <!-- Tampilkan Gambar Lama -->
        @if($car->image)
        <div class="mb-3">
            <label class="form-label">Gambar Saat Ini</label>
            <img src="{{ asset('images/' . $car->image) }}" alt="Car Image" class="img-thumbnail" width="200">
        </div>
        @endif

        <!-- Kategori -->
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input type="text" name="category" value="{{ $car->category }}" class="form-control" required>
        </div>

        <!-- Spesifikasi -->
        <div class="mb-3">
            <label class="form-label">Spesifikasi</label>
            <input type="text" name="specifications" value="{{ $car->specifications }}" class="form-control" required>
        </div>

        <!-- Warna -->
        <div class="mb-3">
            <label class="form-label">Warna (bisa lebih dari satu, pisahkan dengan koma)</label>
            @php
                $warnaGabungan = $car->colors->pluck('color_name')->implode(', ');
            @endphp
            <input type="text" name="color" class="form-control" value="{{ $warnaGabungan }}" required placeholder="Contoh: Merah, Biru, Hitam">
        </div>

        <!-- Harga -->
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="price" value="{{ $car->price }}" class="form-control" required>
        </div>

        <!-- Stok -->
        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" value="{{ $car->stock }}" class="form-control" required>
        </div>

        <!-- Tombol Update -->
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
</div>
@endsection
