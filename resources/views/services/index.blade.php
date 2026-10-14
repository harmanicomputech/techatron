@extends('layouts.app')

@section('title', 'Services')
@section('description', 'Website development, software development and mobile app development, plus brand and UI/UX design, digital campaigns, cloud, integration, managed IT, cybersecurity and consulting.')

@php
    $groups = [
        'specialty' => ['Our specialty', 'Websites, software and mobile apps: where we go deepest.'],
        'digital' => ['Digital agency', 'The design and marketing that make products succeed.'],
        'technology' => ['Technology', 'The infrastructure, security and advice behind it all.'],
    ];
@endphp

@section('content')
    <x-page-hero
        :crumbs="['Services' => null]"
        eyebrow="Services"
        title="Everything your digital presence needs, under one roof."
        lead="A full-service digital agency with deep engineering roots. Whether you need a new website, a custom platform, a mobile app or the campaign to launch it, one team takes responsibility from start to finish." />

    <section class="section section--flush-top" aria-label="All services">
        <div class="container">
            @foreach ($groups as $key => [$heading, $intro])
                <div class="service-group">
                    <div class="service-group__head" data-reveal>
                        <h2 class="label label--accent">{{ $heading }}</h2>
                        <p class="dim" style="font-size: var(--text-sm)">{{ $intro }}</p>
                    </div>
                    <ol class="service-rows">
                        @foreach ($services->where('group', $key) as $service)
                            <li class="service-row" data-reveal data-cursor="Open">
                                <span class="service-row__index">{{ $service['index'] }}</span>
                                <div>
                                    <h3 class="h3">{{ $service['name'] }}</h3>
                                    <p class="service-row__summary">{{ $service['summary'] }}</p>
                                </div>
                                <div>
                                    <p class="label" style="margin-bottom: 0.9rem">Capabilities</p>
                                    <ul class="chips">
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
            @endforeach
        </div>
    </section>

    <section class="section section--alt" aria-labelledby="by-problem">
        <div class="container">
            <div class="section-head">
                <div>
                    <x-eyebrow data-reveal>Start with the problem</x-eyebrow>
                    <h2 class="h1" id="by-problem" data-split>Not sure which service you need?</h2>
                </div>
                <p class="lead" data-reveal>Most projects touch more than one discipline. Find the problem that sounds familiar, or simply describe it to us.</p>
            </div>
            <div class="card-grid">
                @foreach ($challenges as $challenge)
                    <article class="card spotlight" data-reveal data-spotlight>
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
