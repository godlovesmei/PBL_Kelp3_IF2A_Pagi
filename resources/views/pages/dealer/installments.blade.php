@extends('layouts.dealer')

@section('content')
<div class="mt-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
      <h2 class="mb-6 text-2xl font-bold uppercase text-blue-900 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2-2m0 0l7-7 7 7M13 5v6h6" />
        </svg>
        TRACK INSTALLMENTS
    </h2>
    <div class="border-t-4 border-blue-700 mb-6"></div>

@if(isset($installmentsToConfirm) && $installmentsToConfirm->count())
    <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-xl shadow p-6">
        <h2 class="font-bold text-lg mb-2 text-yellow-800 flex items-center">
            <i class="fas fa-exclamation-circle mr-2 text-yellow-600"></i>
            Installments Needing Confirmation
        </h2>
        <div class="divide-y divide-yellow-200">
            @foreach($installmentsToConfirm as $cicilan)
                <div class="py-3 flex flex-col sm:flex-row sm:items-center">
                    <div class="flex-1">
                        <div>
                            <span class="font-semibold">{{ $cicilan->order->customer->user->name ?? '-' }}</span>
                            <span class="text-xs px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded">
                                {{ $cicilan->order->car->brand ?? '-' }} {{ $cicilan->order->car->model ?? '-' }}
                            </span>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            Due: {{ \Carbon\Carbon::parse($cicilan->due_date)->format('d M Y') }} |
                            Amount: <span class="font-mono">Rp{{ number_format($cicilan->amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-2 sm:mt-0 sm:ml-4">
                        <form method="POST" action="{{ route('dealer.installments.confirm', $cicilan->installment_id) }}">
                            @csrf
                            <button type="submit" class="text-green-600 hover:bg-green-100 rounded-full p-2 transition"
                                title="Confirm Payment"
                                onclick="return confirm('Confirm this installment payment?')">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('dealer.installments.reject', $cicilan->installment_id) }}">
                            @csrf
                            <button type="submit" class="text-red-600 hover:bg-red-100 rounded-full p-2 transition"
                                title="Reject Payment"
                                onclick="return confirm('Reject this installment payment?')">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

    {{-- FILTER FORM --}}
    @if(!isset($order))
    <form method="GET" action="{{ route('pages.dealer.installments') }}" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="text-xs font-semibold text-gray-600">Payment Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">All</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Order Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Order Date To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
        </div>
        <div class="flex flex-wrap justify-end gap-3 mt-4">
            <button type="submit" class="px-4 py-2 bg-teal-600 text-white text-sm rounded hover:bg-teal-700">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>
            <a href="{{ route('pages.dealer.installments') }}"
                class="text-sm text-gray-500 hover:underline flex items-center gap-1">
                <i class="fas fa-redo"></i> Reset
            </a>
        </div>
    </form>
    @endif

    @isset($order)
        <!-- Order Details -->
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

        <!-- Installment Table -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4">Installment Breakdown</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-gray-700 dark:text-gray-100">
                    <thead class="bg-blue-100 dark:bg-gray-800 text-blue-900 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2 text-left">Installment</th>
                            <th class="px-4 py-2 text-left">Due Date</th>
                            <th class="px-4 py-2 text-left">Amount</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Paid At</th>
                            <th class="px-4 py-2 text-left">Payment Proof</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($installments as $cicilan)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-gray-800 transition">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($cicilan->due_date)->format('d M Y') }}</td>
                            <td class="px-4 py-2">Rp{{ number_format($cicilan->amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 text-xs rounded-full font-semibold
                                    @if($cicilan->status === 'paid')
                                        bg-green-100 text-green-800
                                    @elseif($cicilan->status === 'rejected')
                                        bg-red-100 text-red-800
                                    @elseif($cicilan->status === 'waiting_confirmation')
                                        bg-yellow-100 text-yellow-800
                                    @else
                                        bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $cicilan->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                @if($cicilan->paid_at)
                                    {{ \Carbon\Carbon::parse($cicilan->paid_at)->format('d M Y') }}
                                @else
                                    <span class="text-gray-400 italic">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($cicilan->payments->isNotEmpty() && $cicilan->payments->first()->payment_proof)
                                    <a href="{{ asset('storage/' . $cicilan->payments->first()->payment_proof) }}"
                                        target="_blank"
                                        class="text-blue-600 hover:underline">View</a>
                                @else
                                    <span class="text-gray-400 italic">No proof</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
    @if(in_array($cicilan->status, ['pending', 'waiting_confirmation']))
        <form method="POST" action="{{ route('dealer.installments.confirm', $cicilan->installment_id) }}" class="inline-block">
            @csrf
            <button type="submit"
                class="text-green-600 hover:bg-green-100 rounded-full p-2 transition"
                title="Confirm Payment"
                onclick="return confirm('Are you sure you want to confirm this installment payment?')">
                <i class="fas fa-check"></i>
            </button>
        </form>
        <form method="POST" action="{{ route('dealer.installments.reject', $cicilan->installment_id) }}" class="inline-block ml-2">
            @csrf
            <button type="submit"
                class="text-red-600 hover:bg-red-100 rounded-full p-2 transition"
                title="Reject Payment"
                onclick="return confirm('Are you sure you want to reject this installment payment?')">
                <i class="fas fa-times"></i>
            </button>
        </form>
    @else
        <span class="text-gray-400 italic">-</span>
    @endif
</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Installment Order List -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4">Installment Orders</h4>
            {{-- Sticky search bar --}}
            <div class="sticky top-0 z-10 bg-white dark:bg-gray-900 py-2 mb-2 shadow-sm rounded">
                <input type="search" placeholder="Quick search by customer, order, car..." class="w-full border px-3 py-2 rounded-lg text-sm" oninput="filterTable(this)">
            </div>
            <div class="overflow-x-auto">
                <table id="orderTable" class="min-w-full table-auto text-sm text-gray-700 dark:text-gray-100">
                    <thead class="bg-blue-100 dark:bg-gray-800 text-blue-900 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2 text-left">Order ID</th>
                            <th class="px-4 py-2 text-left">Customer</th>
                            <th class="px-4 py-2 text-left">Car</th>
                            <th class="px-4 py-2 text-left">Payment Status</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-gray-800 transition">
                            <td class="px-4 py-2 font-semibold">{{ $order->order_id }}</td>
                            <td class="px-4 py-2">{{ $order->customer->user->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $order->car->model ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 text-xs rounded-full font-semibold
                                    {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('pages.dealer.installments', ['order_id' => $order->order_id]) }}"
                                    class="text-blue-700 hover:underline text-sm">View Installments</a>
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
        {{-- RECENT PAYMENTS CARD --}}
    @if(isset($recentInstallments) && $recentInstallments->count())
    <div x-data="{ open: true }" class="bg-gradient-to-br from-white to-blue-50 border border-blue-300 rounded-xl shadow p-6 mb-4">
        <div class="flex justify-between items-center mb-3 cursor-pointer" @click="open = !open">
            <div class="flex items-center">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-200 mr-3">
                    <i class="fas fa-coins text-blue-600"></i>
                </span>
                <span class="font-bold text-lg text-blue-900">Recent Installment Payments</span>
            </div>
            <button class="text-blue-700 hover:text-blue-900 focus:outline-none" type="button">
                <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
            </button>
        </div>
        <div x-show="open" x-transition>
            <div class="divide-y divide-blue-200">
                @foreach($recentInstallments as $installment)
                    @php
                        $isNew = $installment->paid_at &&
                            \Carbon\Carbon::parse($installment->paid_at)->gt(\Carbon\Carbon::now()->subHours(24));
                    @endphp
                    <div class="py-3 flex flex-col sm:flex-row sm:items-center">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-semibold">{{ $installment->order->customer->user->name ?? '-' }}</span>
                                <span class="text-xs px-2 py-0.5 bg-blue-200 text-blue-800 rounded">
                                    {{ $installment->order->car->brand ?? '-' }} {{ $installment->order->car->model ?? '-' }}
                                </span>
                                @if($isNew)
                                    <span class="ml-1 px-2 py-0.5 bg-green-400 text-white rounded text-xs font-bold animate-pulse">NEW</span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                Paid at:
                                @if($installment->paid_at)
                                    {{ \Carbon\Carbon::parse($installment->paid_at)->format('d M Y H:i') }}
                                @else
                                    <span class="italic text-gray-400">-</span>
                                @endif
                                | Amount: <span class="font-mono text-blue-700 font-bold">Rp{{ number_format($installment->amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <span class="mt-2 sm:mt-0 sm:ml-4 text-green-600 text-xs font-semibold">
                            <i class="fas fa-check-circle mr-1"></i> PAID
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function filterTable(input) {
    const filter = input.value.toLowerCase();
    const table = document.getElementById('orderTable');
    const rows = table.querySelectorAll('tbody tr');
    let anyVisible = false;

    rows.forEach(row => {
        // Jangan filter baris kosong (misal "No installment orders found.")
        if (row.querySelectorAll('td').length === 1) {
            row.style.display = '';
            return;
        }
        // Gabung seluruh teks cell dalam satu string
        const rowText = Array.from(row.querySelectorAll('td'))
            .map(td => td.innerText.toLowerCase())
            .join(' ');
        if (rowText.includes(filter)) {
            row.style.display = '';
            anyVisible = true;
        } else {
            row.style.display = 'none';
        }
    });

    // Tampilkan/hidden baris "No installment orders found."
    const emptyRow = table.querySelector('tbody tr td[colspan]');
    if (emptyRow) {
        emptyRow.parentElement.style.display = anyVisible ? 'none' : '';
    }
}
</script>
@endpush
