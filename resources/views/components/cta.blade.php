@props([
    'title' => 'Have a project in mind?',
    'accent' => 'Let’s talk.',
    'body' => 'Tell us what you want to launch, fix or grow. We will come back with honest questions, a clear view of the options, and what it would take to deliver.',
    'service' => null,
])
@php
    $contact = config('site.contact');
    $address = collect([$contact['address'], $contact['city']])->filter()->implode(', ');
    $mapUrl = $address ? 'https://www.google.com/maps/search/?api=1&query='.rawurlencode($address.', '.$contact['country']) : null;
@endphp
<section class="cta" aria-labelledby="cta-title">
    <div class="container">
        <div class="cta__card" data-reveal>
            <div class="cta__decor" aria-hidden="true">
                <div class="cta__grid"></div>
                <div class="cta__glow cta__glow--1"></div>
                <div class="cta__glow cta__glow--2"></div>
                <div class="cta__orb orb" data-parallax="0.12">@include('partials.orb')</div>
            </div>

            <div class="cta__main">
                <p class="cta__eyebrow"><span class="cta__pulse"></span> Start a conversation</p>
                <h2 class="cta__title" id="cta-title">{{ $title }} <span>{{ $accent }}</span></h2>
                <p class="cta__body">{{ $body }}</p>
                <div class="cta__actions">
                    <a class="btn btn--lg cta__btn" href="{{ route('contact', $service ? ['service' => $service] : []) }}" data-magnetic>
                        <span class="btn__label">Start your project</span> <x-icon name="arrow" class="arrow" />
                    </a>
                    <p class="cta__note"><x-icon name="check" /> No obligation, just an honest conversation.</p>
                </div>
            </div>

            <aside class="cta__panel" aria-label="Contact details">
                <p class="cta__panel-title">Or reach us directly</p>
                <ul class="cta__channels">
                    @if ($contact['email'])
                        <li>
                            <a class="cta__channel" href="mailto:{{ $contact['email'] }}">
                                <span class="cta__icon"><x-icon name="mail" /></span>
                                <span class="cta__text"><small>Email</small>{{ $contact['email'] }}</span>
                                <x-icon name="arrow-up-right" class="cta__go" />
                            </a>
                        </li>
                    @endif
                    @foreach ($contact['phones'] as $phone)
                        <li>
                            <a class="cta__channel" href="tel:{{ \App\Support\Phone::e164($phone) }}">
                                <span class="cta__icon"><x-icon name="phone" /></span>
                                <span class="cta__text"><small>{{ $loop->first ? 'Call' : 'Or call' }}</small>{{ \App\Support\Phone::display($phone) }}</span>
                                <x-icon name="arrow-up-right" class="cta__go" />
                            </a>
                        </li>
                    @endforeach
                    @if ($mapUrl)
                        <li>
                            <a class="cta__channel" href="{{ $mapUrl }}" rel="noopener" target="_blank">
                                <span class="cta__icon"><x-icon name="pin" /></span>
                                <span class="cta__text"><small>Visit</small>{{ $address }}<span class="sr-only"> (opens map in a new tab)</span></span>
                                <x-icon name="arrow-up-right" class="cta__go" />
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="cta__social">@include('partials.socials')</div>
            </aside>
        </div>
    </div>
</section>
