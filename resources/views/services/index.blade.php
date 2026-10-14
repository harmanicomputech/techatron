@extends('layouts.app')

@section('title', 'Services')
@section('description', 'Custom software, mobile apps, cloud infrastructure, systems integration, managed IT, cybersecurity and technology consulting from Techatron Consulting.')

@section('content')
    <x-page-hero
        :crumbs="['Services' => null]"
        eyebrow="Services"
        title="Engineering and advice for every stage of your technology."
        lead="Whether you need a new product built, existing systems connected, infrastructure made dependable or a second opinion before you commit budget, the same team takes responsibility from start to finish." />

    <section class="section section--flush-top" aria-label="All services">
        <div class="container">
            <ol class="service-rows">
                @foreach ($services as $service)
                    <li class="service-row" data-reveal>
                        <span class="service-row__index">{{ $service['index'] }}</span>
                        <div>
                            <h2 class="h3">{{ $service['name'] }}</h2>
                            <p class="service-row__summary">{{ $service['summary'] }}</p>
                        </div>
                        <div>
                            <p class="label" style="margin-bottom: 0.9rem">Capabilities</p>
                            <ul class="service-row__tags">
                                @foreach ($service['capabilities'] as $capability)<li>{{ $capability }}</li>@endforeach
                            </ul>
                        </div>
                        <a class="service-row__go" href="{{ route('services.show', $service['slug']) }}">
                            <x-icon name="arrow" class="arrow" /><span class="sr-only">{{ $service['name'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="section theme-paper" aria-labelledby="by-problem">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow>Start with the problem</x-eyebrow>
                    <h2 class="h1" id="by-problem">Not sure which service you need?</h2>
                </div>
                <p class="lead">Most projects touch more than one discipline. Find the problem that sounds familiar, or simply describe it to us.</p>
            </div>
            <div class="card-grid">
                @foreach ($challenges as $challenge)
                    <article class="card" data-reveal style="--i: {{ $loop->index % 3 }}">
                        <p class="label label--accent">{{ $services[$challenge['service']]['short'] }}</p>
                        <h3 class="h4">{{ $challenge['title'] }}</h3>
                        <p>{{ $challenge['body'] }}</p>
                        <a class="arrow-link card-link" href="{{ route('services.show', $challenge['service']) }}">See how we help <x-icon name="arrow" class="arrow" /></a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <x-cta />
@endsection
