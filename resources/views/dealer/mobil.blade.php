@extends('layouts.dealer')

@section('content')
<div class="content mt-7">
     <!-- Tambahkan margin bawah pada header -->
     <h2 class="mb-4 text-uppercase fw-bold" style="color: #1d3557; font-size: 2rem;">
        <i class="fas fa-car me-2" style="color: #457b9d;"></i>Daftar Mobil
    </h2>
    <hr class="mb-4" style="border-top: 3px solid #457b9d;">

    <!-- Tambah Mobil and Search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('dealer.mobil.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Mobil
        </a>
        <div class="input-group" style="width: 300px;">
            <input type="text" class="form-control" placeholder="Cari mobil...">
            <button class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
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
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Merek</th>
                    <th>Model</th>
                    <th>Tahun</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cars as $car)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ asset('images/' . $car->image) }}" width="80" class="img-thumbnail" alt="{{ $car->brand }} {{ $car->model }}">
                    </td>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->year }}</td>
                    <td>{{ $car->category }}</td>
                    <td>Rp {{ number_format($car->price, 0, ',', '.') }}</td>
                    <td>{{ $car->stock }}</td>
                    <td>
                        <a href="{{ route('dealer.mobil.edit', $car->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('dealer.mobil.destroy', $car->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm delete-btn">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- SweetAlert -->
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
</div>
@endsection