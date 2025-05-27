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
    x-show="show"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
>
    <div class="bg-white rounded-lg shadow-lg border-l-4 border-{{ $color }}-500 max-w-sm w-full p-6">
        <div class="flex items-start">
            <div class="mr-3">
                @if ($type === 'error')
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14M12 2a10 10 0 100 20 10 10 0 000-20z" />
                    </svg>
                @else
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5 13l4 4L19 7" />
                    </svg>
                @endif
            </div>
            <div class="flex-1 text-sm text-gray-700">
                {{ $message }}
            </div>
            <button @click="show = false" class="ml-4 text-gray-500 hover:text-gray-700 text-lg font-bold">&times;</button>
        </div>
    </div>
</div>
