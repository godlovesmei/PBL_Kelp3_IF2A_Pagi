@props([
    'type' => 'success',
    'message'
])

@php
    $colors = [
        'success' => 'green',
        'error' => 'red',
    ];
    $color = $colors[$type] ?? 'gray';
@endphp

<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 5000)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-y-2 opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak
    class="fixed bottom-6 left-1/2 transform -translate-x-1/2 z-50 bg-{{ $color }}-100 border border-{{ $color }}-300 text-{{ $color }}-900 px-6 py-4 rounded-xl shadow-lg flex items-center gap-3 max-w-sm w-full"
>
    @if ($type === 'error')
        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14M12 2a10 10 0 100 20 10 10 0 000-20z" />
        </svg>
    @else
        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M5 13l4 4L19 7" />
        </svg>
    @endif
    <span class="text-sm font-semibold">{{ $message }}</span>
</div>

