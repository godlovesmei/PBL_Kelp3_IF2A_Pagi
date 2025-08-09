@if ($order->payment_method === 'cash')
    @if ($cashPayment)
        <ul class="space-y-1">
            <li>Amount: <strong>Rp {{ number_format($cashPayment->amount, 0, ',', '.') }}</strong></li>
            <li>Date: {{ \Carbon\Carbon::parse($cashPayment->payment_date)->format('d M Y') }}</li>
            <li>Proof:
                <a href="{{ asset('storage/' . $cashPayment->payment_proof) }}" class="text-blue-600 underline"
                    target="_blank">View Proof</a>
            </li>
        </ul>
        <div class="mt-3 flex justify-center">
            <a href="{{ route('user.orders.downloadInvoice', ['order_id' => $order->order_id, 'type' => 'cash']) }}"
                class="bg-cyan-700 hover:bg-cyan-900 text-white px-4 py-2 rounded font-semibold shadow transition">
                Download Invoice
            </a>
        </div>
    @else
        @if ($order->order_status !== 'pending')
            <button @click="modalOpen=true;modalTarget='cash'"
                class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded font-semibold shadow">
                Upload Payment Proof
            </button>
        @else
            <button disabled
                class="bg-gray-400 text-white px-4 py-2 rounded font-semibold shadow cursor-not-allowed opacity-70">
                Upload Payment Proof (Waiting Approval)
            </button>
        @endif
    @endif
@elseif($order->payment_method === 'credit')
    @if ($dpPayment)
        <ul class="space-y-1">
            <li>DP: <strong>Rp {{ number_format($dpPayment->amount, 0, ',', '.') }}</strong></li>
            <li>Date: {{ \Carbon\Carbon::parse($dpPayment->payment_date)->format('d M Y') }}</li>
            <li>Proof:
                <a href="{{ asset('storage/' . $dpPayment->payment_proof) }}" class="text-blue-600 underline"
                    target="_blank">View Proof</a>
            </li>
        </ul>
        <div class="mt-3 justify-self-center flex">
            <a href="{{ route('user.orders.downloadInvoice', ['order_id' => $order->order_id, 'type' => 'dp']) }}"
                class="bg-cyan-600 hover:bg-cyan-800 text-white px-4 py-2 rounded font-semibold shadow transition">
                Download Invoice
            </a>
        </div>
    @else
        @if ($order->order_status !== 'pending')
            <button @click="modalOpen=true;modalTarget='dp'"
                class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded font-semibold shadow">
                Upload DP Proof
            </button>
        @else
            <button disabled
                class="bg-gray-400 text-white px-4 py-2 rounded font-semibold shadow cursor-not-allowed opacity-70">
                Upload DP Proof (Waiting Approval)
            </button>
        @endif
    @endif
@endif
