@props(['order', 'cashPayment' => null, 'dpPayment' => null])

<div class="mb-2 space-y-3">
    {{-- Payment Info --}}
    <div>
        <span class="text-gray-500">Method:</span>
        <span class="font-medium capitalize">{{ $order->payment_method ?? '-' }}</span>
    </div>
    <div>
        <span class="text-gray-500">Down Payment:</span>
        <span>
            Rp {{ number_format($order->down_payment ?? 0, 0, ',', '.') }}
            ({{ $order->down_payment_percent ?? '-' }}%)
        </span>
    </div>
    <div>
        <span class="text-gray-500">Transfer to:</span>
        <span class="font-medium">1234567890 (ABC Bank)</span>
    </div>

    {{-- Credit Extra Info --}}
    @if($order->payment_method === 'credit')
    <div class="border-t pt-3 mt-4 space-y-1">
        <div class="font-semibold mb-1">Credit Info</div>
        <div>
            <span class="text-gray-500">Tenor:</span>
            <span>{{ $order->tenor ?? '-' }} months</span>
        </div>
        <div>
            <span class="text-gray-500">Financed:</span>
            <span>Rp {{ number_format($order->amount_financed ?? 0, 0, ',', '.') }}</span>
        </div>
        <div>
            <span class="text-gray-500">Monthly:</span>
            <span>Rp {{ number_format($order->monthly_installment ?? 0, 0, ',', '.') }}</span>
        </div>
    </div>
    @endif
</div>

{{-- Payment Proof Section --}}
<div class="mt-5">
    @if($order->payment_method === 'cash')
        @if($cashPayment)
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-3 flex items-center gap-4">
                <div class="flex-1">
                    <div class="text-green-700 font-semibold mb-1">Payment Proof Uploaded</div>
                    <ul class="text-sm">
                        <li>Amount: <b>Rp {{ number_format($cashPayment->amount, 0, ',', '.') }}</b></li>
                        <li>Date: {{ \Carbon\Carbon::parse($cashPayment->payment_date)->format('d M Y') }}</li>
                        <li>Proof:
                            <a href="{{ asset('storage/'.$cashPayment->payment_proof) }}" class="text-blue-600 underline ml-1" target="_blank">View</a>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('user.orders.downloadInvoice', ['order_id' => $order->order_id, 'type' => 'cash']) }}"
                   class="bg-cyan-700 hover:bg-cyan-900 text-white px-4 py-2 rounded font-semibold shadow transition text-sm">
                    Download Invoice
                </a>
            </div>
        @else
            @if($order->order_status !== 'pending')
                <button
                    @click="modalOpen=true;modalTarget='cash'"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded font-semibold shadow w-full transition">
                    Upload Payment Proof
                </button>
            @else
                <button disabled class="bg-gray-400 text-white px-4 py-2 rounded font-semibold shadow w-full opacity-70 cursor-not-allowed">
                    Upload Payment Proof (Waiting Approval)
                </button>
            @endif
        @endif

    @elseif($order->payment_method === 'credit')
        @if($dpPayment)
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-3 flex items-center gap-4">
                <div class="flex-1">
                    <div class="text-green-700 font-semibold mb-1">Down Payment Proof Uploaded</div>
                    <ul class="text-sm">
                        <li>DP: <b>Rp {{ number_format($dpPayment->amount, 0, ',', '.') }}</b></li>
                        <li>Date: {{ \Carbon\Carbon::parse($dpPayment->payment_date)->format('d M Y') }}</li>
                        <li>Proof:
                            <a href="{{ asset('storage/'.$dpPayment->payment_proof) }}" class="text-blue-600 underline ml-1" target="_blank">View</a>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('user.orders.downloadInvoice', ['order_id' => $order->order_id, 'type' => 'dp']) }}"
                   class="bg-cyan-700 hover:bg-cyan-900 text-white px-4 py-2 rounded font-semibold shadow transition text-sm">
                    Download Invoice
                </a>
            </div>
        @else
            @if($order->order_status !== 'pending')
                <button
                    @click="modalOpen=true;modalTarget='dp'"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded font-semibold shadow w-full transition">
                    Upload Down Payment Proof
                </button>
            @else
                <button disabled class="bg-gray-400 text-white px-4 py-2 rounded font-semibold shadow w-full opacity-70 cursor-not-allowed">
                    Upload DP Proof (Waiting Approval)
                </button>
            @endif
        @endif
    @endif
</div>
