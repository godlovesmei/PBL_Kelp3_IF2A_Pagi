@props([
    'current' => '',
    'type' => 'cash', // 'cash' or 'credit'
])

@php
    $stepDefinitions = [
        'pending' => ['label' => 'Order Placed', 'icon' => 'shopping-cart'],
        'confirm' => ['label' => 'Confirmed', 'icon' => 'badge-check'],
        'payment' => ['label' => 'Paid in Full', 'icon' => 'credit-card'],
        'leasing_review' => ['label' => 'Leasing Review', 'icon' => 'document-check'],
        'dp_paid' => ['label' => 'DP Paid', 'icon' => 'credit-card'],
        'contract_ready' => ['label' => 'Contract Ready', 'icon' => 'clipboard-document-check'],
        'leasing_finalized' => ['label' => 'Leasing Finalized', 'icon' => 'clipboard-document-check'],
        'processing' => ['label' => 'Vehicle Inspection', 'icon' => 'wrench-screwdriver'],
        'shipped' => ['label' => 'On Delivery', 'icon' => 'truck'],
        'completed' => ['label' => 'Completed', 'icon' => 'star'],
    ];

    $stepDescriptions = [
        'cash' => [
            'pending' => 'Awaiting confirmation from the dealer.',
            'confirm' => 'Your order is confirmed. Please proceed with the payment.',
            'payment' => 'Payment received. We are verifying your transaction.',
            'processing' => 'Your vehicle is undergoing inspection.',
            'shipped' => 'Your vehicle is on its way to your address.',
            'completed' => 'Transaction completed. Thank you for your purchase!',
        ],
        'credit' => [
            'pending' => 'Awaiting confirmation from the dealer.',
            'confirm' => 'Our sales team will assist you with the credit application.',
            'leasing_finalized' =>
                'Credit approved and down payment received. Preparing your vehicle for final inspection.',
            'processing' => 'Your vehicle is undergoing inspection.',
            'shipped' => 'Your vehicle is on its way to your address.',
            'completed' => 'Delivery completed. Thank you for choosing us!',
        ],
    ];

    $stepsByType = [
        'cash' => ['pending', 'confirm', 'payment', 'processing', 'shipped', 'completed'],
        'credit' => ['pending', 'confirm', 'leasing_finalized', 'processing', 'shipped', 'completed'],
    ];

    $stepKeys = $stepsByType[$type] ?? [];
    $currentIndex = array_search($current, $stepKeys);
@endphp

<div class="relative w-full max-w-6xl mx-auto px-2 py-8">
    {{-- Progress Bar Background --}}
    <div
        class="absolute top-11 left-0 right-0 h-1 bg-gray-200 dark:bg-gray-700 z-0 rounded-full overflow-hidden mx-2 md:mx-[5%]">
        <div class="h-full bg-emerald-500 transition-all duration-700 ease-in-out"
            style="width: {{ (100 * $currentIndex) / (count($stepKeys) - 1) }}%;"></div>
    </div>

    {{-- Step Items --}}
    <div class="relative z-10 overflow-x-auto scrollbar-hide md:overflow-visible">
        <div class="flex flex-nowrap md:flex-wrap justify-between items-start gap-y-8 gap-x-4 min-w-[520px] md:min-w-0">
            @foreach ($stepKeys as $i => $key)
                @php
                    $step = $stepDefinitions[$key] ?? ['label' => ucfirst($key), 'icon' => 'question-mark'];
                    $description = $stepDescriptions[$type][$key] ?? '';
                    $isActive = $currentIndex >= $i;
                    $isCurrent = $currentIndex === $i;
                @endphp

                <div
                    class="flex flex-col items-center min-w-[80px] flex-1 text-center relative group transition-all duration-300 ease-in-out">
                    <div class="relative z-10">
                        <div
                            class="w-12 h-12 flex items-center justify-center rounded-full border-4 border-white dark:border-gray-800 shadow
                            transition-all duration-500 ease-in-out
                            {{ $isActive ? 'bg-emerald-600 text-white scale-105 shadow-lg' : 'bg-gray-200 text-gray-400 dark:bg-gray-700 dark:text-gray-500' }}">
                            <x-dynamic-icon name="{{ $step['icon'] }}" class="w-6 h-6" />
                        </div>
                        @if ($isCurrent)
                            <span class="absolute inset-0 rounded-full animate-ping bg-emerald-300 opacity-50"></span>
                        @endif
                    </div>
                    <div class="mt-3 px-1 text-center">
                        <p class="text-sm font-semibold tracking-wide text-gray-800 dark:text-gray-100">
                            {{ $step['label'] }}
                        </p>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 leading-tight max-w-[120px]">
                            {{ $description }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
