@extends('layouts.dealer')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg border border-gray-300 mt-12">
    <h2 class="text-xl font-semibold mb-6 flex items-center">
        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
            <path d="M4 4h16v2H4zm0 7h16v2H4zm0 7h16v2H4z" />
        </svg>
        Daftar Pesanan - Konfirmasi
    </h2>
    <div class="border-b border-black mb-6"></div>

    <!-- Filter Buttons -->
    <div class="flex space-x-2 mb-4">
        <a href="/daftar-pesanan" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">Semua</a>
        <a href="/konfirmasi" class="bg-gray-400 text-black px-4 py-2 rounded hover:bg-gray-500">Konfirmasi</a>
        <a href="/diproses" class="bg-gray-400 text-black px-4 py-2 rounded hover:bg-gray-500">Diproses</a>
        <a href="/dikirim" class="bg-gray-400 text-black px-4 py-2 rounded hover:bg-gray-500">Dikirim</a>
        <a href="/selesai" class="bg-gray-400 text-black px-4 py-2 rounded hover:bg-gray-500">Selesai</a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border text-center">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Produk</th>
                    <th class="px-4 py-2 border">Total Pesanan</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Tambahkan data lainnya di sini -->
            </tbody>
        </table>
    </div>
</div>
@endsection
