@extends('layouts.user')

@section('title', 'Order History')

@section('content')
<div class="min-h-screen pt-[55px] bg-[#f2f2f2]">
    <!-- Header -->
    <div class="bg-gray-200 text-center py-14">
        <h2 class="text-4xl md:text-5xl font-bold text-black">My Orders</h2>
    </div>

    <!-- Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if ($orders->isEmpty())
            <div class="flex flex-col items-center justify-center text-center py-16">
                <img src="{{ asset('images/empty_orders.png') }}" alt="No Orders" class="w-100 h-100 sm:w-48 sm:h-48 mb-6 object-contain">
                <p class="text-gray-500 text-base sm:text-lg">You have no orders yet.<br>Let's find your dream car!</p>
                <a href="{{ route('pages.shop') }}" class="mt-6 px-6 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-md shadow hover:bg-blue-700 transition">Shop Now</a>
            </div>
        @else
            <div class="flex flex-col gap-6">
                @foreach ($orders as $order)
                    @php
                        $status = strtolower($order->order_status);
                        $statusColors = [
                            'pending'    => 'bg-yellow-50 text-yellow-800 border-yellow-200',
                            'confirm'    => 'bg-green-50 text-green-800 border-green-200',
                            'cancelled'  => 'bg-red-50 text-red-800 border-red-200',
                            'processing' => 'bg-blue-50 text-blue-800 border-blue-200',
                            'shipped'    => 'bg-purple-50 text-purple-800 border-purple-200',
                            'completed'  => 'bg-teal-50 text-teal-800 border-teal-200',
                        ];
                        $badgeClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                        $car = $order->car;
                        $imagePath = $car && $car->image ? asset('images/' . $car->image) : asset('images/car-placeholder.png');
                    @endphp

                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 sm:p-6 hover:shadow-md transition">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
                            <!-- Car Image & Info -->
                            <div class="flex items-start gap-4 w-full md:w-auto">
                                <img src="{{ $imagePath }}" alt="Car Image" class="w-24 h-16 sm:w-28 sm:h-20 object-cover rounded-lg border border-gray-200 bg-gray-50" loading="lazy">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base sm:text-lg font-semibold truncate">{{ $car->brand ?? 'N/A' }} - {{ $car->model ?? 'N/A' }}</h3>
                                    @if ($car)
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $car->variant ?? '' }}
                                            @if($car->car_code) Car code: {{ $car->car_code }} @endif
                                            @if(optional($car->car_colors)->color_name) • {{ $car->car_colors->color_name }}
                                            @endif
                                        </div>
                                        @endif
                                    <div class="text-xs text-gray-500">Order ID: #{{ $order->order_id }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">Date: {{ $order->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <span>Total:</span> <span class="font-bold text-gray-700">Rp{{ number_format($order->total_price) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Actions -->
                            <div class="flex flex-col gap-2 items-start md:items-end">
                                <span class="px-3 py-1 text-xs font-medium rounded-full border {{ $badgeClass }}">{{ ucfirst($order->order_status) }}</span>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    <a href="{{ route('user.orders.show', $order->order_id) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium rounded-md bg-blue-50 text-blue-700 border border-blue-100 hover:bg-blue-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Details
                                    </a>
                                    @if ($status === 'completed')
                                        <a href="{{ route('user.orders.show', $order->order_id) }}" class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium rounded-md bg-teal-50 text-teal-700 border border-teal-100 hover:bg-teal-100 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Invoice
                                        </a>
                                        <a href="{{ route('user.orders.show', $order->order_id) }}" class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium rounded-md bg-yellow-50 text-yellow-700 border border-yellow-100 hover:bg-yellow-100 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.068 6.374a1 1 0 00.95.69h6.708c.969 0 1.371 1.24.588 1.81l-5.426 3.944a1 1 0 00-.364 1.118l2.068 6.374c.3.921-.755 1.688-1.54 1.118l-5.426-3.944a1 1 0 00-1.176 0l-5.426 3.944c-.784.57-1.838-.197-1.539-1.118l2.068-6.374a1 1 0 00-.364-1.118L2.293 11.8c-.783-.57-.38-1.81.588-1.81h6.708a1 1 0 00.95-.69l2.068-6.374z" /></svg>
                                            Review
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pt-10">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@include('components.floating-menu')
@endsection
