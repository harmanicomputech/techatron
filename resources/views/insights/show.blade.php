@extends('layouts.app')

@section('title', $article['title'])
@section('description', $article['summary'])
@section('og_type', 'article')

@push('schema')
    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => $article['title'],
        'description' => $article['summary'],
        'datePublished' => $article['date']->toDateString(),
        'author' => ['@type' => 'Person', 'name' => $article['author']],
        'publisher' => ['@id' => url('/').'#organization'],
        'mainEntityOfPage' => route('insights.show', $article['slug']),
    ], JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
@endpush

@section('content')
    <x-page-hero :crumbs="['Insights' => route('insights.index'), $article['title'] => null]"
        :eyebrow="($article['topic'] ?? 'Insight').' · '.$article['date']->format('j F Y')"
        :title="$article['title']" :lead="$article['summary']">
        <p class="label">By {{ $article['author'] }}</p>
    </x-page-hero>
    <section class="section section--flush-top">
        <div class="container">
            <article class="prose">{!! $article['body'] !!}</article>
        </div>
    </section>
    <x-cta />
@endsection
