@extends('layouts.user')

@section('title', 'Order Details')

@section('content')
<div class="max-w-4xl mx-auto mt-10 pt-[65px] px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-extrabold mb-10 text-center text-gray-900">Order Details</h1>

    {{-- Order Summary --}}
    <section class="bg-white rounded-xl shadow-md border border-gray-200 p-6 sm:p-8 mb-12">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b border-gray-300 pb-3 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M5 6h14M6 14h12M7 18h10" />
            </svg>
            Order Summary
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10 text-gray-700 text-sm">
            {{-- Customer Info --}}
            <div>
                <h3 class="text-base font-semibold text-gray-900 mb-3">Customer Information</h3>
                <p><span class="text-gray-500">Name:</span> <span class="font-medium">{{ optional($customer->user)->name ?? 'N/A' }}</span></p>
                <p><span class="text-gray-500">Address:</span> <span class="font-medium">{{ optional($customer->user)->address ?? 'N/A' }}</span></p>
            </div>

            {{-- Car Info --}}
            <div>
                <h3 class="text-base font-semibold text-gray-900 mb-3">Car Information</h3>
                <p><span class="text-gray-500">Brand:</span> <span class="font-medium">{{ optional($order->car)->brand ?? 'N/A' }}</span></p>
                <p><span class="text-gray-500">Model:</span> <span class="font-medium">{{ optional($order->car)->model ?? 'N/A' }}</span></p>
                <p>
                    <span class="text-gray-500">Price:</span>
                    <span class="text-green-600 font-semibold">Rp {{ number_format(optional($order->car)->price ?? 0, 0, ',', '.') }}</span>
                </p>
            </div>

            {{-- Order Info --}}
            <div>
                <h3 class="text-base font-semibold text-gray-900 mb-3">Order Information</h3>
                <p><span class="text-gray-500">Order Date:</span> <span class="font-medium">{{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}</span></p>
                <p><span class="text-gray-500">Status:</span>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        @if($order->order_status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->order_status === 'completed') bg-green-100 text-green-800
                        @elseif($order->order_status === 'cancelled') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif
                    ">
                        {{ ucfirst($order->order_status ?? '-') }}
                    </span>
                </p>
            </div>

            {{-- Payment Info --}}
            <div>
                <h3 class="text-base font-semibold text-gray-900 mb-3">Payment Details</h3>
                <p><span class="text-gray-500">Method:</span> <span class="font-medium">{{ ucfirst($order->payment_method ?? '-') }}</span></p>
                <p>
                    <span class="text-gray-500">Total Price:</span>
                    <span class="text-green-700 font-semibold">Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</span>
                </p>
                <p>
                    <span class="text-gray-500">Down Payment:</span>
                    Rp {{ number_format($order->down_payment ?? 0, 0, ',', '.') }}
                    ({{ $order->down_payment_percent ?? '-' }}%)
                </p>
            </div>

            {{-- Credit Details (optional) --}}
            @if(($order->payment_method ?? null) === 'credit')
            <div>
                <h3 class="text-base font-semibold text-gray-900 mb-3">Credit Information</h3>
                <p><span class="text-gray-500">Tenor:</span> <span class="font-medium">{{ $order->tenor ?? '-' }} months</span></p>
                <p><span class="text-gray-500">Financed:</span> Rp {{ number_format($order->amount_financed ?? 0, 0, ',', '.') }}</p>
                <p><span class="text-gray-500">Monthly:</span> Rp {{ number_format($order->monthly_installment ?? 0, 0, ',', '.') }}</p>
            </div>
            @endif
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('user.orders.index') }}"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
                &larr; Back to Order History
            </a>
        </div>
    </section>
</div>
@endsection
