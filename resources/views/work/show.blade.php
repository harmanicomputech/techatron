@extends('layouts.app')

@section('title', $project['client'].' case study')
@section('description', $project['summary'])
@section('og_type', 'article')

@section('content')
    <x-page-hero
        :crumbs="['Work' => route('work.index'), $project['client'] => null]"
        :eyebrow="collect([$project['client'], $project['sector'] ?? null, $project['year'] ?? null])->filter()->implode(' · ')"
        :title="$project['title']"
        :lead="$project['summary']">
        @if (($project['type'] ?? 'client') === 'concept')
            <p><span class="badge">Concept work, not a client engagement</span></p>
        @endif
    </x-page-hero>

    @if (! empty($project['image']))
        <section class="section section--flush-top" aria-label="Project preview">
            <div class="container">
                <div class="work-item__media" style="aspect-ratio: 16 / 9">
                    <img src="{{ asset($project['image']) }}" alt="{{ $project['image_alt'] ?? $project['client'].' interface' }}" width="1600" height="900" decoding="async">
                </div>
            </div>
        </section>
    @endif

    <section class="section section--flush-top">
        <div class="container split">
            <aside class="split__aside">
                <div class="fact-grid" style="grid-template-columns: 1fr">
                    @if ($services->isNotEmpty())
                        <div><h2 class="label" style="margin-bottom: 0.75rem">Services</h2>
                            <ul class="ticks">@foreach ($services as $s)<li><a class="text-link" href="{{ route('services.show', $s['slug']) }}">{{ $s['short'] }}</a></li>@endforeach</ul></div>
                    @endif
                    @if (! empty($project['capabilities']))
                        <div><h2 class="label" style="margin-bottom: 0.75rem">Capabilities</h2>
                            <ul class="ticks">@foreach ($project['capabilities'] as $c)<li>{{ $c }}</li>@endforeach</ul></div>
                    @endif
                    @if (! empty($project['stack']))
                        <div><h2 class="label" style="margin-bottom: 0.75rem">Technology</h2>
                            <ul class="service-row__tags">@foreach ($project['stack'] as $t)<li>{{ $t }}</li>@endforeach</ul></div>
                    @endif
                    @if (! empty($project['url']))
                        <div><a class="arrow-link" href="{{ $project['url'] }}" rel="noopener" target="_blank">Visit the live product <x-icon name="arrow-up-right" class="arrow" /><span class="sr-only"> (opens in a new tab)</span></a></div>
                    @endif
                </div>
            </aside>
            <div class="prose" style="max-width: none">
                @foreach (['context' => 'Context', 'challenge' => 'The challenge', 'solution' => 'What we built'] as $key => $heading)
                    @if (! empty($project[$key]))
                        <h2>{{ $heading }}</h2>
                        <p>{{ $project[$key] }}</p>
                    @endif
                @endforeach
                @if (! empty($project['outcomes']))
                    <h2>Outcomes</h2>
                    <ul>@foreach ($project['outcomes'] as $o)<li>{{ $o }}</li>@endforeach</ul>
                @endif
            </div>
        </div>
    </section>

    @if ($more->isNotEmpty())
        <section class="section section--flush-top" aria-labelledby="more-title">
            <div class="container">
                <h2 class="h2" id="more-title" style="margin-bottom: 3rem">More work</h2>
                <div class="work-list">
                    @foreach ($more as $project)
                        @include('partials.work-item')
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-cta />
@endsection
