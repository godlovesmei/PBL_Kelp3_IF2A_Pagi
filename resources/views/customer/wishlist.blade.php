@extends('layouts.customer')

@section('title', 'Wishlist')

@section('content')

<!-- MAIN CONTENT -->
    <!-- INI ADALAH BAGIAN YANG HARUSNYA TERHUBUNG DENGAN DATABASE -->

    <!-- MODAL POPUP -->
    <div id="popupModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-xl p-6 relative">
            <button onclick="closeModal()"
                class="absolute top-2 right-3 text-gray-600 hover:text-black text-xl font-bold">
                &times;
            </button>
            <div class="flex items-start space-x-3">
                <span
                    class="bg-black text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">i</span>
                <p class="text-gray-800 text-sm leading-relaxed">
                    To help find your next VenusCars,
                    <a href="#" class="underline hover:text-blue-600">create an account</a> or
                    <a href="#" class="underline hover:text-blue-600">sign in</a> to make your saves permanent.
                </p>
            </div>
        </div>
    </div>

    <!-- LAYOUT UTAMA -->
<div class="min-h-screen flex flex-col pt-[80px]">
    <!-- Header -->
    <div class="bg-gray-200 flex items-center justify-center py-16">
        <h1 class="text-5xl font-bold text-black">My Saves</h1>
    </div>

    <!-- Konten Tabel -->
    <div class="bg-[#f2f2f2] flex flex-col items-center justify-center px-4 py-10">
        <div class="w-full max-w-6xl">
            <h2 class="text-2xl font-semibold mb-4 text-center">Saved Inventory</h2>

            @if($wishlists->isEmpty())
                <p class="text-center text-gray-500 mt-10">Belum ada mobil yang disimpan di wishlist kamu.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left font-semibold border-b border-gray-400 text-black">
                            <tr>
                                <th class="pb-3">NAMA MOBIL</th>
                                <th class="pb-3">DESKRIPSI</th>
                                <th class="pb-3">HARGA</th>
                                <th class="pb-3">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="align-top">
                            @foreach($wishlists as $item)
                                <tr class="border-b border-gray-200">
                                    <td class="py-5 pr-6">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-40 mb-2">
                                        <p class="text-center">{{ $item->name }}</p>
                                    </td>
                                    <td class="py-5 pr-6">
                                        <ul class="list-disc ml-5 space-y-1">
                                            @foreach(explode('|', $item->description) as $desc)
                                                <li>{{ $desc }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="py-5 pr-6 text-black font-semibold">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="py-5 space-x-2">
                                        <form action="{{ route('customer.wishlist.destroy', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-500 font-bold hover:underline">DELETE</button>
                                        </form>
                                        <a href="{{ route('customer.detail', $item->id) }}" class="text-gray-500 hover:underline">DETAIL</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>


    @if ($showModal)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('popupModal');
            modal.classList.remove('hidden');
            // Delay dikit biar transition jalan
            setTimeout(() => {
                modal.classList.add('opacity-100');
                modal.classList.remove('opacity-0');
            }, 10);
        });

        function closeModal() {
            const modal = document.getElementById('popupModal');
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); // sama dengan duration-300
        }
    </script>
@endif
    @endsection
