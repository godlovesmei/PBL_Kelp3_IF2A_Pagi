@props(['total', 'method'])

<div class="bg-white rounded-xl shadow p-4 flex flex-col gap-2 border border-stone-200">
    <div class="flex items-center gap-2">
        <span class="text-gray-500 text-sm">Total</span>
        <span class="ml-auto text-emerald-700 font-bold text-lg">
            Rp {{ number_format($total ?? 0, 0, ',', '.') }}
        </span>
    </div>
    <div class="flex items-center gap-2">
        <span class="text-gray-500 text-sm">Payment Method</span>
        <span class="ml-auto capitalize text-gray-700 font-medium">{{ $method ?? '-' }}</span>
    </div>
</div>
