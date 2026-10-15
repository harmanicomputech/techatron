@php($contact = config('site.contact'))
<footer class="site-footer section--alt">
    <div class="container">
        <div class="footer__top">
            <div class="footer__intro">
                <a class="brand" href="{{ route('home') }}" aria-label="{{ config('site.name') }} home">
                    <img class="logo-light" src="{{ asset('images/logo.png') }}" alt="" width="332" height="52" loading="lazy">
                    <img class="logo-dark" src="{{ asset('images/logo-dark.png') }}" alt="" width="332" height="52" loading="lazy">
                </a>
                <p>{{ config('site.description') }}</p>
                <a class="btn btn--primary" href="{{ route('contact') }}" data-magnetic>Start a project <x-icon name="arrow" class="arrow" /></a>
                <div style="margin-top: 1.75rem">@include('partials.socials')</div>
            </div>

            @foreach ($navGroups as $group => $items)
                @if ($loop->index < 2)
                    <div class="footer__col">
                        <h2 class="label">{{ $group }}</h2>
                        <ul>
                            @foreach ($items as $item)
                                <li><a href="{{ route('services.show', $item['slug']) }}">{{ $item['name'] }}</a></li>
                            @endforeach
                        </ul>
                        @if ($loop->index === 1)
                            <h2 class="label" style="margin-top: 2rem">Technology</h2>
                            <ul>
                                @foreach ($navGroups['Technology'] as $item)
                                    <li><a href="{{ route('services.show', $item['slug']) }}">{{ $item['short'] }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif
            @endforeach

            <div class="footer__col">
                <h2 class="label">Company</h2>
                <ul>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('approach') }}">How we work</a></li>
                    @if ($hasWork)<li><a href="{{ route('work.index') }}">Work</a></li>@endif
                    @if ($hasInsights)<li><a href="{{ route('insights.index') }}">Insights</a></li>@endif
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
                <h2 class="label" style="margin-top: 2rem">Get in touch</h2>
                <ul>
                    @if ($contact['email'])<li><a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></li>@endif
                    @foreach ($contact['phones'] as $phone)
                        <li><a href="tel:{{ \App\Support\Phone::e164($phone) }}">{{ \App\Support\Phone::display($phone) }}</a></li>
                    @endforeach
                    @if ($contact['address'] || $contact['city'])
                        <li><address>{{ collect([$contact['address'], $contact['city'], $contact['country']])->filter()->implode(', ') }}</address></li>
                    @endif
                </ul>
            </div>
        </div>

        @if ($technologies->isNotEmpty())
            <div class="footer__tech">
                <h2 class="label">Technologies we build with</h2>
                <ul class="tech-logos">
                    @foreach ($technologies as $tech)
                        <li class="tech-logo" style="--brand: {{ $tech['colour'] }}">
                            <x-tech-logo :name="$tech['icon']" />
                            <span>{{ $tech['name'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="footer__wordmark" aria-hidden="true" data-footer-word>
            @foreach (str_split('TECHATRON') as $letter)<span>{{ $letter }}</span>@endforeach
        </div>

        <div class="footer__bottom">
            <p>&copy; {{ now()->year }} {{ config('site.legal_name') }}. All rights reserved.</p>
            <ul>
                <li><a href="{{ route('privacy') }}">Privacy</a></li>
                <li><a href="{{ route('sitemap') }}">Sitemap</a></li>
            </ul>
        </div>
    </div>
</footer>
