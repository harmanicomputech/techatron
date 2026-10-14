@props(['title', 'lead' => null, 'eyebrow' => null, 'crumbs' => []])
<section class="page-hero">
    <div class="grid-bg" aria-hidden="true"></div>
    <div class="container">
        @if ($crumbs)
            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    @foreach ($crumbs as $label => $url)
                        <li>@if ($url)<a href="{{ $url }}">{{ $label }}</a>@else<span aria-current="page">{{ $label }}</span>@endif</li>
                    @endforeach
                </ol>
            </nav>
        @endif
        @if ($eyebrow)<x-eyebrow>{{ $eyebrow }}</x-eyebrow>@endif
        <h1 class="h1">{{ $title }}</h1>
        @if ($lead)<p class="lead">{{ $lead }}</p>@endif
        {{ $slot }}
    </div>
</section>
