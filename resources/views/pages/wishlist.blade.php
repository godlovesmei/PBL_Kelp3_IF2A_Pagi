@extends('layouts.user')

@section('title', 'Wishlist')

@section('content')
<!-- MAIN CONTENT -->
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

<div class="min-h-screen flex flex-col pt-[80px]">
    <!-- Header -->
    <div class="bg-gray-200 flex items-center justify-center py-16">
        <h1 class="text-5xl font-bold text-black">My Wishlist</h1>
    </div>

    <!-- Table Content -->
    <div class="bg-[#f2f2f2] flex flex-col items-center justify-center px-4 py-10">
        <div class="w-full max-w-6xl">
            <h2 class="text-2xl font-semibold mb-4 text-center">Saved Inventory</h2>

            @if($wishlists->isEmpty())
                <p class="text-center text-gray-500 mt-10">You haven't saved any cars to your wishlist yet.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left font-semibold border-b border-gray-400 text-black">
                            <tr>
                                <th class="pb-3">CAR NAME</th>
                                <th class="pb-3">DESCRIPTION</th>
                                <th class="pb-3">PRICE</th>
                                <th class="pb-3">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="align-top">
                            @foreach($wishlists as $item)
                                <tr class="border-b border-gray-200">
                                    <td class="py-5 pr-6">
                                        <img src="{{ asset('storage/' . $item->car->image) }}" alt="{{ $item->car->name }}" class="w-40 mb-2 rounded shadow-sm">
                                        <p class="text-center font-semibold">{{ $item->car->name }}</p>
                                    </td>
                                    <td class="py-5 pr-6">
                                        <ul class="list-disc ml-5 space-y-1">
                                            @foreach(explode('|', $item->car->description) as $desc)
                                                <li>{{ $desc }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="py-5 pr-6 text-black font-semibold">Rp {{ number_format($item->car->price, 0, ',', '.') }}</td>
                                    <td class="py-5 space-x-2">
                                        <button data-id="{{ $item->car->id }}" class="removeFromWishlist text-red-500 font-bold hover:underline">
                                            DELETE
                                        </button>
                                        <a href="{{ route('pages.cars.show', $item->car->id) }}" class="text-gray-500 hover:underline">
                                             DETAIL
                                        </a>
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
@endsection