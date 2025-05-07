@extends('layouts.dealer')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-6 pt-12">
    <!-- Card Produk -->
    <a href="#" class="border border-gray-400 rounded-lg p-6 hover:shadow-lg transition bg-white">
        <div class="flex items-center mb-4">
            <i class="fas fa-boxes text-2xl mr-3"></i>
            <h2 class="text-2xl font-semibold">Produk</h2>
        </div>
        <p class="text-lg">Total: {{ $totalMobil }}</p>
    </a>

    <!-- Card Pesanan -->
    <a href="#" class="border border-gray-400 rounded-lg p-6 hover:shadow-lg transition bg-white">
        <div class="flex items-center mb-4">
            <i class="fas fa-list text-2xl mr-3"></i>
            <h2 class="text-2xl font-semibold">Pesanan</h2>
        </div>
        <p class="text-lg">Total: 0</p> {{-- Ganti jadi dynamic nanti --}}
    </a>
</div>
@endsection
