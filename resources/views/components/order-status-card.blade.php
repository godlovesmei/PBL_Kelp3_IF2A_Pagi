@props(['status', 'date'])



<div class="bg-white rounded-xl shadow p-4 flex flex-col gap-2 border border-stone-200">
    <div class="text-gray-500 text-sm">Order Status</div>
    <div class="font-bold text-lg">
        <span
            class="@if ($status === 'pending') text-yellow-600
            @elseif(in_array($status, ['confirm', 'completed'])) text-green-700
            @elseif($status === 'cancelled') text-red-600
            @elseif($status === 'processing') text-blue-700
            @elseif($status === 'shipped') text-purple-700
            @else text-gray-700 @endif">
            {{ ucfirst($status ?? '-') }}
        </span>
    </div>
    <div class="text-gray-500 text-sm">Order Date</div>
    <div>{{ $date ?? '-' }}</div>
</div>
