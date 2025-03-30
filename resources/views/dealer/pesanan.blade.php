@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Pesanan</h2>
    <a href="{{ route('pesanan.create') }}" class="btn btn-primary">Tambah Pesanan</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Mobil</th>
                <th>Pembeli</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Total Pembayaran</th>
                <th>Metode Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanan as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->kode_mobil }}</td>
                <td>{{ $p->pembeli->nama ?? 'Tidak Diketahui' }}</td>
                <td>{{ $p->jumlah }}</td>
                <td>{{ $p->status }}</td>
                <td>Rp {{ number_format($p->total_pembayaran, 0, ',', '.') }}</td>
                <td>{{ ucfirst($p->metode_pembayaran) }}</td>
                <td>
                    <a href="{{ route('pesanan.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('pesanan.destroy', $p->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pesanan ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
