@props(['name'])

@php
$icons = [
    'shopping-cart' => <<<SVG
<svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
  <circle cx="9" cy="21" r="1"/>
  <circle cx="20" cy="21" r="1"/>
  <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 001.98-1.75L23 6H6"/>
</svg>
SVG,

    'badge-check' => <<<SVG
<svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
  <polyline points="4 19 6 21 10 17" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M13 21h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H8L6 5v9"/>
</svg>
SVG,

    'document-check' => <<<SVG
<svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
  <path d="M9 12l2 2l4-4" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M12 21H6a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v2"/>
</svg>
SVG,

    'clipboard-document-check' => <<<SVG
<svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
  <path d="M9 12l2 2l4-4" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M16 4h2a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h2"/>
  <rect x="9" y="2" width="6" height="4" rx="1"/>
</svg>
SVG,

    'credit-card' => <<<SVG
<svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
  <rect x="2" y="5" width="20" height="14" rx="2"/>
  <path d="M2 10h20"/>
</svg>
SVG,

    'package' => <<<SVG
<svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
  <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4a2 2 0 001-1.73z"/>
  <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
  <line x1="12" y1="22.08" x2="12" y2="12"/>
</svg>
SVG,

    'truck' => <<<SVG
<svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
  <rect x="1" y="3" width="15" height="13"/>
  <path d="M16 8h5l1 2v6h-6V8z"/>
  <circle cx="7.5" cy="18.5" r="1.5"/>
  <circle cx="18.5" cy="18.5" r="1.5"/>
</svg>
SVG,

    'check-circle' => <<<SVG
<svg viewBox="0 0 24 24" class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2">
  <circle cx="12" cy="12" r="10"/>
  <path d="M9 12l2 2l4-4" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
SVG,

    'star' => <<<SVG
<svg viewBox="0 0 24 24" class="w-6 h-6 text-yellow-400" fill="currentColor" stroke="none">
  <path d="M12 .587l3.668 7.568L24 9.423l-6 5.847 1.416 8.253L12 18.897 4.584 23.523 6 15.27 0 9.423l8.332-1.268z"/>
</svg>
SVG,
];
@endphp

{!! $icons[$name] ?? '<!-- Unknown icon -->' !!}
