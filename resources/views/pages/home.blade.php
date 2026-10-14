@extends('layouts.app')

@section('description', 'Techatron Consulting designs, builds and supports custom software, mobile apps and cloud infrastructure for organisations that depend on technology. Based in Lagos.')

@push('schema')
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => config('site.name'),
        'url' => url('/'),
        'publisher' => ['@id' => url('/').'#organization'],
    ], JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@endpush

@section('content')

    {{-- Hero --}}
    <section class="hero" aria-labelledby="hero-title">
        <div class="grid-bg" aria-hidden="true"></div>
        <div class="container hero__grid">
            <div>
                <x-eyebrow>Software engineering &amp; technology consulting</x-eyebrow>
                <h1 class="display hero__title" id="hero-title">We engineer the software your business <em>runs&nbsp;on.</em></h1>
                <p class="lead hero__lead">Techatron Consulting designs, builds and supports custom software, mobile apps and cloud infrastructure for organisations that depend on technology to operate, grow and compete.</p>
                <div class="actions">
                    <a class="btn btn--primary btn--lg" href="{{ route('contact') }}">Discuss your project <x-icon name="arrow" class="arrow" /></a>
                    <a class="btn btn--lg" href="{{ route('approach') }}">How we deliver</a>
                </div>
                <ul class="hero__meta" aria-label="At a glance">
                    <li>Strategy to support</li>
                    <li>Web · mobile · cloud</li>
                    @if (config('site.contact.city'))<li>Based in {{ config('site.contact.city') }}</li>@endif
                </ul>
            </div>
            @include('partials.system-map')
        </div>
    </section>

    {{-- Point of view --}}
    <section class="section section--tight statement" aria-label="Our point of view">
        <div class="container">
            <p class="statement__text" data-reveal>Most technology problems are business problems in disguise. <span>We start with what your organisation needs to achieve, then engineer the simplest system that will reliably deliver it.</span></p>
            <ul class="commitments">
                <li data-reveal style="--i: 0"><p class="label label--accent">01</p><strong>Business first</strong><p>Success is defined in business terms before any technology is chosen.</p></li>
                <li data-reveal style="--i: 1"><p class="label label--accent">02</p><strong>Engineered to last</strong><p>Tested, documented code that any competent engineer can pick up and maintain.</p></li>
                <li data-reveal style="--i: 2"><p class="label label--accent">03</p><strong>Visible progress</strong><p>Working software early and often, so there are no surprises at the end.</p></li>
                <li data-reveal style="--i: 3"><p class="label label--accent">04</p><strong>Accountable after launch</strong><p>We support what we build and stay on to improve it.</p></li>
            </ul>
        </div>
    </section>

    {{-- Problems --}}
    <section class="section theme-paper" aria-labelledby="challenges-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow index="01">Where we help</x-eyebrow>
                    <h2 class="h1" id="challenges-title">Recognise any of these?</h2>
                </div>
                <p class="lead">Clients rarely come to us asking for technology. They come with a problem that is costing them time, money or customers. These are the ones we solve most often.</p>
            </div>
            <ol class="challenge-list">
                @foreach ($challenges as $challenge)
                    @php($service = $services[$challenge['service']])
                    <li class="challenge" data-reveal>
                        <span class="challenge__index">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3 class="challenge__title">{{ $challenge['title'] }}</h3>
                        <p class="challenge__body">{{ $challenge['body'] }}</p>
                        <a class="challenge__link" href="{{ route('services.show', $service['slug']) }}">
                            {{ $service['short'] }} <x-icon name="arrow" class="arrow" />
                        </a>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Services --}}
    <section class="section" aria-labelledby="services-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow index="02">What we do</x-eyebrow>
                    <h2 class="h1" id="services-title">{{ ucfirst((new NumberFormatter('en', NumberFormatter::SPELLOUT))->format($services->count())) }} disciplines. One accountable team.</h2>
                </div>
                <p class="lead">From the first strategy conversation to the support desk after launch, one team that understands your systems end to end, with no hand-offs between agencies.</p>
            </div>

            <div class="explorer" data-explorer>
                <div class="explorer__tabs" role="tablist" aria-label="Services" aria-orientation="vertical">
                    @foreach ($services as $service)
                        <button class="explorer__tab" type="button" role="tab" id="tab-{{ $service['slug'] }}"
                            aria-controls="panel-{{ $service['slug'] }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            <span class="mono">{{ $service['index'] }}</span>
                            <span>{{ $service['short'] }}</span>
                            <x-icon name="arrow" class="arrow" />
                        </button>
                    @endforeach
                </div>

                <div>
                    @foreach ($services as $service)
                        <article class="panel" id="panel-{{ $service['slug'] }}" aria-labelledby="tab-{{ $service['slug'] }}">
                            <div class="panel__head">
                                <p class="label label--accent">{{ $service['index'] }} / {{ $service['name'] }}</p>
                            </div>
                            <h3 class="h2 panel__title">{{ $service['headline'] }}</h3>
                            <p class="muted">{{ $service['summary'] }}</p>
                            <div class="problem"><strong>The problem</strong>{{ $service['problem'] }}</div>
                            <div class="panel__cols">
                                <div>
                                    <h4 class="label">Who it is for</h4>
                                    <ul class="ticks">@foreach ($service['audience'] as $item)<li>{{ $item }}</li>@endforeach</ul>
                                </div>
                                <div>
                                    <h4 class="label">What you get</h4>
                                    <ul class="ticks">@foreach ($service['value'] as $item)<li>{{ $item }}</li>@endforeach</ul>
                                </div>
                            </div>
                            <div class="panel__foot">
                                <a class="btn btn--primary" href="{{ route('services.show', $service['slug']) }}">Service details<span class="sr-only">: {{ $service['name'] }}</span> <x-icon name="arrow" class="arrow" /></a>
                                <a class="arrow-link" href="{{ route('contact', ['service' => $service['slug']]) }}">Discuss a project <x-icon name="arrow" class="arrow" /></a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Approach --}}
    <section class="section theme-paper" aria-labelledby="approach-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow index="03">How we deliver</x-eyebrow>
                    <h2 class="h1" id="approach-title">From first conversation to dependable product.</h2>
                </div>
                <div>
                    <p class="lead" style="margin-bottom: 1.5rem">A delivery process built to surface risk early, when it is cheapest to deal with, and to keep you in control of scope, budget and quality throughout.</p>
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
                        <span class="step__output">{{ $step['output'] }}</span>
                    </li>
                @endforeach
                </ol>
            </div>
        </div>
    </section>

    {{-- Engineering --}}
    <section class="section" aria-labelledby="engineering-title">
        <div class="grid-bg" aria-hidden="true"></div>
        <div class="container" style="position: relative">
            <div class="section-head">
                <div>
                    <x-eyebrow index="04">Engineering standards</x-eyebrow>
                    <h2 class="h1" id="engineering-title">Built for the day after launch.</h2>
                </div>
                <p class="lead">Most software costs more to run and change than it did to build. We design for that from the first conversation, around six qualities that decide whether a system keeps earning its keep.</p>
            </div>
            <div class="principles">
                @foreach ($principles as $principle)
                    <article class="principle" data-reveal style="--i: {{ $loop->index % 3 }}">
                        <x-glyph :name="$principle['name']" class="principle__glyph" />
                        <h3 class="h3">{{ $principle['name'] }}</h3>
                        <p>{{ $principle['body'] }}</p>
                        <p class="spec">{{ $principle['spec'] }}</p>
                    </article>
                @endforeach
            </div>
            @if ($platforms->isNotEmpty())
                <div class="platforms">
                    @foreach ($platforms as $group => $items)
                        <span class="label">{{ $group }} platforms we work with</span>
                        <ul>@foreach ($items as $item)<li class="chip">{{ $item }}</li>@endforeach</ul>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Work (only once verified case studies exist) --}}
    @if ($work->isNotEmpty())
        <section class="section section--flush-top" aria-labelledby="work-title">
            <div class="container">
                <div class="section-head">
                    <div>
                        <x-eyebrow index="05">Selected work</x-eyebrow>
                        <h2 class="h1" id="work-title">Evidence, not adjectives.</h2>
                    </div>
                    <a class="arrow-link" href="{{ route('work.index') }}">All case studies <x-icon name="arrow" class="arrow" /></a>
                </div>
                <div class="work-list">
                    @foreach ($work as $project)
                        @include('partials.work-item')
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Testimonials (only once verified quotes exist) --}}
    @if ($testimonials->isNotEmpty())
        <section class="section section--tight" aria-label="What clients say">
            <div class="container">
                @foreach ($testimonials->take(1) as $t)
                    <figure class="quote" data-reveal>
                        <blockquote><p>&ldquo;{{ $t['quote'] }}&rdquo;</p></blockquote>
                        <figcaption><strong>{{ $t['name'] }}</strong>{{ $t['role'] }}, {{ $t['organisation'] }}</figcaption>
                    </figure>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Insights (only once articles exist) --}}
    @if ($insights->isNotEmpty())
        <section class="section section--flush-top" aria-labelledby="insights-title">
            <div class="container">
                <div class="section-head">
                    <div>
                        <x-eyebrow>Insights</x-eyebrow>
                        <h2 class="h1" id="insights-title">Notes from the work.</h2>
                    </div>
                    <a class="arrow-link" href="{{ route('insights.index') }}">All insights <x-icon name="arrow" class="arrow" /></a>
                </div>
                <div class="card-grid">
                    @foreach ($insights as $article)
                        @include('insights.card')
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- What happens next --}}
    <section class="section theme-paper" aria-labelledby="next-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow>Working with us</x-eyebrow>
                    <h2 class="h1" id="next-title">What happens when you get in touch.</h2>
                </div>
                <p class="lead">No sales funnel and no obligation. A straightforward process to find out whether we are the right team for your project.</p>
            </div>
            @include('partials.next-steps')
        </div>
    </section>

    <x-cta />

@endsection
