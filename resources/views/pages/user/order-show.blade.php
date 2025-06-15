@extends('layouts.user')

@section('title', 'Order Details')

@section('content')
<div class="max-w-4xl mx-auto mt-12 pt-[80px] px-4 sm:px-8 lg:px-12">
    <h1 class="text-4xl font-bold mb-12 text-center text-gray-900 tracking-tight">Order Details</h1>

    {{-- Order Summary --}}
    <section class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 sm:p-10 mb-14">
       <div class="grid grid-cols-1 md:grid-cols-2 gap-x-14 gap-y-10 text-gray-700 text-base">
            {{-- Customer Info --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    {{-- User icon --}}
                    <svg class="w-5 h-5 text-stone-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2" fill="none"/>
                        <path d="M4 20c0-4 4-7 8-7s8 3 8 7" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                    Customer Information
                </h3>
                <div class="space-y-2">
                    <div><span class="text-gray-500">Name:</span> <span class="font-medium">{{ optional($customer->user)->name ?? 'N/A' }}</span></div>
                    <div><span class="text-gray-500">Address:</span> <span class="font-medium">{{ optional($customer->user)->address ?? 'N/A' }}</span></div>
                </div>
            </div>

            {{-- Car Info --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    {{-- Car icon --}}
                    <svg class="w-5 h-5 text-stone-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="11" width="18" height="5" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
                        <path d="M5 16v2a2 2 0 002 2h1a2 2 0 002-2v-2" stroke="currentColor" stroke-width="2" fill="none"/>
                        <path d="M17 16v2a2 2 0 002 2h1a2 2 0 002-2v-2" stroke="currentColor" stroke-width="2" fill="none"/>
                        <circle cx="7.5" cy="16.5" r="1.5" stroke="currentColor" stroke-width="2"/>
                        <circle cx="16.5" cy="16.5" r="1.5" stroke="currentColor" stroke-width="2"/>
                        <path d="M3 11l2.5-7h13l2.5 7" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Car Information
                </h3>
                <div class="space-y-2">
                    <div><span class="text-gray-500">Brand:</span> <span class="font-medium">{{ optional($order->car)->brand ?? 'N/A' }}</span></div>
                    <div><span class="text-gray-500">Model:</span> <span class="font-medium">{{ optional($order->car)->model ?? 'N/A' }}</span></div>
                    <div>
                        <span class="text-gray-500">Price:</span>
                        <span class="text-emerald-600 font-semibold">Rp {{ number_format(optional($order->car)->price ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Order Info --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    {{-- Calendar/Clipboard/Order icon --}}
                    <svg class="w-5 h-5 text-stone-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="6" y="4" width="12" height="16" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M9 2v4M15 2v4" stroke="currentColor" stroke-width="2"/>
                        <path d="M9 10h6" stroke="currentColor" stroke-width="2"/>
                        <path d="M9 14h2" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Order Information
                </h3>
                <div class="space-y-2">
                    <div><span class="text-gray-500">Order Date:</span> <span class="font-medium">{{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}</span></div>
                    <div>
                        <span class="text-gray-500">Status:</span>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                            @if($order->order_status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->order_status === 'confirm') bg-green-100 text-green-800
                            @elseif($order->order_status === 'completed') bg-green-100 text-green-800
                            @elseif($order->order_status === 'cancelled') bg-red-100 text-red-800
                            @elseif($order->order_status === 'processing') bg-blue-100 text-blue-800
                            @elseif($order->order_status === 'shipped') bg-purple-100 text-purple-800
                            @else bg-gray-100 text-gray-800
                            @endif
                        ">
                            {{ ucfirst($order->order_status ?? '-') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Payment Info --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    {{-- Credit card/payment icon --}}
                    <svg class="w-5 h-5 text-stone-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="2" y="5" width="20" height="14" rx="3" stroke="currentColor" stroke-width="2"/>
                        <path d="M2 10h20" stroke="currentColor" stroke-width="2"/>
                        <path d="M6 15h.01M9 15h2" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Payment Details
                </h3>
                <div class="space-y-2">
                    <div><span class="text-gray-500">Method:</span> <span class="font-medium capitalize">{{ $order->payment_method ?? '-' }}</span></div>
                    <div>
                        <span class="text-gray-500">Total Price:</span>
                        <span class="text-emerald-600 font-semibold">Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Down Payment:</span>
                        Rp {{ number_format($order->down_payment ?? 0, 0, ',', '.') }}
                        ({{ $order->down_payment_percent ?? '-' }}%)
                    </div>
                    <div>
                        <span class="text-gray-500">Transfer to:</span>
                        <span class="font-medium text-gray-900">1234567890 (ABC Bank)</span>
                    </div>
                </div>
            </div>

            {{-- Credit Details --}}
            @if($order->payment_method === 'credit')
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    {{-- Installment/credit icon --}}
                    <svg class="w-5 h-5 text-stone-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="4" y="6" width="16" height="12" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M12 17v-5" stroke="currentColor" stroke-width="2"/>
                        <circle cx="12" cy="12" r="1" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Credit Information
                </h3>
                <div class="space-y-2">
                    <div><span class="text-gray-500">Tenor:</span> <span class="font-medium">{{ $order->tenor ?? '-' }} months</span></div>
                    <div><span class="text-gray-500">Financed:</span> Rp {{ number_format($order->amount_financed ?? 0, 0, ',', '.') }}</div>
                    <div><span class="text-gray-500">Monthly Installment:</span> Rp {{ number_format($order->monthly_installment ?? 0, 0, ',', '.') }}</div>
                </div>
            </div>
            @endif
        </div>

        {{-- CASH Payment Proof --}}
        @if($order->payment_method === 'cash')
        <div class="mt-12 border-t border-gray-200 pt-8">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 flex items-center gap-2">
                {{-- Receipt/document icon --}}
                <svg class="w-5 h-5 text-stone-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
                    <path d="M9 7h6M9 11h6M9 15h2" stroke="currentColor" stroke-width="2"/>
                </svg>
                Cash Payment Proof
            </h3>

            @if($cashPayment)
                <ul class="list-disc pl-6 text-base text-gray-700 space-y-1">
                    <li>Amount: <strong>Rp {{ number_format($cashPayment->amount, 0, ',', '.') }}</strong></li>
                    <li>Date: {{ \Carbon\Carbon::parse($cashPayment->payment_date)->format('d M Y') }}</li>
                    <li>Proof:
                        <a href="{{ asset('storage/'.$cashPayment->payment_proof) }}" class="text-blue-600 underline font-medium" target="_blank">
                            View Proof
                        </a>
                    </li>
                </ul>

                {{-- Download Invoice Button --}}
                <div class="mt-5">
                    <a href="{{ route('user.orders.downloadInvoice', ['order_id' => $order->order_id, 'type' => 'cash']) }}"
                       class="inline-block bg-cyan-700 hover:bg-cyan-900 text-white text-base px-4 py-2 rounded-lg font-semibold shadow transition">
                        Download Invoice
                    </a>
                </div>
            @else
                <form action="{{ route('user.orders.uploadCash') }}" method="POST" enctype="multipart/form-data" class="space-y-4 mt-2">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                    <div>
                        <label class="block text-gray-600 mb-1">Amount</label>
                        <input type="number" name="amount" value="{{ $order->total_price }}" readonly class="w-full p-2 border rounded-lg bg-gray-50" />
                    </div>
                    <div>
                        <label class="block text-gray-600 mb-1">Payment Proof</label>
                        <input type="file" name="payment_proof" required class="w-full p-2 border rounded-lg bg-gray-50" />
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold shadow">
                        Upload Proof
                    </button>
                </form>
            @endif
        </div>
        @endif

        {{-- CREDIT - Down Payment Proof --}}
        @if($order->payment_method === 'credit')
        <div class="mt-12 border-t border-gray-200 pt-8">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 flex items-center gap-2">
                {{-- Receipt/document icon --}}
                <svg class="w-5 h-5 text-stone-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="5" y="3" width="14" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
                    <path d="M9 7h6M9 11h6M9 15h2" stroke="currentColor" stroke-width="2"/>
                </svg>
                Down Payment Proof (Credit)
            </h3>
            @if($dpPayment)
                <ul class="list-disc pl-6 text-base text-gray-700 space-y-1">
                    <li>Amount: <strong>Rp {{ number_format($dpPayment->amount, 0, ',', '.') }}</strong></li>
                    <li>Date: {{ \Carbon\Carbon::parse($dpPayment->payment_date)->format('d M Y') }}</li>
                    <li>Proof:
                        <a href="{{ asset('storage/'.$dpPayment->payment_proof) }}" class="text-blue-600 underline font-medium" target="_blank">
                            View Proof
                        </a>
                    </li>
                </ul>
                <div class="mt-5">
                    <a href="{{ route('user.orders.downloadInvoice', ['order_id' => $order->order_id, 'type' => 'dp']) }}"
                       class="inline-block bg-slate-700 hover:bg-cyan-800 text-white text-base px-4 py-2 rounded-lg font-semibold shadow transition">
                        Download DP Invoice
                    </a>
                </div>
            @else
                <form action="{{ route('user.orders.uploadDP') }}" method="POST" enctype="multipart/form-data" class="space-y-4 mt-2">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                    <div>
                        <label class="block text-gray-600 mb-1">Amount</label>
                        <input type="number" name="amount" value="{{ $order->down_payment }}" readonly class="w-full p-2 border rounded-lg bg-gray-50" />
                    </div>
                    <div>
                        <label class="block text-gray-600 mb-1">Payment Proof</label>
                        <input type="file" name="payment_proof" required class="w-full p-2 border rounded-lg bg-gray-50" />
                    </div>
                    <button type="submit" class="bg-cyan-600 hover:bg-teal-600 text-white px-6 py-2 rounded-lg font-semibold shadow">
                        Upload Proof
                    </button>
                </form>
            @endif
        </div>

        {{-- ▼ Installment History Toggle Button --}}
        <div class="mt-12 border-t border-gray-200 pt-8 relative">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                    {{-- Timeline/history icon --}}
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    Installment Payment History
                </h3>
                <button onclick="toggleInstallmentPopup()" class="text-blue-900 hover:text-slate-600 text-lg font-semibold flex items-center gap-1 focus:outline-none transition">
                    <span>Show Details</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform duration-300" id="arrowIcon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>

            {{-- ⬇ Installment Popup --}}
            <div id="installmentPopup" class="mt-4 hidden transition-all duration-300">
                @if($installments->count() > 0)
                <div class="overflow-x-auto mt-4">
                    <table class="w-full table-auto border-collapse border border-gray-200 rounded-xl shadow">
                        <thead class="bg-gray-100 text-gray-800 text-base">
                            <tr>
                                <th class="px-4 py-3 border">No.</th>
                                <th class="px-4 py-3 border">Due Date</th>
                                <th class="px-4 py-3 border">Amount</th>
                                <th class="px-4 py-3 border">Status</th>
                                <th class="px-4 py-3 border">Payment Proof</th>
                                <th class="px-4 py-3 border">Upload</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($installments as $i => $inst)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 border text-center">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 border">{{ \Carbon\Carbon::parse($inst->due_date)->format('d M Y') }}</td>
                                <td class="px-4 py-3 border">Rp {{ number_format($inst->amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 border text-center">
                                    @if($inst->status === 'paid')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Paid</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Unpaid</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 border text-center">
                                    @if($inst->payments && $inst->payments->count())
                                        @foreach($inst->payments as $pay)
                                            <a href="{{ asset('storage/' . $pay->payment_proof) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $pay->payment_proof) }}" alt="Installment Proof" width="70" class="mb-1 rounded shadow" style="object-fit:contain;">
                                            </a>
                                            <br>
                                            <small class="text-gray-500">{{ $pay->payment_date }}</small>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 border text-center">
                                    @if($inst->status === 'unpaid' && $dpPayment)
                                        <form action="{{ route('user.orders.uploadInstallment') }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                            <input type="hidden" name="installment_id" value="{{ $inst->installment_id }}">
                                            <div class="text-sm text-gray-700 mb-1">
                                                Transfer to: <strong>1234567890 (ABC Bank)</strong>
                                            </div>
                                        @php
                                            $formattedAmount = 'Rp ' . number_format($inst->amount, 0, ',', '.');
                                        @endphp
                                            <input type="text" value="{{ $formattedAmount }}" class="w-full p-2 border rounded-lg bg-gray-50 mb-2" readonly>
                                            <input type="hidden" name="amount" value="{{ $inst->amount }}">
                                            <input type="file" name="payment_proof" class="w-full p-2 border rounded-lg bg-gray-50 mb-2" required>
                                            <button type="submit" class="bg-cyan-600 hover:bg-teal-600 text-white px-4 py-1 rounded text-xs font-semibold shadow">
                                                Upload
                                            </button>
                                        </form>
                                    @elseif($inst->status === 'paid' && $inst->payments->count())
                                        <a href="{{ route('user.orders.downloadInvoice', [
                                            'order_id' => $order->order_id,
                                            'type' => 'installment',
                                            'installment_id' => $inst->installment_id
                                        ]) }}" class="inline-block bg-slate-700 hover:bg-cyan-800 text-white px-4 py-1 rounded text-xs mt-1 font-semibold shadow">
                                            Download Invoice
                                        </a>
                                    @elseif(!$dpPayment)
                                        <span class="text-red-600 text-xs">Upload DP first</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <p class="text-gray-500 mt-2">No installment payments have been made yet.</p>
                @endif
            </div>
        </div>
        @endif

        <div class="mt-14 text-center">
            <a href="{{ route('user.orders.index') }}"
               class="inline-block bg-indigo-700 hover:bg-indigo-900 text-white font-bold py-3 px-8 rounded-xl text-lg shadow transition duration-300">
                &larr; Back to Order History
            </a>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    function toggleInstallmentPopup() {
        const popup = document.getElementById('installmentPopup');
        const arrow = document.getElementById('arrowIcon');
        popup.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    // Optional: Close popup when clicking outside
    document.addEventListener('click', function(event) {
        const popup = document.getElementById('installmentPopup');
        const arrow = document.getElementById('arrowIcon');
        const button = event.target.closest('button');
        const isInsidePopup = popup.contains(event.target);

        if (!isInsidePopup && !(button && button.onclick?.toString().includes('toggleInstallmentPopup'))) {
            popup.classList.add('hidden');
            arrow.classList.remove('rotate-180');
        }
    });
</script>
@endpush
