@props(['index' => null])
<div {{ $attributes->merge(['class' => 'eyebrow']) }}>
    @if ($index)<span class="label label--accent">{{ $index }}</span>@endif
    <span class="label">{{ $slot }}</span>
</div>
