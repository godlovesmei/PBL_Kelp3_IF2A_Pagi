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

'wrench-screwdriver' => <<<SVG
<svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2">
  <path d="M14.7 6.3L12 3.6 8.3 7.3l2.7 2.7 3.7-3.7z"/>
  <path d="M13.4 10.6l-5.4 5.4-2.1.7.7-2.1 5.4-5.4"/>
  <path d="M16 17l4 4"/>
  <path d="M20 17l-4 4"/>
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
