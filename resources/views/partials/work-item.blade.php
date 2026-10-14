<article class="work-item" data-reveal>
    <a class="work-item__media" href="{{ route('work.show', $project['slug']) }}" tabindex="-1" aria-hidden="true">
        @if (! empty($project['image']))
            <img src="{{ asset($project['image']) }}" alt="" loading="lazy" decoding="async" width="1600" height="1000">
        @endif
    </a>
    <div>
        <div class="eyebrow">
            <span class="label">{{ $project['sector'] ?? '' }}{{ ! empty($project['year']) ? ' · '.$project['year'] : '' }}</span>
            @if (($project['type'] ?? 'client') === 'concept')<span class="badge">Concept</span>@endif
        </div>
        <h3 class="h2" style="margin-bottom: 1rem">{{ $project['title'] }}</h3>
        <p class="muted" style="margin-bottom: 1.5rem">{{ $project['summary'] }}</p>
        <a class="arrow-link" href="{{ route('work.show', $project['slug']) }}">{{ $project['client'] }} case study <x-icon name="arrow" class="arrow" /></a>
    </div>
</article>
