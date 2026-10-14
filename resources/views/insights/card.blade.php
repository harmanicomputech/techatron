<article class="card" data-reveal>
    <p class="label"><span class="accent">{{ $article['topic'] ?? 'Insight' }}</span> · <time datetime="{{ $article['date']->toDateString() }}">{{ $article['date']->format('j M Y') }}</time></p>
    <h3 class="h4">{{ $article['title'] }}</h3>
    <p>{{ $article['summary'] }}</p>
    <a class="arrow-link card-link" href="{{ route('insights.show', $article['slug']) }}">Read<span class="sr-only"> {{ $article['title'] }}</span> <x-icon name="arrow" class="arrow" /></a>
</article>
