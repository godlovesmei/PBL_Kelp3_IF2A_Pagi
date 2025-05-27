@props([
    'as' => 'button',    // tag HTML yang dipakai: 'button' atau 'a'
    'type' => 'button',  // hanya untuk button
    'color' => 'black',  // pilihan warna: black, red, blue, gray
    'href' => null,      // atribut href untuk <a>
])

@php
$colors = [
    'black' => 'bg-black text-white hover:bg-gray-800',
    'red' => 'bg-red-600 text-white hover:bg-red-700',
    'blue' => 'bg-blue-600 text-white hover:bg-blue-700',
    'gray' => 'bg-gray-300 text-black hover:bg-gray-400',
];

$colorClasses = $colors[$color] ?? $colors['black'];

$classes = "px-6 py-2 rounded-full text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 {$colorClasses}";
@endphp

@if($as === 'a')
    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $classes]) }}
    >
        {{ $slot }}
    </button>
@endif
