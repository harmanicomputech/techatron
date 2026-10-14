@extends('layouts.app')

@section('title', 'How we deliver')
@section('description', 'How Techatron Consulting takes a project from first conversation to dependable, supported product: discovery, architecture, design, engineering, assurance and launch.')

@section('content')
    <x-page-hero
        :crumbs="['How we deliver' => null]"
        eyebrow="Our approach"
        title="A disciplined path from idea to dependable product."
        lead="Technology projects rarely fail because of code. They fail on unclear goals, hidden assumptions and decisions made too late. Our process is designed to surface those early, when they are cheapest to fix." />

    <section class="section section--flush-top" aria-label="Delivery phases">
        <div class="container">
            @foreach ($approach as $phase)
                <article class="phase" data-reveal>
                    <span class="phase__num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <div>
                        <h2 class="h2">{{ $phase['name'] }}</h2>
                        <p class="muted">{{ $phase['summary'] }}</p>
                    </div>
                    <div>
                        <h3 class="label" style="margin-bottom: 1rem">What happens</h3>
                        <ul class="ticks">@foreach ($phase['activities'] as $activity)<li>{{ $activity }}</li>@endforeach</ul>
                        <span class="step__output">{{ $phase['output'] }}</span>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section section--alt" aria-labelledby="principles-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow>Built in from the start</x-eyebrow>
                    <h2 class="h1" id="principles-title" data-split>Quality is designed, not inspected.</h2>
                </div>
                <p class="lead">These attributes shape decisions in every phase, so they never become an expensive retrofit.</p>
            </div>
            <div class="principles">
                @foreach ($principles as $principle)
                    <article class="principle spotlight" data-spotlight data-reveal style="--i: {{ $loop->index % 3 }}">
                        <x-glyph :name="$principle['name']" class="principle__glyph" />
                        <h3 class="h3">{{ $principle['name'] }}</h3>
                        <p>{{ $principle['body'] }}</p>
                        <p class="spec">{{ $principle['spec'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" aria-labelledby="engage-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow>Engagement models</x-eyebrow>
                    <h2 class="h1" id="engage-title" data-split>Ways to work together.</h2>
                </div>
                <p class="lead">Choose the shape that fits the work. Many clients start with advisory or a defined project and move to an ongoing arrangement.</p>
            </div>
            <div class="card-grid">
                @foreach ($engagements as $model)
                    <article class="card spotlight" data-spotlight data-reveal style="--i: {{ $loop->index }}">
                        <p class="label label--accent">{{ $model['fit'] }}</p>
                        <h3 class="h3">{{ $model['name'] }}</h3>
                        <p>{{ $model['body'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section--alt" aria-labelledby="next-title">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow>First steps</x-eyebrow>
                    <h2 class="h1" id="next-title" data-split>What happens when you get in touch.</h2>
                </div>
            </div>
            @include('partials.next-steps')
        </div>
    </section>

    <x-cta />
@endsection
