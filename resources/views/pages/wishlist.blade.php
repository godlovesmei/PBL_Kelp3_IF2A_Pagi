@extends('layouts.user')

@section('title', 'Wishlist')

@section('content')
@if(Auth::guest())
<div id="popupModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-xl p-6 relative">
        <button id="closeModalBtn" class="absolute top-2 right-3 text-gray-600 hover:text-black text-xl font-bold">&times;</button>
        <div class="flex items-start space-x-3">
            <span class="bg-black text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">i</span>
            <p class="text-gray-800 text-sm leading-relaxed">
                To help you find your next VenusCar,
                <a href="{{ route('register') }}" class="underline hover:text-blue-600">create an account</a> or
                <a href="{{ route('login') }}" class="underline hover:text-blue-600">sign in</a> to make your saves permanent.
            </p>
        </div>
    </div>
</div>
@endif

<div class="min-h-screen flex flex-col pt-[65px]">
    <!-- Header -->
    <div class="bg-gray-200 flex items-center justify-center py-10 md:py-14 px-4 text-center">
        <h2 class="text-3xl md:text-5xl font-bold text-black">My Wishlist</h2>
    </div>

    <!-- Table Content -->
    <div class="bg-[#f2f2f2] w-full flex flex-col items-center justify-center px-4 py-10">
        <div class="w-full max-w-6xl">
            <h2 class="text-xl md:text-2xl font-semibold mb-6 text-center">Saved Inventory</h2>

            @if($wishlists->isEmpty())
                <p class="text-center text-gray-500 mt-10">You haven't saved any cars to your wishlist yet.</p>
            @else
                <div class="overflow-x-auto bg-white rounded-xs shadow-sm">
                    <table class="min-w-full text-sm md:text-base table-auto">
                        <thead class="bg-gray-100 border-b border-gray-300 text-black font-semibold">
                            <tr>
                                <th class="p-4 whitespace-nowrap">CAR MODEL</th>
                                <th class="p-4 whitespace-nowrap">IMAGE</th>
                                <th class="p-4 whitespace-nowrap">PRICE</th>
                                <th class="p-4 whitespace-nowrap">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($wishlists as $item)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="p-4 text-center">
                                        <p class="font-semibold">{{ $item->car->model }}</p>
                                    </td>
                                    <td class="p-4 text-center">
                                        <img src="{{ asset('images/' . $item->car->image) }}" alt="{{ $item->car->model }}" class="w-16 md:w-20 mx-auto rounded shadow">
                                    </td>
                                    <td class="p-4 text-center text-black font-semibold">
                                        Rp {{ number_format($item->car->price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 text-center space-y-2 md:space-y-0 md:space-x-2 flex flex-col md:flex-row items-center justify-center">
                                        <button data-id="{{ $item->car->id }}" class="removeFromWishlist text-red-400 font-bold hover:underline">Delete</button>
                                        <a href="{{ route('pages.cars.show', $item->car->id) }}" class="text-gray-500 font-medium hover:underline">Detail</a>
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

@push('scripts')
<script src="{{ asset('js/wishlist.js') }}"></script>
@endpush
@include('components.floating-menu')
@endsection

