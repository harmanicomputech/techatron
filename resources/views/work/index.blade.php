@extends('layouts.app')

@section('title', 'Work')
@section('description', 'Case studies of software, mobile and infrastructure projects delivered by Techatron Consulting.')
@if ($work->isEmpty())
    @section('robots', 'noindex, follow')
@endif

@section('content')
    <x-page-hero
        :crumbs="['Work' => null]"
        eyebrow="Our work"
        title="Projects told as stories, not screenshots."
        lead="Each case study explains the business problem, the decisions we made and what changed as a result." />

    <section class="section section--flush-top" aria-label="Case studies">
        <div class="container">
            @if ($work->isEmpty())
                <div class="empty-state">
                    <div class="grid-bg" aria-hidden="true"></div>
                    <div style="position: relative">
                        <x-eyebrow>In preparation</x-eyebrow>
                        <h2 class="h2">Detailed case studies are being prepared for publication.</h2>
                        <p class="lead">Much of our work sits inside clients’ internal operations, so we publish only with their permission. If you would like to see work relevant to your project, ask us and we will share what we can.</p>
                        <a class="btn btn--primary" href="{{ route('contact') }}">Ask about relevant work <x-icon name="arrow" class="arrow" /></a>
                    </div>
                </div>
            @else
                <div class="work-list">
                    @foreach ($work as $project)
                        @include('partials.work-item')
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <x-cta />
@endsection
