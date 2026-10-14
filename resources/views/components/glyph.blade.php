@props(['name'])
@php
    $glyphs = [
        'Reliability' => '<circle cx="18" cy="18" r="12"/><path d="M6 18h6l3-6 4 12 3-6h8"/>',
        'Security' => '<path d="M18 5l11 4v8c0 7-5 12-11 14C12 29 7 24 7 17V9z"/><path d="M13 18l3.5 3.5L23 15"/>',
        'Performance' => '<path d="M6 26a12 12 0 1124 0"/><path d="M18 26l6-9"/><circle cx="18" cy="26" r="1.5"/>',
        'Maintainability' => '<path d="M12 10l-6 8 6 8M24 10l6 8-6 8M20 7l-4 22"/>',
        'Scalability' => '<rect x="5" y="22" width="8" height="8" rx="1.5"/><rect x="14" y="14" width="8" height="16" rx="1.5"/><rect x="23" y="6" width="8" height="24" rx="1.5"/>',
        'Integration' => '<circle cx="9" cy="18" r="4"/><circle cx="27" cy="9" r="4"/><circle cx="27" cy="27" r="4"/><path d="M13 16.5l10-6M13 19.5l10 6"/>',
    ];
@endphp
<svg {{ $attributes->merge(['viewBox' => '0 0 36 36', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '1.5', 'stroke-linecap' => 'round', 'stroke-linejoin' => 'round', 'aria-hidden' => 'true', 'focusable' => 'false']) }}>{!! $glyphs[$name] ?? '' !!}</svg>
