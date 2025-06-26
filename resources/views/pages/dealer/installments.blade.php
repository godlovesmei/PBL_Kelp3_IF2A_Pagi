@extends('layouts.dealer')

@section('content')
<div class="mt-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <h2 class="mb-6 text-2xl font-bold uppercase text-blue-900 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2-2m0 0l7-7 7 7M13 5v6h6" />
        </svg>
        TRACK INSTALLMENTS
    </h2>
    <div class="border-t-4 border-blue-700 mb-6"></div>

    @if(!isset($order))
<!-- Filter Form -->
<form method="GET" action="{{ route('pages.dealer.installments') }}" class="mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
            <input type="text" name="customer" value="{{ request('customer') }}"
                   class="w-full border rounded px-3 py-2 text-sm dark:bg-gray-900 dark:text-white dark:border-gray-700 placeholder-slate-500 italic"
                   placeholder="Customer name">
        </div>
        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
            <select name="status"
                    class="w-full border rounded px-3 py-2 text-sm dark:bg-gray-900 dark:text-white dark:border-gray-700">
                <option value="">All</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
            </select>
        </div>
        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Order Date From</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                   class="w-full border rounded px-3 py-2 text-sm dark:bg-gray-900 dark:text-white dark:border-gray-700">
        </div>
        <div>
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Order Date To</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                   class="w-full border rounded px-3 py-2 text-sm dark:bg-gray-900 dark:text-white dark:border-gray-700">
        </div>
    </div>

    {{-- Filter Button --}}
    <div class="md:col-span-4 flex flex-wrap sm:justify-end items-center gap-3 mt-4">
        <div class="flex gap-2">
            <button type="submit"
                    class="px-4 py-2 bg-teal-600 text-white text-sm rounded hover:bg-teal-700">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>
            <a href="{{ route('pages.dealer.installments') }}"
               class="text-sm text-gray-500 hover:underline flex items-center gap-1">
                <i class="fas fa-redo"></i> Reset
            </a>
        </div>
    </div>
</form>
    @endif

    @isset($order)
        <!-- Detail Order -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-md mb-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Order #{{ $order->order_id }}</h3>
            <p><span class="font-medium text-gray-600">Customer:</span> {{ $order->customer->user->name ?? '-' }}</p>
            <p><span class="font-medium text-gray-600">Car:</span> {{ $order->car->model ?? '-' }}</p>
            <p><span class="font-medium text-gray-600">Payment Status:</span>
                <span class="inline-block px-2 py-1 text-sm rounded-full
                    {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </p>
            <a href="{{ route('pages.dealer.installments') }}" class="inline-block mt-4 text-sm text-blue-600 hover:underline">
                ← Back to Installment List
            </a>
        </div>

        <!-- Tabel Cicilan -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4">Installment Details</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-gray-700 dark:text-gray-100">
                    <thead class="bg-blue-100 dark:bg-gray-800 text-blue-900 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2 text-left">Month</th>
                            <th class="px-4 py-2 text-left">Due Date</th>
                            <th class="px-4 py-2 text-left">Amount</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Paid At</th>
                            <th class="px-4 py-2 text-left">Payment Proof</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($installments as $cicilan)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $cicilan->due_date }}</td>
                            <td class="px-4 py-2">Rp{{ number_format($cicilan->amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 text-xs rounded-full
                                    {{ $cicilan->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($cicilan->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                @if($cicilan->payments->isNotEmpty())
                                    {{ \Carbon\Carbon::parse($cicilan->payments->first()->payment_date)->format('d M Y') }}
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($cicilan->payments->isNotEmpty())
                                    <a href="{{ asset('storage/' . $cicilan->payments->first()->payment_proof) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:underline">View</a>
                                @else
                                    <span class="text-gray-400 italic">No proof</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Daftar Order Kredit -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4">Installment Orders</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-gray-700 dark:text-gray-100">
                    <thead class="bg-blue-100 dark:bg-gray-800 text-blue-900 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2 text-left">Order ID</th>
                            <th class="px-4 py-2 text-left">Customer</th>
                            <th class="px-4 py-2 text-left">Car</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2">{{ $order->order_id }}</td>
                            <td class="px-4 py-2">{{ $order->customer->user->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $order->car->model ?? $order->car->model ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 text-xs rounded-full
                                    {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('pages.dealer.installments', ['order_id' => $order->order_id]) }}"
                                   class="text-blue-600 hover:underline text-sm">View Installments</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-400 italic">No installment orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    @endisset
</div>
@endsection
