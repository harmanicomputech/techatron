@extends('layouts.app')

@section('title', 'About')
@section('description', 'Techatron Consulting Limited is a software engineering and technology consulting company in Lagos, Nigeria, helping organisations design, build and run the technology they depend on.')

@section('content')
    <x-page-hero
        :crumbs="['About' => null]"
        eyebrow="About Techatron"
        title="A technology partner that thinks like an engineer and acts like a stakeholder." />

    <section class="section section--flush-top" aria-labelledby="who-title">
        <div class="container split">
            <div class="split__aside">
                <x-eyebrow>Who we are</x-eyebrow>
                <h2 class="h2" id="who-title">Technology that earns its place in the business.</h2>
            </div>
            <div class="prose" style="max-width: none">
                <p class="lead" style="color: var(--fg)">{{ config('site.legal_name') }} is a software engineering and technology consulting company{{ config('site.contact.city') ? ' based in '.config('site.contact.city').', '.config('site.contact.country') : '' }}. We help organisations design, build and run the technology they depend on.</p>
                <p>Our work spans custom software and mobile applications, the cloud infrastructure they run on, the integrations that connect them, and the day-to-day IT and security that keep everything working. Clients come to us for one of those disciplines; they stay because one team understands how all of it fits together.</p>
                <p>We measure our work by what it changes for the business: processes that run reliably, customers who are better served, and systems that remain affordable to operate and extend. That is why we spend as much time on understanding the problem, and on what happens after launch, as we do on writing code.</p>
            </div>
        </div>
    </section>

    <section class="section theme-paper" aria-labelledby="believe-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow>What we believe</x-eyebrow>
                    <h2 class="h1" id="believe-title">Four convictions behind every project.</h2>
                </div>
            </div>
            <ul class="commitments" style="margin-top: 0">
                <li data-reveal><p class="label label--accent">01</p><strong>Clarity beats complexity</strong><p>The simplest system that reliably meets the need is almost always the right one.</p></li>
                <li data-reveal style="--i: 1"><p class="label label--accent">02</p><strong>Honesty saves money</strong><p>We say early when something is risky, unnecessary or better bought than built.</p></li>
                <li data-reveal style="--i: 2"><p class="label label--accent">03</p><strong>Quality is a habit</strong><p>Reviews, tests and documentation are part of every change, not a phase at the end.</p></li>
                <li data-reveal style="--i: 3"><p class="label label--accent">04</p><strong>Launch is the beginning</strong><p>Software creates value in use, so we plan for operating and improving it from day one.</p></li>
            </ul>
        </div>
    </section>

    <section class="section" aria-labelledby="standards-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow>Engineering standards</x-eyebrow>
                    <h2 class="h1" id="standards-title">What we design for.</h2>
                </div>
                <p class="lead">Six qualities we consider from the first conversation, whatever the size of the project.</p>
            </div>
            <div class="principles">
                @foreach ($principles as $principle)
                    <article class="principle" data-reveal style="--i: {{ $loop->index % 3 }}">
                        <x-glyph :name="$principle['name']" class="principle__glyph" />
                        <h3 class="h3">{{ $principle['name'] }}</h3>
                        <p>{{ $principle['body'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section--flush-top" aria-labelledby="engage-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow>Working together</x-eyebrow>
                    <h2 class="h2" id="engage-title">Ways to engage</h2>
                </div>
                <a class="arrow-link" href="{{ route('approach') }}">How we deliver <x-icon name="arrow" class="arrow" /></a>
            </div>
            <div class="card-grid">
                @foreach ($engagements as $model)
                    <article class="card" data-reveal style="--i: {{ $loop->index }}">
                        <p class="label label--accent">{{ $model['fit'] }}</p>
                        <h3 class="h4">{{ $model['name'] }}</h3>
                        <p>{{ $model['body'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section theme-paper section--tight" aria-labelledby="services-title">
        <div class="container split">
            <div class="split__aside">
                <x-eyebrow>Services</x-eyebrow>
                <h2 class="h2" id="services-title">What we do</h2>
            </div>
            <ol class="challenge-list">
                @foreach ($services as $service)
                    <li class="challenge challenge--compact" data-reveal>
                        <span class="challenge__index">{{ $service['index'] }}</span>
                        <h3 class="challenge__title">{{ $service['name'] }}</h3>
                        <a class="challenge__link" href="{{ route('services.show', $service['slug']) }}"><span class="sr-only">{{ $service['name'] }}</span><x-icon name="arrow" class="arrow" /></a>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <x-cta />
@endsection
