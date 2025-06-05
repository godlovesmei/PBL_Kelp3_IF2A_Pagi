@extends('layouts.dealer')
@section('content')
<div x-data="{ sidebarOpen: localStorage.getItem('sidebarOpen') === 'true' }"
     x-init="$watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value))"
     x-bind:class="sidebarOpen ? "
     class="transition-all duration-300 ease-in-out">

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-6 pt-12">
    <!-- Card for Products -->
    <a href="{{ route('pages.dealer.index') }}" class="border border-gray-400 rounded-lg p-6 hover:shadow-lg transition bg-white">
        <div class="flex items-center mb-4">
            <i class="fas fa-car text-2xl mr-3"></i>
            <h2 class="text-2xl font-semibold">Products</h2>
        </div>
        <p class="text-lg">Total: {{ $totalCars }}</p>
    </a>

    <!-- Card for Orders -->
    <a href="#" class="border border-gray-400 rounded-lg p-6 hover:shadow-lg transition bg-white">
        <div class="flex items-center mb-4">
            <i class="fas fa-clipboard-list text-2xl mr-3"></i>
            <h2 class="text-2xl font-semibold">Orders</h2>
        </div>
        <p class="text-lg">Total: 0</p> {{-- Replace with dynamic count later --}}
    </a>
</div>
@endsection
