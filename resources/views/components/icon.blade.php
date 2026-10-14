@props(['name'])
@php
    $paths = [
        'arrow' => '<path d="M3 8h10M9 4l4 4-4 4"/>',
        'arrow-up-right' => '<path d="M5 11l6-6M6 5h5v5"/>',
        'chevron' => '<path d="M4 6l4 4 4-4"/>',
        'check' => '<path d="M3.5 8.5l3 3 6-7"/>',
        'mail' => '<rect x="2" y="3.5" width="12" height="9" rx="1.5"/><path d="M2.5 4.5L8 9l5.5-4.5"/>',
        'phone' => '<path d="M5.5 2.5h-2a1 1 0 00-1 1C2.5 9 7 13.5 12.5 13.5a1 1 0 001-1v-2l-2.5-1-1.2 1.2a7 7 0 01-3.5-3.5L7.5 6 6.5 3.5z"/>',
        'sun' => '<circle cx="8" cy="8" r="3"/><path d="M8 1.5v1.5M8 13v1.5M1.5 8H3M13 8h1.5M3.4 3.4l1 1M11.6 11.6l1 1M3.4 12.6l1-1M11.6 4.4l1-1"/>',
        'moon' => '<path d="M13.5 9.5A5.5 5.5 0 016.5 2.5a5.5 5.5 0 107 7z"/>',
        'lock' => '<rect x="3.5" y="7" width="9" height="6.5" rx="1.5"/><path d="M5.5 7V5a2.5 2.5 0 015 0v2"/>',
        'globe' => '<circle cx="8" cy="8" r="6"/><path d="M2 8h12M8 2c1.8 1.7 2.6 3.7 2.6 6S9.8 12.3 8 14C6.2 12.3 5.4 10.3 5.4 8S6.2 3.7 8 2z"/>',
        'code' => '<path d="M5.5 4.5L2 8l3.5 3.5M10.5 4.5L14 8l-3.5 3.5M9 3l-2 10"/>',
        'mobile' => '<rect x="4.5" y="1.5" width="7" height="13" rx="1.5"/><path d="M7 12.5h2"/>',
        'pen' => '<path d="M10.5 2.5l3 3L6 13H3v-3z"/><path d="M9 4l3 3"/>',
        'megaphone' => '<path d="M2.5 6.5v3h2l5 3v-9l-5 3z"/><path d="M12 5.5a3 3 0 010 5"/>',
        'rocket' => '<path d="M9.5 2.5c2.5 0 4 1.5 4 4L9 11 5 7z"/><path d="M5 7L2.5 7.5 4 5.5h3M9 11l-.5 2.5L10.5 12V9M4.5 11.5L3 13"/>',
        'chart' => '<path d="M2.5 13.5h11M4.5 11V8M8 11V4.5M11.5 11V6.5"/>',
        'pin' => '<path d="M8 14s4.5-4.2 4.5-7.5a4.5 4.5 0 10-9 0C3.5 9.8 8 14 8 14z"/><circle cx="8" cy="6.5" r="1.5"/>',
    ];
@endphp
<svg {{ $attributes->merge(['class' => 'icon', 'viewBox' => '0 0 16 16', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '1.5', 'stroke-linecap' => 'round', 'stroke-linejoin' => 'round', 'aria-hidden' => 'true', 'focusable' => 'false']) }}>{!! $paths[$name] ?? '' !!}</svg>
