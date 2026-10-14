@extends('layouts.app')

@section('title', $service['name'])
@section('description', $service['summary'])

@push('schema')
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Service',
                'name' => $service['name'],
                'description' => $service['summary'],
                'serviceType' => $service['name'],
                'provider' => ['@id' => url('/').'#organization'],
                'url' => route('services.show', $service['slug']),
            ],
            [
                '@type' => 'BreadcrumbList',
                'itemListElement' => [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => route('services.index')],
                    ['@type' => 'ListItem', 'position' => 3, 'name' => $service['name']],
                ],
            ],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@endpush

@section('content')
    <x-page-hero
        :crumbs="['Services' => route('services.index'), $service['name'] => null]"
        :eyebrow="$service['index'].' / '.$service['name']"
        :title="$service['headline']"
        :lead="$service['summary']">
        <div class="actions" style="margin-top: 2.5rem">
            <a class="btn btn--primary btn--lg" href="{{ route('contact', ['service' => $service['slug']]) }}">Discuss your project <x-icon name="arrow" class="arrow" /></a>
            <a class="btn btn--lg" href="#approach">How we deliver</a>
        </div>
    </x-page-hero>

    <section class="section section--flush-top" aria-labelledby="problem-title">
        <div class="container split">
            <div class="split__aside">
                <x-eyebrow>The challenge</x-eyebrow>
                <h2 class="h2" id="problem-title">Why organisations come to us</h2>
            </div>
            <div>
                <p class="statement__text" style="font-size: var(--text-xl); max-width: none" data-reveal>{{ $service['problem'] }}</p>
                <div class="fact-grid" style="margin-top: 3rem">
                    <div data-reveal>
                        <h3 class="label">Who it is for</h3>
                        <ul class="ticks">@foreach ($service['audience'] as $item)<li>{{ $item }}</li>@endforeach</ul>
                    </div>
                    <div data-reveal style="--i: 1">
                        <h3 class="label">The value you get</h3>
                        <ul class="ticks">@foreach ($service['value'] as $item)<li>{{ $item }}</li>@endforeach</ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section theme-paper" aria-labelledby="capabilities-title">
        <div class="container split">
            <div class="split__aside">
                <x-eyebrow>What we do</x-eyebrow>
                <h2 class="h2" id="capabilities-title">Capabilities</h2>
                <p class="muted" style="margin-top: 1rem">Engagements are shaped around your situation. These are the building blocks we most often combine.</p>
            </div>
            <div>
                <ol class="challenge-list">
                    @foreach ($service['capabilities'] as $capability)
                        <li class="challenge challenge--compact" data-reveal>
                            <span class="challenge__index">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3 class="challenge__title">{{ $capability }}</h3>
                        </li>
                    @endforeach
                </ol>
                <div class="panel" style="margin-top: 3rem" data-reveal>
                    <h3 class="label label--accent" style="margin-bottom: 1.25rem">Typical deliverables</h3>
                    <ul class="ticks" style="grid-template-columns: repeat(auto-fit, minmax(14rem, 1fr)); gap: 0.85rem 2rem">
                        @foreach ($service['deliverables'] as $item)<li>{{ $item }}</li>@endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="approach" aria-labelledby="approach-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow>How we deliver</x-eyebrow>
                    <h2 class="h1" id="approach-title">A process designed to remove risk early.</h2>
                </div>
                <div>
                    <p class="lead" style="margin-bottom: 1.5rem">Every engagement follows the same disciplined path, scaled to the size of the work.</p>
                    <a class="arrow-link" href="{{ route('approach') }}">Our approach in detail <x-icon name="arrow" class="arrow" /></a>
                </div>
            </div>
            <div class="timeline" data-timeline>
                <div class="timeline__track" aria-hidden="true"><span></span></div>
                <ol class="timeline__steps">
                    @foreach ($approach as $step)
                        <li class="step" data-reveal style="--i: {{ $loop->index }}">
                            <span class="step__marker" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3 class="h4 step__name">{{ $step['name'] }}</h3>
                            <p>{{ $step['summary'] }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>

    @if ($work->isNotEmpty())
        <section class="section section--flush-top" aria-labelledby="related-work">
            <div class="container">
                <x-eyebrow>Related work</x-eyebrow>
                <h2 class="h2" id="related-work" style="margin-bottom: 3rem">{{ $service['short'] }} in practice</h2>
                <div class="work-list">
                    @foreach ($work as $project)
                        @include('partials.work-item')
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section section--flush-top" aria-labelledby="related-title">
        <div class="container">
            <div class="section-head" style="margin-bottom: 2.5rem">
                <div>
                    <x-eyebrow>Often combined with</x-eyebrow>
                    <h2 class="h2" id="related-title">Related services</h2>
                </div>
                <a class="arrow-link" href="{{ route('services.show', $next['slug']) }}">Next: {{ $next['name'] }} <x-icon name="arrow" class="arrow" /></a>
            </div>
            <div class="card-grid">
                @foreach ($related as $item)
                    <article class="card" data-reveal style="--i: {{ $loop->index }}">
                        <p class="label label--accent">{{ $item['index'] }}</p>
                        <h3 class="h4">{{ $item['name'] }}</h3>
                        <p>{{ $item['summary'] }}</p>
                        <a class="arrow-link card-link" href="{{ route('services.show', $item['slug']) }}">Learn more<span class="sr-only"> about {{ $item['name'] }}</span> <x-icon name="arrow" class="arrow" /></a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta
        :title="$service['cta']"
        body="Tell us where you are and what you need to achieve. We will reply with questions, options and an honest view of what it would take."
        :service="$service['slug']" />
@endsection
