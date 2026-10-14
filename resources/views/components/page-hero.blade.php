@props(['title', 'lead' => null, 'eyebrow' => null, 'crumbs' => []])
<section class="page-hero">
    <div class="hero__bg" aria-hidden="true">
        <div class="blob blob--1" data-parallax="0.3"></div>
        <div class="blob blob--2" data-parallax="-0.2"></div>
        <div class="grid-bg"></div>
    </div>
    <div class="page-hero__orb orb" aria-hidden="true" data-parallax="0.15">@include('partials.orb')</div>
    <div class="container">
        @if ($crumbs)
            <nav aria-label="Breadcrumb" data-reveal>
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    @foreach ($crumbs as $label => $url)
                        <li>@if ($url)<a href="{{ $url }}">{{ $label }}</a>@else<span aria-current="page">{{ $label }}</span>@endif</li>
                    @endforeach
                </ol>
            </nav>
        @endif
        @if ($eyebrow)<x-eyebrow data-reveal>{{ $eyebrow }}</x-eyebrow>@endif
        <h1 class="h1" data-split>{{ $title }}</h1>
        @if ($lead)<p class="lead" data-reveal>{{ $lead }}</p>@endif
        {{ $slot }}
    </div>
</section>
