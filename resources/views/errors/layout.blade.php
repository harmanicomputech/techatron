@extends('layouts.app')

@section('robots', 'noindex')

@section('content')
    <section class="error-page">
        <div class="container">
            <p class="code" aria-hidden="true">@yield('code')</p>
            <h1 class="h1" style="margin: 1rem 0 1.25rem">@yield('heading')</h1>
            <p class="lead" style="margin-bottom: 2.5rem">@yield('message')</p>
            <div class="actions">
                <a class="btn btn--primary" href="{{ route('home') }}">Go to the homepage <x-icon name="arrow" class="arrow" /></a>
                <a class="btn" href="{{ route('contact') }}">Contact us</a>
            </div>
        </div>
    </section>
@endsection
