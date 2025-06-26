@extends('layouts.dealer')

@section('content')
<div class="mt-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <h2 class="mb-6 text-2xl font-bold uppercase text-blue-900 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2-2m0 0l7-7 7 7M13 5v6h6" />
        </svg>
        TRACK PAYMENTS
    </h2>
    <div class="border-t-4 border-blue-700 mb-6"></div>

    {{-- Filter --}}
    <form action="{{ route('pages.dealer.payments') }}" method="GET" class="mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Customer Name</label>
                <input type="text" name="customer" value="{{ request('customer') }}"
                       class="w-full border rounded px-3 py-2 text-sm dark:bg-gray-900 dark:text-white dark:border-gray-700 placeholder-slate-500 italic"
                       placeholder="Search name">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Payment Type</label>
                <select name="method"
                        class="w-full border rounded px-3 py-2 text-sm dark:bg-gray-900 dark:text-white dark:border-gray-700">
                    <option value="">All</option>
                    <option value="cash" {{ request('method') === 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="dp" {{ request('method') === 'dp' ? 'selected' : '' }}>Down Payment (DP)</option>
                    <option value="installment" {{ request('method') === 'installment' ? 'selected' : '' }}>Installment</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Date From</label>
                <input type="date" name="from" value="{{ request('from') }}"
                       class="w-full border rounded px-3 py-2 text-sm dark:bg-gray-900 dark:text-white dark:border-gray-700">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Date To</label>
                <input type="date" name="to" value="{{ request('to') }}"
                       class="w-full border rounded px-3 py-2 text-sm dark:bg-gray-900 dark:text-white dark:border-gray-700">
            </div>
        </div>

        <div class="mt-4 flex justify-end">
                <div class="flex gap-2">
             <button type="submit"
                        class="px-4 py-2 bg-teal-600 text-white text-sm rounded hover:bg-teal-700">
                     <i class="fas fa-filter mr-1"></i> Filter
             </button>
                        <a href="{{ route('pages.dealer.payments') }}"
                                    class="text-sm text-gray-500 hover:underline flex items-center gap-1">
                                        <i class="fas fa-redo"></i> Reset
                                    </a>
                </div>
            </div>
    </form>

    {{-- Payment Table --}}
     <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4">All Payments</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-gray-700 dark:text-gray-100">
                    <thead class="bg-blue-100 dark:bg-gray-800 text-blue-900 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2 text-left">Customer</th>
                            <th class="px-4 py-2 text-left">Order</th>
                            <th class="px-4 py-2 text-left">Type</th>
                            <th class="px-4 py-2 text-left">Amount</th>
                            <th class="px-4 py-2 text-left">Date</th>
                            <th class="px-4 py-2 text-left">Proof</th>
                        </tr>
                    </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-700 dark:text-gray-300">
                @forelse ($payments as $payment)
                    <tr>
                        <td class="px-4 py-2">{{ $payment->order->customer->user->name ?? '-' }}</td>
                        <td class="px-4 py-2">#{{ $payment->order->order_id }}</td>
                        <td class="px-4 py-2 capitalize">{{ $payment->payment_method }}</td>
                        <td class="px-4 py-2 font-medium">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                        <td class="px-4 py-2">
                            @if ($payment->payment_proof)
                                <a href="{{ asset('storage/'.$payment->payment_proof) }}"
                                   target="_blank"
                                   class="text-blue-500 hover:underline">View</a>
                            @else
                                <span class="text-gray-400 italic">N/A</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-400 italic">
                            No payments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6 flex justify-center">
        {{ $payments->withQueryString()->links() }}
    </div>
</div>
@endsection
