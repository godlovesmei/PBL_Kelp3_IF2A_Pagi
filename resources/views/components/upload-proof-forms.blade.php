{{-- Cash Payment Proof --}}
<form x-show="modalTarget==='cash'" action="{{ route('user.orders.uploadCash') }}" method="POST"
    enctype="multipart/form-data" class="space-y-4" x-transition>
    @csrf
    <input type="hidden" name="order_id" value="{{ $order->order_id }}">
    <h3 class="font-bold text-lg mb-2">Upload Payment Proof (Cash)</h3>
    <div>
        <label class="block text-gray-600 mb-1">Amount</label>
        <input type="text" value="Rp {{ number_format($order->total_price, 0, ',', '.') }}" readonly
            class="w-full p-2 border rounded-lg bg-gray-50" />
        <input type="hidden" name="amount" value="{{ $order->total_price }}">
    </div>
    <div>
        <label class="block text-gray-600 mb-1">Payment Proof</label>
        <input type="file" name="payment_proof" required class="w-full p-2 border rounded-lg bg-gray-50" />
    </div>
    <button type="submit"
        class="bg-cyan-600 hover:bg-cyan-900 text-white px-6 py-2 rounded-lg font-semibold shadow w-full">
        Upload Proof
    </button>
</form>

{{-- DP Payment Proof --}}
<form x-show="modalTarget==='dp'" action="{{ route('user.orders.uploadDP') }}" method="POST"
    enctype="multipart/form-data" class="space-y-4" x-transition>
    @csrf
    <input type="hidden" name="order_id" value="{{ $order->order_id }}">
    <h3 class="font-bold text-lg mb-2">Upload Down Payment Proof</h3>
    <div>
        <label class="block text-gray-600 mb-1">Amount</label>
        <input type="text" value="Rp {{ number_format($order->down_payment ?? 0, 0, ',', '.') }}" readonly
            class="w-full p-2 border rounded-lg bg-gray-50" />
        <input type="hidden" name="amount" value="{{ $order->down_payment }}">
    </div>
    <div>
        <label class="block text-gray-600 mb-1">Payment Proof</label>
        <input type="file" name="payment_proof" required class="w-full p-2 border rounded-lg bg-gray-50" />
    </div>
    <button type="submit"
        class="bg-cyan-600 hover:bg-teal-600 text-white px-6 py-2 rounded-lg font-semibold shadow w-full">
        Upload Proof
    </button>
</form>

{{-- Installment Payment Proof --}}
@foreach ($installments as $inst)
    <form x-show="modalTarget==='installment-{{ $inst->installment_id }}'"
        action="{{ route('user.orders.uploadInstallment') }}" method="POST" enctype="multipart/form-data"
        class="space-y-4" x-transition>
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->order_id }}">
        <input type="hidden" name="installment_id" value="{{ $inst->installment_id }}">
        <h3 class="font-bold text-lg mb-2">Upload Installment Proof #{{ $loop->index + 1 }}</h3>
        <div>
            <label class="block text-gray-600 mb-1">Amount</label>
            <input type="text" value="Rp {{ number_format($inst->amount, 0, ',', '.') }}"
                class="w-full p-2 border rounded-lg bg-gray-50" readonly>
            <input type="hidden" name="amount" value="{{ $inst->amount }}">
        </div>
        <div>
            <label class="block text-gray-600 mb-1">Payment Proof</label>
            <input type="file" name="payment_proof" required class="w-full p-2 border rounded-lg bg-gray-50" />
        </div>
        <button type="submit"
            class="bg-cyan-600 hover:bg-teal-600 text-white px-6 py-2 rounded-lg font-semibold shadow w-full">
            Upload Proof
        </button>
    </form>
@endforeach
