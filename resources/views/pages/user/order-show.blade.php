@extends('layouts.user')
@section('title', 'Order Details')

@section('content')
<div class="min-h-screen pt-[55px] bg-[#f2f2f2]">
    <!-- Header -->
    <div class="bg-gray-200 text-center py-14 mb-0">
        <h2 class="text-4xl md:text-5xl font-bold text-black">Order Details</h2>
    </div>

    <!-- Content -->
    <div class="max-w-3xl mx-auto px-4 sm:px-8 py-10">

        {{-- Summary Section --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow p-4 flex flex-col gap-2 border border-stone-200">
                <div class="text-gray-500 text-sm">Order Status</div>
                <div class="font-bold text-lg">
                    <span class="@if($order->order_status === 'pending') text-yellow-600
                                 @elseif(in_array($order->order_status, ['confirm','completed'])) text-green-700
                                 @elseif($order->order_status === 'cancelled') text-red-600
                                 @elseif($order->order_status === 'processing') text-blue-700
                                 @elseif($order->order_status === 'shipped') text-purple-700
                                 @else text-gray-700 @endif">
                        {{ ucfirst($order->order_status ?? '-') }}
                    </span>
                </div>
                <div class="text-gray-500 text-sm">Order Date</div>
                <div>{{ $order->created_at?->format('d M Y, H:i') ?? '-' }}</div>
            </div>
            <div class="bg-white rounded-xl shadow p-4 flex flex-col gap-2 border border-stone-200">
                <div class="flex items-center gap-2">
                    <span class="text-gray-500 text-sm">Total</span>
                    <span class="ml-auto text-emerald-700 font-bold text-lg">
                        Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-gray-500 text-sm">Payment Method</span>
                    <span class="ml-auto capitalize text-gray-700 font-medium">{{ $order->payment_method ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Accordion Section --}}
        <div x-data="{ openSection: null, modalOpen: false, modalTarget: '' }" class="space-y-4">

            {{-- Customer & Car Info --}}
            <div class="border rounded-xl shadow bg-white">
                <button @click="openSection === 1 ? openSection = null : openSection = 1"
                    class="w-full flex items-center justify-between px-6 py-4 font-semibold text-left text-gray-800 focus:outline-none">
                    <span>Customer & Car Information</span>
                    <svg :class="{'rotate-180': openSection===1}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openSection===1" x-transition class="px-6 pb-4 text-gray-700">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <div class="font-medium">Name:</div>
                            <div>{{ optional($customer->user)->name ?? 'N/A' }}</div>
                            <div class="font-medium mt-2">Address:</div>
                            <div>{{ optional($customer->user)->address ?? 'N/A' }}</div>
                            <div class="font-medium mt-2">Phone:</div>
                            <div>{{ optional($customer->user)->phone ?? 'N/A' }}</div>
                            <div class="font-medium mt-2">Email:</div>
                            <div>{{ optional($customer->user)->email ?? 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="font-medium">Brand:</div>
                            <div>{{ optional($order->car)->brand ?? 'N/A' }}</div>
                            <div class="font-medium mt-2">Model:</div>
                            <div>{{ optional($order->car)->model ?? 'N/A' }}</div>
                            <div class="font-medium mt-2">Price:</div>
                            <div class="text-emerald-700 font-semibold">
                                Rp {{ number_format(optional($order->car)->price ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payment Info --}}
            <div class="border rounded-xl shadow bg-white">
                <button @click="openSection === 2 ? openSection = null : openSection = 2"
                    class="w-full flex items-center justify-between px-6 py-4 font-semibold text-left text-gray-800 focus:outline-none">
                    <span>Payment Details</span>
                    <svg :class="{'rotate-180': openSection===2}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openSection===2" x-transition class="px-6 pb-4 text-gray-700">
                    <div class="mb-2">
                        <div><span class="text-gray-500">Method:</span> <span class="font-medium capitalize">{{ $order->payment_method ?? '-' }}</span></div>
                        <div><span class="text-gray-500">Down Payment:</span>
                            Rp {{ number_format($order->down_payment ?? 0, 0, ',', '.') }} ({{ $order->down_payment_percent ?? '-' }}%)
                        </div>
                        <div><span class="text-gray-500">Transfer to:</span>
                            <span class="font-medium">1234567890 (ABC Bank)</span>
                        </div>
                    </div>
                    @if($order->payment_method === 'credit')
                    <div class="border-t pt-3 mt-2">
                        <div class="font-semibold mb-1">Credit Info</div>
                        <div>Tenor: {{ $order->tenor ?? '-' }} months</div>
                        <div>Financed: Rp {{ number_format($order->amount_financed ?? 0, 0, ',', '.') }}</div>
                        <div>Monthly: Rp {{ number_format($order->monthly_installment ?? 0, 0, ',', '.') }}</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Cash/Credit Proof Upload --}}
            <div class="border rounded-xl shadow bg-white">
                <button @click="openSection === 3 ? openSection = null : openSection = 3"
                    class="w-full flex items-center justify-between px-6 py-4 font-semibold text-left text-gray-800 focus:outline-none">
                    <span>Payment Proof</span>
                    <svg :class="{'rotate-180': openSection===3}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openSection===3" x-transition class="px-6 pb-4 text-gray-700">
                    @if($order->payment_method === 'cash')
                        @if($cashPayment)
                            <ul class="space-y-1">
                                <li>Amount: <strong>Rp {{ number_format($cashPayment->amount, 0, ',', '.') }}</strong></li>
                                <li>Date: {{ \Carbon\Carbon::parse($cashPayment->payment_date)->format('d M Y') }}</li>
                                <li>Proof:
                                    <a href="{{ asset('storage/'.$cashPayment->payment_proof) }}" class="text-blue-600 underline" target="_blank">View Proof</a>
                                </li>
                            </ul>
                            <div class="mt-3 flex justify-center">
                                <a href="{{ route('user.orders.downloadInvoice', ['order_id' => $order->order_id, 'type' => 'cash']) }}"
                                   class="bg-cyan-700 hover:bg-cyan-900 text-white px-4 py-2 rounded font-semibold shadow transition">
                                    Download Invoice
                                </a>
                            </div>
                        @else
                           @if($order->order_status !== 'pending')
    <button @click="modalOpen=true;modalTarget='cash'" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded font-semibold shadow">
        Upload Payment Proof
    </button>
@else
    <button disabled class="bg-gray-400 text-white px-4 py-2 rounded font-semibold shadow cursor-not-allowed opacity-70">
        Upload Payment Proof (Waiting Approval)
    </button>
@endif
                        @endif
                    @elseif($order->payment_method === 'credit')
                        @if($dpPayment)
                            <ul class="space-y-1">
                                <li>DP: <strong>Rp {{ number_format($dpPayment->amount, 0, ',', '.') }}</strong></li>
                                <li>Date: {{ \Carbon\Carbon::parse($dpPayment->payment_date)->format('d M Y') }}</li>
                                <li>Proof:
                                    <a href="{{ asset('storage/'.$dpPayment->payment_proof) }}" class="text-blue-600 underline" target="_blank">View Proof</a>
                                </li>
                            </ul>
                            <div class="mt-3 justify-self-center flex">
                                <a href="{{ route('user.orders.downloadInvoice', ['order_id' => $order->order_id, 'type' => 'dp']) }}"
                                   class="bg-cyan-600 hover:bg-cyan-800 text-white px-4 py-2 rounded font-semibold shadow transition">
                                    Download Invoice
                                </a>
                            </div>
                        @else
                            @if($order->order_status !== 'pending')
    <button @click="modalOpen=true;modalTarget='dp'" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded font-semibold shadow">
        Upload DP Proof
    </button>
@else
    <button disabled class="bg-gray-400 text-white px-4 py-2 rounded font-semibold shadow cursor-not-allowed opacity-70">
        Upload DP Proof (Waiting Approval)
    </button>
@endif

                        @endif
                    @endif
                </div>
            </div>

            {{-- Installment History (if credit) --}}
            @if($order->payment_method === 'credit')
            <div class="border rounded-xl shadow bg-white">
                <button @click="openSection === 4 ? openSection = null : openSection = 4"
                    class="w-full flex items-center justify-between px-6 py-4 font-semibold text-left text-gray-800 focus:outline-none">
                    <span>Installment History</span>
                    <svg :class="{'rotate-180': openSection===4}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openSection===4" x-transition class="px-2 pb-4">
                    @if($installments->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border border-gray-200 rounded-xl shadow">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-2 py-3 border">No.</th>
                                    <th class="px-2 py-3 border">Due Date</th>
                                    <th class="px-2 py-3 border">Amount</th>
                                    <th class="px-2 py-3 border">Status</th>
                                    <th class="px-2 py-3 border">Proof</th>
                                    <th class="px-2 py-3 border">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($installments as $i => $inst)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 py-2 border text-center">{{ $i+1 }}</td>
                                    <td class="px-2 py-2 border">{{ \Carbon\Carbon::parse($inst->due_date)->format('d M Y') }}</td>
                                    <td class="px-2 py-2 border">Rp {{ number_format($inst->amount, 0, ',', '.') }}</td>
                                    <td class="px-2 py-2 border text-center">
                                        @if($inst->status === 'paid')
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Paid</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Unpaid</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-2 border text-center">
                                        @if($inst->payments && $inst->payments->count())
                                            @foreach($inst->payments as $pay)
                                                <a href="{{ asset('storage/' . $pay->payment_proof) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $pay->payment_proof) }}" alt="Proof" width="60" class="rounded shadow mx-auto">
                                                </a>
                                                <br>
                                                <small class="text-gray-500">{{ $pay->payment_date }}</small>
                                            @endforeach
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-2 border text-center">
                                        @if($inst->status === 'unpaid' && $dpPayment)
                                            <button @click="modalOpen=true;modalTarget='installment-{{ $inst->installment_id }}'"
                                                class="bg-cyan-600 hover:bg-teal-600 text-white px-4 py-1 rounded text-xs font-semibold shadow">
                                                Upload Proof
                                            </button>
                                        @elseif($inst->status === 'paid' && $inst->payments->count())
                                            <a href="{{ route('user.orders.downloadInvoice', [
                                                'order_id' => $order->order_id,
                                                'type' => 'installment',
                                                'installment_id' => $inst->installment_id
                                            ]) }}"
                                               class="inline-block bg-slate-700 hover:bg-cyan-800 text-white px-4 py-1 rounded text-xs mt-1 font-semibold shadow">
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
                        <p class="text-gray-500 mt-2 px-4">No installment payments yet.</p>
                    @endif
                </div>
            </div>
            @endif

            {{-- Modal Upload Proof --}}
            <div x-show="modalOpen" x-cloak
                class="fixed inset-0 z-40 flex items-center justify-center bg-black/30"
                x-transition>
                <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-sm relative">
                    <button @click="modalOpen=false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>

                    {{-- Cash Payment Proof --}}
                    <form x-show="modalTarget==='cash'" action="{{ route('user.orders.uploadCash') }}" method="POST" enctype="multipart/form-data" class="space-y-4" x-transition>
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                        <h3 class="font-bold text-lg mb-2">Upload Payment Proof (Cash)</h3>
                        <div>
                            <label class="block text-gray-600 mb-1">Amount</label>
                            <input type="text" value="Rp {{ number_format($order->total_price, 0, ',', '.') }}" readonly class="w-full p-2 border rounded-lg bg-gray-50" />
                            <input type="hidden" name="amount" value="{{ $order->total_price }}">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1">Payment Proof</label>
                            <input type="file" name="payment_proof" required class="w-full p-2 border rounded-lg bg-gray-50" />
                        </div>
                        <button type="submit" class="bg-cyan-600 hover:bg-cyan-900 text-white px-6 py-2 rounded-lg font-semibold shadow w-full">
                            Upload Proof
                        </button>
                    </form>

                    {{-- DP Payment Proof --}}
                    <form x-show="modalTarget==='dp'" action="{{ route('user.orders.uploadDP') }}" method="POST" enctype="multipart/form-data" class="space-y-4" x-transition>
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                        <h3 class="font-bold text-lg mb-2">Upload DP Proof</h3>
                        <div>
                            <label class="block text-gray-600 mb-1">Amount</label>
                            <input type="text" value="Rp {{ number_format($order->down_payment ?? 0, 0, ',', '.') }}" readonly class="w-full p-2 border rounded-lg bg-gray-50" />
                            <input type="hidden" name="amount" value="{{ $order->down_payment }}">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1">Payment Proof</label>
                            <input type="file" name="payment_proof" required class="w-full p-2 border rounded-lg bg-gray-50" />
                        </div>
                        <button type="submit" class="bg-cyan-600 hover:bg-teal-600 text-white px-6 py-2 rounded-lg font-semibold shadow w-full">
                            Upload Proof
                        </button>
                    </form>

                    {{-- Installment Payment Proof --}}
                    @foreach($installments as $inst)
                    <form x-show="modalTarget==='installment-{{ $inst->installment_id }}'"
                        action="{{ route('user.orders.uploadInstallment') }}" method="POST" enctype="multipart/form-data" class="space-y-4" x-transition>
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                        <input type="hidden" name="installment_id" value="{{ $inst->installment_id }}">
                        <h3 class="font-bold text-lg mb-2">Upload Installment Proof #{{ $loop->index+1 }}</h3>
                        <div>
                            <label class="block text-gray-600 mb-1">Amount</label>
                            <input type="text" value="Rp {{ number_format($inst->amount, 0, ',', '.') }}" class="w-full p-2 border rounded-lg bg-gray-50" readonly>
                            <input type="hidden" name="amount" value="{{ $inst->amount }}">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-1">Payment Proof</label>
                            <input type="file" name="payment_proof" required class="w-full p-2 border rounded-lg bg-gray-50" />
                        </div>
                        <button type="submit" class="bg-cyan-600 hover:bg-teal-600 text-white px-6 py-2 rounded-lg font-semibold shadow w-full">
                            Upload Proof
                        </button>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-14 text-center">
            <a href="{{ route('user.orders.index') }}"
               class="inline-block bg-[#cfeeea] hover:bg-[#b0dad4] text-[#2f4442] font-bold py-3 px-8 rounded-xl text-lg shadow transition duration-300">
                &larr; Back to Order History
            </a>
        </div>
    </div>
</div>
@endsection
