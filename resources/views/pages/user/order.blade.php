@extends('layouts.user')

@section('title', 'Order History')

@section('content')
<div class="min-h-screen pt-[65px] bg-[#f2f2f2]">
    <!-- Header -->
    <div class="bg-gray-200 text-center py-14">
        <h2 class="text-5xl font-bold text-black">My Orders</h2>
    </div>

    <!-- Content -->
    <div class="max-w-5xl mx-auto px-4 py-10">
        @if ($orders->isEmpty())
            <p class="text-center text-gray-500">You have no orders yet.</p>
        @else
            <div class="space-y-4">
                @foreach ($orders as $order)
                    @php
                        $status = strtolower($order->order_status);
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 ring-yellow-300',
                            'confirm' => 'bg-green-100 text-green-800 ring-green-300',
                            'cancelled' => 'bg-red-100 text-red-800 ring-red-300',
                            'processing' => 'bg-blue-100 text-blue-800 ring-blue-300',
                            'shipped' => 'bg-purple-100 text-purple-800 ring-purple-300',
                            'completed' => 'bg-teal-100 text-teal-800 ring-teal-300',
                        ];
                        $badgeClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-800 ring-gray-300';
                    @endphp

                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-semibold">
                                    {{ optional($order->car)->brand ?? 'N/A' }} - {{ optional($order->car)->model ?? 'N/A' }}
                                </h2>
                                <p class="text-sm text-gray-500">
                                    Order Date: {{ $order->created_at->format('d M Y') }}
                                </p>
                            </div>

                            <div class="flex items-center gap-3 flex-wrap">
                                <span class="inline-block px-3 py-1 text-xs font-medium rounded-full ring-1 {{ $badgeClass }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>

                                <a href="{{ route('user.orders.show', $order->order_id) }}" target="_blank"
                                   class="flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@include('components.floating-menu')
@endsection
