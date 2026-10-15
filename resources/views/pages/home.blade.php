@extends('layouts.app')

@section('description', 'Techatron is a full-service digital agency in Lagos specialising in website development, software development and mobile app development, plus brand, UI/UX design and digital campaigns.')

@push('schema')
    {{ \App\Support\Schema::script([
        '@type' => 'WebSite',
        'name' => config('site.name'),
        'url' => url('/'),
        'publisher' => ['@id' => url('/').'#organization'],
    ]) }}
@endpush

@php
    $specialties = $services->where('group', 'specialty');
@endphp

@section('content')

    {{-- Hero: headline above a live "build studio" --}}
    <section class="hero hero--studio" aria-labelledby="hero-title">
        <div class="hero__bg" aria-hidden="true">
            <div class="blob blob--1" data-parallax="0.35"></div>
            <div class="blob blob--2" data-parallax="-0.25"></div>
            <div class="hero__floor"><div class="hero__floor-grid"></div></div>
        </div>

        <div class="container hero__intro">
            <h1 class="display hero__title" id="hero-title">
                <span class="line"><span class="line__inner" data-intro="line">Turn ideas into</span></span>
                <span class="line"><span class="line__inner" data-intro="line"><span class="hero__accent">digital products</span> people love.</span></span>
            </h1>
            <p class="lead hero__lead" data-intro="fade">Techatron is a full-service digital agency. We design, engineer and launch websites, software and mobile apps, then grow them with campaigns that work.</p>
            <div class="actions hero__actions" data-intro="fade">
                <a class="btn btn--primary btn--lg" href="{{ route('contact') }}" data-magnetic><span class="btn__label">Start your project</span> <x-icon name="arrow" class="arrow" /></a>
                <a class="btn btn--lg" href="{{ route('services.index') }}" data-magnetic><span class="btn__label">Explore services</span></a>
            </div>
        </div>

        <div class="container">
            @include('partials.hero-studio')
        </div>
    </section>

    @include('partials.clients')

    {{-- Specialties --}}
    <section class="section" id="specialties" aria-labelledby="specialty-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow data-reveal>Our specialty</x-eyebrow>
                    <h2 class="h1" id="specialty-title" data-split>Three things we do exceptionally well.</h2>
                </div>
                <p class="lead" data-reveal>A full digital agency built around engineering. Websites, software and mobile apps are where we go deepest, and everything else we do helps them succeed.</p>
            </div>

            <div class="specialties">
                @foreach ($specialties as $item)
                    <article class="spec-card spotlight" data-tilt data-reveal data-cursor="View">
                        <span class="spec-card__num">{{ $item['index'] }}</span>
                        <div class="spec-card__art" aria-hidden="true">
                            <div class="dot-bg"></div>
                            @if ($item['slug'] === 'website-development')
                                <div class="art-web">
                                    <div class="bar"><i></i><i></i><i></i></div>
                                    <div class="hero-block"></div>
                                    <span class="sk" style="width: 70%"></span>
                                    <span class="sk sk--soft" style="width: 50%"></span>
                                    <div class="row"><i></i><i></i><i></i></div>
                                    <span class="cursor-dot"></span>
                                </div>
                            @elseif ($item['slug'] === 'software-development')
                                <div class="art-soft">
                                    <div class="side"><i></i><i></i><i></i><i></i><i></i></div>
                                    <div class="main">
                                        <div class="stats"><i></i><i></i><i></i></div>
                                        <svg viewBox="0 0 200 70" preserveAspectRatio="none">
                                            <path class="area" d="M0 60 C25 55 35 40 60 42 S95 20 120 26 S165 8 200 10 L200 70 L0 70Z"/>
                                            <path d="M0 60 C25 55 35 40 60 42 S95 20 120 26 S165 8 200 10"/>
                                        </svg>
                                        <span class="sk sk--soft" style="width: 90%"></span>
                                        <span class="sk sk--soft" style="width: 70%"></span>
                                    </div>
                                </div>
                            @else
                                <div class="art-mobile"><div class="screen"><div class="card"></div><div class="row"></div><div class="row"></div><div class="row"></div></div></div>
                                <span class="art-mobile-bubble art-mobile-bubble--1">iOS</span>
                                <span class="art-mobile-bubble art-mobile-bubble--2">Android</span>
                            @endif
                        </div>
                        <div class="spec-card__body">
                            <h3 class="h3">{{ $item['name'] }}</h3>
                            <p>{{ $item['summary'] }}</p>
                            <ul class="chips">
                                @foreach (array_slice($item['capabilities'], 0, 4) as $cap)<li>{{ $cap }}</li>@endforeach
                            </ul>
                            <a class="arrow-link card-link" href="{{ route('services.show', $item['slug']) }}">Explore {{ \Illuminate\Support\Str::lower($item['short']) }} <x-icon name="arrow" class="arrow" /></a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Statement --}}
    <section class="section section--tight statement" aria-label="What we stand for">
        <div class="container">
            <p class="statement__text" data-scrub>Strategy, design, engineering and growth under one roof. <span class="hl">One team</span> that takes your idea from first sketch to a product people love, and then helps the world find it.</p>
        </div>
    </section>

    {{-- All services, horizontal --}}
    <section class="section section--alt h-scroll" aria-labelledby="services-title" data-hscroll>
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow data-reveal>Full-service</x-eyebrow>
                    <h2 class="h1" id="services-title" data-split>Everything your digital presence needs.</h2>
                </div>
                <p class="lead" data-reveal>{{ ucfirst((new NumberFormatter('en', NumberFormatter::SPELLOUT))->format($services->count())) }} services, one accountable team. Pick one, or let us bring them together into a single plan.</p>
            </div>
        </div>
        <div class="h-scroll__viewport" data-hscroll-viewport>
            <ul class="h-scroll__track" data-hscroll-track>
                @foreach ($services as $item)
                    <li class="svc-card" data-cursor="Open">
                        <div class="svc-card__top">
                            <span class="svc-card__num">{{ $item['index'] }}</span>
                            <span class="label">{{ ['specialty' => 'Specialty', 'digital' => 'Digital', 'technology' => 'Technology'][$item['group']] }}</span>
                        </div>
                        <h3 class="h3">{{ $item['name'] }}</h3>
                        <p>{{ $item['blurb'] }}</p>
                        <ul class="chips">
                            @foreach (array_slice($item['capabilities'], 0, 3) as $cap)<li>{{ $cap }}</li>@endforeach
                        </ul>
                        <a class="svc-card__go" href="{{ route('services.show', $item['slug']) }}"><x-icon name="arrow" class="arrow" /><span class="sr-only">{{ $item['name'] }}</span></a>
                    </li>
                @endforeach
                <li class="svc-card svc-card--end">
                    <h3 class="h2" style="margin: 0 0 1rem">Not sure where to start?</h3>
                    <p style="margin-bottom: 2rem">Tell us the goal. We will recommend the right mix.</p>
                    <div><a class="btn btn--primary" href="{{ route('contact') }}">Talk to us <x-icon name="arrow" class="arrow" /></a></div>
                </li>
            </ul>
        </div>
        <div class="container">
            <div class="h-scroll__hint" aria-hidden="true">
                <span class="label">Scroll</span>
                <span class="h-scroll__progress"><span data-hscroll-progress></span></span>
                <a class="arrow-link" href="{{ route('services.index') }}">All services <x-icon name="arrow" class="arrow" /></a>
            </div>
        </div>
    </section>

    {{-- Digital agency --}}
    <section class="section section--ink digital" aria-labelledby="digital-title">
        <div class="grid-bg" aria-hidden="true"></div>
        <div class="container digital__grid" style="position: relative">
            <div>
                <x-eyebrow data-reveal>Digital agency</x-eyebrow>
                <h2 class="h1" id="digital-title" data-reveal>Build it. Launch it. <span class="gradient-text">Grow it.</span></h2>
                <p class="lead" data-reveal style="margin-top: 1.5rem">A great product is only half the job. Our digital team makes sure the right people find it, trust it and keep coming back.</p>
                <ol class="lifecycle">
                    <li data-reveal>
                        <span class="ic"><x-icon name="pen" /></span>
                        <div><strong>Design</strong><p>Brand identity and interfaces that look premium and feel effortless.</p><a href="{{ route('services.show', 'brand-and-design') }}">Brand, UI &amp; UX design →</a></div>
                    </li>
                    <li data-reveal>
                        <span class="ic"><x-icon name="code" /></span>
                        <div><strong>Build</strong><p>Websites, software and mobile apps engineered to perform.</p><a href="{{ route('services.index') }}">Development services →</a></div>
                    </li>
                    <li data-reveal>
                        <span class="ic"><x-icon name="rocket" /></span>
                        <div><strong>Launch</strong><p>Landing pages, launch campaigns and app store releases, coordinated.</p></div>
                    </li>
                    <li data-reveal>
                        <span class="ic"><x-icon name="megaphone" /></span>
                        <div><strong>Grow</strong><p>SEO, social media, paid advertising and email, all measured.</p><a href="{{ route('services.show', 'digital-marketing') }}">Digital campaigns →</a></div>
                    </li>
                </ol>
            </div>

            <div class="campaign" aria-hidden="true" data-parallax="-0.08">
                <span class="campaign__badge">Campaign live</span>
                <div class="campaign__dash">
                    <div class="campaign__head"><span class="label">Campaign performance</span><span class="trend">▲ Trending up</span></div>
                    <div class="campaign__channels">
                        <span style="--c: var(--blue-400)">Search</span>
                        <span style="--c: var(--cyan-400)">Social</span>
                        <span style="--c: var(--violet-400)">Email</span>
                    </div>
                    <div class="campaign__chart">
                        <svg viewBox="0 0 400 200" preserveAspectRatio="none" data-draw>
                            <defs>
                                <linearGradient id="area" x1="0" x2="0" y1="0" y2="1">
                                    <stop offset="0" stop-color="#2F5BE8" stop-opacity="0.35"/>
                                    <stop offset="1" stop-color="#2F5BE8" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                            <g class="grid"><line x1="0" x2="400" y1="50" y2="50"/><line x1="0" x2="400" y1="100" y2="100"/><line x1="0" x2="400" y1="150" y2="150"/></g>
                            <path class="fill" d="M0 170 C40 160 70 150 110 140 S170 110 210 100 S280 60 320 50 S370 25 400 20 L400 200 L0 200Z"/>
                            <path class="line line--a" d="M0 170 C40 160 70 150 110 140 S170 110 210 100 S280 60 320 50 S370 25 400 20"/>
                            <path class="line line--b" d="M0 180 C50 175 80 165 120 160 S190 140 230 128 S300 100 340 90 S380 75 400 70"/>
                            <path class="line line--c" d="M0 188 C60 186 100 180 150 175 S230 160 280 150 S360 135 400 128"/>
                        </svg>
                    </div>
                </div>
                <div class="campaign__post">
                    <div class="who"><i></i><span class="sk" style="width: 50%"></span></div>
                    <div class="img"></div>
                    <div class="react">♥ <span class="sk sk--soft" style="width: 30%; align-self: center"></span></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Problems --}}
    <section class="section" aria-labelledby="challenges-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow data-reveal>Where we help</x-eyebrow>
                    <h2 class="h1" id="challenges-title" data-split>Recognise any of these?</h2>
                </div>
                <p class="lead" data-reveal>Clients rarely come to us asking for technology. They come with a problem that is costing them time, money or customers. These are the ones we solve most often.</p>
            </div>
            <ol class="challenge-list">
                @foreach ($challenges as $challenge)
                    @php($service = $services[$challenge['service']])
                    <li class="challenge" data-reveal>
                        <span class="challenge__index">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3 class="challenge__title">{{ $challenge['title'] }}</h3>
                        <p class="challenge__body">{{ $challenge['body'] }}</p>
                        <a class="challenge__link" href="{{ route('services.show', $service['slug']) }}">{{ $service['short'] }} <x-icon name="arrow" class="arrow" /></a>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Process --}}
    <section class="section section--alt" aria-labelledby="approach-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow data-reveal>How we deliver</x-eyebrow>
                    <h2 class="h1" id="approach-title" data-split>From first conversation to launch, and beyond.</h2>
                </div>
                <div data-reveal>
                    <p class="lead" style="margin-bottom: 1.5rem">A process built to surface risk early, when it is cheapest to deal with, and to keep you in control of scope, budget and quality throughout.</p>
                    <a class="arrow-link" href="{{ route('approach') }}">Our approach in detail <x-icon name="arrow" class="arrow" /></a>
                </div>
            </div>
            <ol class="process-stack" data-stack>
                @foreach ($approach as $step)
                    <li class="stack-card" style="--i: {{ $loop->index }}">
                        <span class="stack-card__num" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <div>
                            <h3 class="h2">{{ $step['name'] }}</h3>
                            <p>{{ $step['summary'] }}</p>
                            <span class="step__output">{{ $step['output'] }}</span>
                        </div>
                        <ul class="ticks">@foreach ($step['activities'] as $a)<li>{{ $a }}</li>@endforeach</ul>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Engineering --}}
    <section class="section" aria-labelledby="engineering-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow data-reveal>Engineering standards</x-eyebrow>
                    <h2 class="h1" id="engineering-title" data-split>Beautiful on the surface. Solid underneath.</h2>
                </div>
                <p class="lead" data-reveal>Most software costs more to run and change than it did to build. We design for that from the first conversation, around six qualities that decide whether a product keeps earning its keep.</p>
            </div>
            <div class="principles">
                @foreach ($principles as $principle)
                    <article class="principle spotlight" data-reveal data-spotlight>
                        <x-glyph :name="$principle['name']" class="principle__glyph" />
                        <h3 class="h3">{{ $principle['name'] }}</h3>
                        <p>{{ $principle['body'] }}</p>
                        <p class="spec">{{ $principle['spec'] }}</p>
                    </article>
                @endforeach
            </div>
            @if ($platforms->isNotEmpty())
                <div class="platforms" data-reveal>
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
                        <x-eyebrow>Selected work</x-eyebrow>
                        <h2 class="h1" id="work-title" data-split>Evidence, not adjectives.</h2>
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
    <section class="section section--alt" aria-labelledby="next-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow data-reveal>Working with us</x-eyebrow>
                    <h2 class="h1" id="next-title" data-split>What happens when you get in touch.</h2>
                </div>
                <p class="lead" data-reveal>No sales funnel and no obligation. A straightforward process to find out whether we are the right team for your project.</p>
            </div>
            @include('partials.next-steps')
        </div>
    </section>

    <x-cta />

@endsection
