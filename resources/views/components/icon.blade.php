@props(['name'])
@php
    $paths = [
        'arrow' => '<path d="M3 8h10M9 4l4 4-4 4"/>',
        'arrow-up-right' => '<path d="M5 11l6-6M6 5h5v5"/>',
        'chevron' => '<path d="M4 6l4 4 4-4"/>',
        'check' => '<path d="M3.5 8.5l3 3 6-7"/>',
        'mail' => '<rect x="2" y="3.5" width="12" height="9" rx="1.5"/><path d="M2.5 4.5L8 9l5.5-4.5"/>',
        'phone' => '<path d="M5.5 2.5h-2a1 1 0 00-1 1C2.5 9 7 13.5 12.5 13.5a1 1 0 001-1v-2l-2.5-1-1.2 1.2a7 7 0 01-3.5-3.5L7.5 6 6.5 3.5z"/>',
        'pin' => '<path d="M8 14s4.5-4.2 4.5-7.5a4.5 4.5 0 10-9 0C3.5 9.8 8 14 8 14z"/><circle cx="8" cy="6.5" r="1.5"/>',
    ];
@endphp
<svg {{ $attributes->merge(['class' => 'icon', 'viewBox' => '0 0 16 16', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '1.5', 'stroke-linecap' => 'round', 'stroke-linejoin' => 'round', 'aria-hidden' => 'true', 'focusable' => 'false']) }}>{!! $paths[$name] ?? '' !!}</svg>
