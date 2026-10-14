@extends('layouts.app')

@section('title', 'Insights')
@section('description', 'Practical writing on software engineering, product thinking and technology decisions from the Techatron Consulting team.')

@section('content')
    <x-page-hero :crumbs="['Insights' => null]" eyebrow="Insights" title="Notes from the work."
        lead="Practical perspectives on building, buying and running technology, written by the people who do it." />
    <section class="section section--flush-top">
        <div class="container card-grid">
            @foreach ($insights as $article)
                @include('insights.card')
            @endforeach
        </div>
    </section>
    <x-cta />
@endsection
