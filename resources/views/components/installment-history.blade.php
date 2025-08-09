@if ($installments->count())
    <div class="overflow-x-auto">
        <table class="w-full text-sm border border-gray-200 rounded-xl shadow">
            <thead class="bg-blue-100">
                <tr>
                    <th class="px-2 py-3 border text-center">No.</th>
                    <th class="px-2 py-3 border text-center">Due Date</th>
                    <th class="px-2 py-3 border text-center">Amount</th>
                    <th class="px-2 py-3 border text-center">Status</th>
                    <th class="px-2 py-3 border text-center">Payment Proof</th>
                    <th class="px-2 py-3 border text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($installments as $i => $inst)
                    @php
                        $canUpload = $i === 0 || $installments[$i - 1]->status === 'paid';
                        $payments = $inst->payments ? $inst->payments->sortByDesc('payment_date') : collect();
                        $latestPayment = $payments->first();
                    @endphp
                    <tr class="hover:bg-blue-50/70 transition-colors">
                        <td class="px-2 py-2 border text-center font-semibold text-gray-700">{{ $i + 1 }}</td>
                        <td class="px-2 py-2 border text-center">
                            {{ \Carbon\Carbon::parse($inst->due_date)->format('d M Y') }}</td>
                        <td class="px-2 py-2 border text-center text-gray-800">Rp
                            {{ number_format($inst->amount, 0, ',', '.') }}</td>

                        {{-- STATUS --}}
                        <td class="px-2 py-2 border text-center">
                            @if ($inst->status === 'paid')
                                <span
                                    class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Paid</span>
                            @elseif($inst->status === 'waiting_confirmation')
                                <span
                                    class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Pending</span>
                            @elseif($inst->status === 'rejected')
                                <span
                                    class="px-2 py-1 bg-red-200 text-red-800 rounded-full text-xs font-semibold">Rejected</span>
                            @else
                                <span
                                    class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Unpaid</span>
                            @endif
                        </td>

                        {{-- PROOF --}}
                        <td class="px-2 py-2 border text-center">
                            @if ($latestPayment)
                                <a href="{{ asset('storage/' . $latestPayment->payment_proof) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $latestPayment->payment_proof) }}" alt="Proof"
                                        width="48" class="rounded shadow mx-auto border border-gray-200">
                                </a>
                                <div class="text-xs text-gray-400 mt-1">
                                    {{ \Carbon\Carbon::parse($latestPayment->payment_date)->format('d M Y') }}</div>
                                @if ($payments->count() > 1)
                                    <div x-data="{ showHistory: false }" class="mt-1">
                                        <button type="button" @click="showHistory = !showHistory"
                                            class="text-xs text-blue-700 hover:underline focus:outline-none">
                                            <span x-show="!showHistory">View All</span>
                                            <span x-show="showHistory">Hide</span>
                                        </button>
                                        <div x-show="showHistory" class="mt-2 space-y-2">
                                            @foreach ($payments->skip(1) as $pay)
                                                <a href="{{ asset('storage/' . $pay->payment_proof) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $pay->payment_proof) }}"
                                                        alt="Proof" width="32"
                                                        class="rounded shadow inline-block border border-gray-100">
                                                </a>
                                                <div class="text-[10px] text-gray-300">
                                                    {{ \Carbon\Carbon::parse($pay->payment_date)->format('d M Y') }}
                                                </div>
                                                <hr class="my-1 border-dashed border-gray-100">
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @else
                                <span class="text-gray-300 text-base">–</span>
                            @endif
                        </td>

                        {{-- ACTION --}}
                        <td class="px-2 py-2 border text-center">
                            @if ($inst->status === 'unpaid' && $dpPayment)
                                <button
                                    @if ($canUpload) @click="modalOpen=true;modalTarget='installment-{{ $inst->installment_id }}'"
                                class="bg-cyan-600 hover:bg-teal-600 text-white px-3 py-1 rounded text-xs font-semibold shadow transition"
                            @else
                                disabled
                                class="bg-gray-200 text-gray-400 px-3 py-1 rounded text-xs font-semibold shadow cursor-not-allowed"
                                title="Please complete the previous installment first." @endif>
                                    Upload Proof
                                </button>
                            @elseif($inst->status === 'waiting_confirmation')
                                <span class="text-yellow-700 text-xs font-semibold">Awaiting Confirmation</span>
                            @elseif($inst->status === 'rejected')
                                <span class="text-red-700 text-xs font-semibold">Rejected, upload again</span>
                                <button
                                    @if ($canUpload) @click="modalOpen=true;modalTarget='installment-{{ $inst->installment_id }}'"
                                class="bg-cyan-600 hover:bg-teal-600 text-white px-3 py-1 rounded text-xs font-semibold shadow mt-1 transition"
                            @else
                                disabled
                                class="bg-gray-200 text-gray-400 px-3 py-1 rounded text-xs font-semibold shadow mt-1 cursor-not-allowed"
                                title="Please complete the previous installment first." @endif>
                                    Upload Proof
                                </button>
                            @elseif($inst->status === 'paid' && $inst->payments->count())
                                <a href="{{ route('user.orders.downloadInvoice', [
                                    'order_id' => $order->order_id,
                                    'type' => 'installment',
                                    'installment_id' => $inst->installment_id,
                                ]) }}"
                                    class="inline-flex items-center bg-slate-700 hover:bg-cyan-800 text-white px-3 py-1 rounded text-xs mt-1 font-semibold shadow transition">
                                    {{-- PDF Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 text-white"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8.828a2 2 0 0 0-.586-1.414l-4.828-4.828A2 2 0 0 0 13.172 2H6zm7 1.414L18.586 9H14a1 1 0 0 1-1-1V3.414zM9 13H8v3H6v-6h3a1 1 0 0 1 0 2zm5 0h-1v3h-2v-6h3a1 1 0 0 1 0 2zm3 0h-1v3h-2v-6h3a1 1 0 0 1 0 2z" />
                                    </svg>
                                    Invoice
                                </a>
                            @elseif(!$dpPayment)
                                <span class="text-red-600 text-xs">Please upload DP first</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Download Recap --}}
    <div class="mt-10 flex flex-col md:flex-row items-center justify-between gap-3 px-2">
        <p class="text-gray-600 text-sm md:text-left text-center mb-2 md:mb-0">
            Download a summary of your verified payments (DP &amp; installments).
        </p>
        <a href="{{ route('user.orders.recap', $order->order_id) }}"
            class="inline-flex items-center gap-1 bg-[#e2f5f2] hover:bg-[#cfeeea] text-[#2f4442] font-semibold py-2 px-4 rounded-lg text-xs shadow transition">
            {{-- Small PDF File Icon --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#2f4442]" fill="none" viewBox="0 0 20 20"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6v6m0 0l-2-2m2 2l2-2M6 10a2 2 0 012-2h4a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4z" />
            </svg>
            Download Summary
        </a>
    </div>
@else
    <p class="text-gray-400 mt-2 px-4 text-center text-sm">No installment payments available.</p>
@endif
