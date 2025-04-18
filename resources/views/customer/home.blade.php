@extends('layouts.customer')

@section('content')
    <!-- SIDEBAR -->
    <div class="w-24 bg-[#e3d8c4] text-center py-8 flex flex-col gap-8 rounded-r-3xl shadow-xl border-r border-[#cbbca1] sticky top-0">
        <a href="#" class="flex flex-col items-center group">
            <div class="bg-white rounded-full p-3 shadow-md group-hover:bg-[#bfae91] transition duration-300">
                <i class="fas fa-car-side text-xl text-gray-700 group-hover:text-white"></i>
            </div>
            <span class="text-xs mt-2 text-gray-700 group-hover:text-[#5a4c36] font-medium transition">MPV</span>
        </a>
        
        <a href="#" class="flex flex-col items-center group">
            <div class="bg-white rounded-full p-3 shadow-md group-hover:bg-[#bfae91] transition duration-300">
                <i class="fas fa-car text-xl text-gray-700 group-hover:text-white"></i>
            </div>
            <span class="text-xs mt-2 text-gray-700 group-hover:text-[#5a4c36] font-medium transition">SEDAN</span>
        </a>
        
        <a href="#" class="flex flex-col items-center group">
            <div class="bg-white rounded-full p-3 shadow-md group-hover:bg-[#bfae91] transition duration-300">
                <i class="fas fa-car-alt text-xl text-gray-700 group-hover:text-white"></i>
            </div>
            <span class="text-xs mt-2 text-gray-700 group-hover:text-[#5a4c36] font-medium transition">SPORTS</span>
        </a>
        
        <a href="#" class="flex flex-col items-center group">
            <div class="bg-white rounded-full p-3 shadow-md group-hover:bg-[#bfae91] transition duration-300">
                <i class="fas fa-truck-monster text-xl text-gray-700 group-hover:text-white"></i>
            </div>
            <span class="text-xs mt-2 text-gray-700 group-hover:text-[#5a4c36] font-medium transition">SUV</span>
        </a>
    </div>

    <!-- BANNER -->
    <div class="w-full p-6 text-center">
        <img src="/images/banner_dashboard.png" alt="Banner" class="w-full rounded-lg shadow-md" />
    </div>

    <!-- SECTION LIST MOBIL -->
    <div class="w-full px-6 mt-10">
        <h2 class="text-2xl font-semibold text-[#5a4c36] mb-6 text-left">Most Popular</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            {{-- @foreach ($cars as $car)  <!-- Looping data mobil --> --}}
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <img src="/images/hondamobilioblack.png" alt="Toyota Avanza" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">Toyota Avanza</h3>
                        <p class="text-sm text-gray-500">MPV | Tahun 2021</p>
                        <p class="text-[#bfae91] font-bold mt-2">Rp 180.000.000</p>
                        <a href="/login" class="mt-4 inline-block bg-[#bfae91] text-white px-4 py-1 rounded-full text-sm hover:bg-[#a08f77] transition">Lihat Detail</a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <img src="/images/mobil2.jpg" alt="Honda Civic" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">Honda Civic</h3>
                        <p class="text-sm text-gray-500">Sedan | Tahun 2020</p>
                        <p class="text-[#bfae91] font-bold mt-2">Rp 350.000.000</p>
                        <a href="/customer/login" class="mt-4 inline-block bg-[#bfae91] text-white px-4 py-1 rounded-full text-sm hover:bg-[#a08f77] transition">Lihat Detail</a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <img src="/images/mobil3.jpg" alt="Mazda CX-5" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">Mazda CX-5</h3>
                        <p class="text-sm text-gray-500">SUV | Tahun 2022</p>
                        <p class="text-[#bfae91] font-bold mt-2">Rp 470.000.000</p>
                        <a href="/login" class="mt-4 inline-block bg-[#bfae91] text-white px-4 py-1 rounded-full text-sm hover:bg-[#a08f77] transition">Lihat Detail</a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <img src="/images/mobil4.jpg" alt="BMW M4" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">BMW M4</h3>
                        <p class="text-sm text-gray-500">Sports | Tahun 2023</p>
                        <p class="text-[#bfae91] font-bold mt-2">Rp 1.200.000.000</p>
                        <a href="/login" class="mt-4 inline-block bg-[#bfae91] text-white px-4 py-1 rounded-full text-sm hover:bg-[#a08f77] transition">Lihat Detail</a>
                    </div>
                </div>
            {{-- @endforeach --}}
        </div>
    </div>

    <div class="text-center mt-8">
        <a href="{{ route('customer.shop') }}" class="inline-block bg-[#bfae91] text-white px-6 py-2 rounded-full font-medium hover:bg-[#a08f77] transition">
            Shop Now
        </a>
    </div>
@endsection