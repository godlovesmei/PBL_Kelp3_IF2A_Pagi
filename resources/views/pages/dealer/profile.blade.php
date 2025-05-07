@extends('layouts.dealer')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-lg shadow">

    <h2 class="text-2xl font-semibold mb-6 border-b pb-4">Profil Toko</h2>

    <!-- Logo -->
    <div class="flex items-center space-x-4 mb-6">
        <img src="/images/logo.jpg" alt="Logo Toko" class="w-20 h-20 object-contain border rounded">
        <div>
            <p class="text-lg font-semibold">Venus Cars</p>
            <p class="text-sm text-gray-500">#TokoMobilImpian</p>
        </div>
    </div>

    <!-- Info Profil -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Address -->
        <div>
            <label class="block text-gray-700 mb-2">Alamat Toko</label>
            <input type="text" value="Jl. Raya Otomotif No.88, Jakarta" disabled
                class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed">
        </div>

        <!-- Social Media Link -->
        <div>
            <label class="block text-gray-700 mb-2">Link Sosial Media</label>
            <input type="text" value="https://instagram.com/venuscars.id" disabled
                class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed">
        </div>

    </div>

    <!-- Description -->
    <div class="mt-6">
        <label class="block text-gray-700 mb-2">Deskripsi Toko</label>
        <textarea rows="4" disabled
            class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed">
Kami adalah dealer resmi mobil dengan koleksi terbaik dan pelayanan terpercaya. Temukan mobil impian Anda bersama kami!
        </textarea>
    </div>

    <!-- Tombol Aksi -->
    <div class="mt-8 flex justify-between">
        <!-- Tombol Edit -->
        <a href="#" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Edit Profil
        </a>

        <!-- Tombol Logout -->
        <a href="#" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
            Logout
        </a>
    </div>

    @endsection