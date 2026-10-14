@props([
    'title' => 'Let’s build something remarkable.',
    'body' => 'Tell us what you want to launch, fix or grow. We will come back with honest questions, a clear view of the options, and what it would take to deliver.',
    'service' => null,
])
<section class="section section--brand cta-final" aria-labelledby="cta-title">
    <div class="cta-final__orb orb" aria-hidden="true" data-parallax="0.2">@include('partials.orb')</div>
    <div class="container">
        <x-eyebrow data-reveal>Start a conversation</x-eyebrow>
        <h2 class="display" id="cta-title" data-split>{{ $title }}</h2>
        <p class="lead" data-reveal>{{ $body }}</p>
        <div class="actions" data-reveal>
            <a class="btn btn--primary btn--lg" href="{{ route('contact', $service ? ['service' => $service] : []) }}" data-magnetic>
                <span class="btn__label">Start your project</span> <x-icon name="arrow" class="arrow" />
            </a>
        </div>
        @php($email = config('site.contact.email'))
        @php($phone = config('site.contact.phones')[0] ?? null)
        @if ($email || $phone)
            <p class="cta-final__contact" data-reveal>
                Prefer to talk directly?
                @if ($phone)Call <a href="tel:{{ \App\Support\Phone::e164($phone) }}">{{ \App\Support\Phone::display($phone) }}</a>@endif
                @if ($phone && $email) or email @elseif ($email) Email @endif
                @if ($email)<a href="mailto:{{ $email }}">{{ $email }}</a>@endif
            </p>
        @endif
    </div>
</section>
