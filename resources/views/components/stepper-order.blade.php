@props([
    'current' => '',
    'type' => 'cash', // 'cash' or 'credit'
])

@php
    // Step labels & icons universal
    $stepDefinitions = [
        'pending' => [
            'label' => 'Order Placed',
            'icon' => 'shopping-cart',
        ],
        'confirm' => [
            'label' => 'Confirmed',
            'icon' => 'badge-check',
        ],
        'payment' => [
            'label' => 'Paid in Full',
            'icon' => 'credit-card',
        ],
        'leasing_review' => [
            'label' => 'Leasing Review',
            'icon' => 'document-check',
        ],
        'dp_paid' => [
            'label' => 'DP Paid',
            'icon' => 'credit-card',
        ],
        'contract_ready' => [
            'label' => 'Contract Ready',
            'icon' => 'clipboard-document-check',
        ],
        'processing' => [
            'label' => 'In Warehouse',
            'icon' => 'package',
        ],
        'shipped' => [
            'label' => 'On Delivery',
            'icon' => 'truck',
        ],
        'delivered' => [
            'label' => 'Delivered',
            'icon' => 'check-circle',
        ],
        'completed' => [
            'label' => 'Completed',
            'icon' => 'star',
        ],
    ];

    // Description per type per key
    $stepDescriptions = [
        'cash' => [
            'pending' => 'Your order has been successfully created. Awaiting confirmation from the seller.',
            'confirm' => 'Your order has been confirmed. Please proceed with the payment.',
            'payment' => 'Your payment has been received. Seller is verifying your transaction.',
            'processing' => 'Payment verified. Your item is being packed and prepared for shipment.',
            'shipped' => 'Your order has been shipped and is on its way.',
            'delivered' => 'Order delivered to your address. Please confirm receipt.',
            'completed' => 'Transaction complete. Thank you for your purchase!',
        ],
        'credit' => [
            'pending' => 'Order has been created. Awaiting seller confirmation.',
            'confirm' => 'Order confirmed. Sales representative will guide you through credit steps.',
            'leasing_review' => 'Leasing documents under review by our financing partner.',
            'dp_paid' => 'Your down payment has been received. Seller is verifying the proof of payment.',
            'contract_ready' => 'Your credit contract is ready to be signed before shipping.',
            'processing' => 'All documents verified. Your item is being prepared for delivery.',
            'shipped' => 'Your item is being shipped to your address.',
            'delivered' => 'Your item has arrived. Confirm receipt to activate the credit term.',
            'completed' => 'Order and credit setup are complete. Thank you for your trust!',
        ],
    ];

    // Daftar step untuk cash & credit (urutan stepper)
    $stepsByType = [
        'cash' => [
            'pending',
            'confirm',
            'payment',
            'processing',
            'shipped',
            'delivered',
            'completed',
        ],
        'credit' => [
            'pending',
            'confirm',
            'leasing_review',
            'dp_paid',
            'contract_ready',
            'processing',
            'shipped',
            'delivered',
            'completed',
        ],
    ];

    $stepKeys = $stepsByType[$type] ?? [];
    $currentIndex = array_search($current, $stepKeys);
@endphp

<div class="flex items-start justify-between w-full max-w-5xl mx-auto py-8 px-4 overflow-x-auto-hidden relative">

    @foreach ($stepKeys as $i => $key)
        @php
            $step = $stepDefinitions[$key] ?? ['label' => ucfirst($key), 'icon' => 'question-mark'];
            $description = $stepDescriptions[$type][$key] ?? '';
        @endphp
        <div class="flex flex-col items-center z-10 basis-36 flex-shrink-0 text-center px-2">
            {{-- Icon Container --}}
            <div
                class="rounded-full w-12 h-12 flex items-center justify-center transition-all duration-300
            @if ($currentIndex >= $i) bg-emerald-600 text-white shadow-lg
            @else
                bg-gray-200 text-gray-400 @endif
            border-4 border-white">
                <x-dynamic-icon name="{{ $step['icon'] }}" class="w-6 h-6" />
            </div>

            {{-- Text --}}
            <div class="mt-3">
                <p class="text-xs font-semibold uppercase leading-tight">
                    {{ $step['label'] }}
                </p>
                <p class="mt-1 text-[11px] text-gray-500 leading-snug whitespace-normal">
                    {{ $description }}
                </p>
            </div>
        </div>

        {{-- Connector Line --}}
        @if ($i < count($stepKeys) - 1)
            <div class="flex-1 h-1 bg-{{ $currentIndex > $i ? 'emerald-400' : 'gray-200' }} relative top-6"></div>
        @endif
    @endforeach
</div>
