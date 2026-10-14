@php($contact = config('site.contact'))
<footer class="site-footer">
    <div class="container">
        <div class="footer__top">
            <div class="footer__intro">
                <a class="brand" href="{{ route('home') }}" aria-label="{{ config('site.name') }} home">
                    <x-logo-mark /><span>Techatron</span><small>Consulting</small>
                </a>
                <p>{{ config('site.description') }}</p>
            </div>

            <div class="footer__col">
                <h2 class="label">Services</h2>
                <ul>
                    @foreach ($navServices as $item)
                        <li><a href="{{ route('services.show', $item['slug']) }}">{{ $item['short'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="footer__col">
                <h2 class="label">Company</h2>
                <ul>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('approach') }}">How we work</a></li>
                    @if ($hasWork)<li><a href="{{ route('work.index') }}">Work</a></li>@endif
                    @if ($hasInsights)<li><a href="{{ route('insights.index') }}">Insights</a></li>@endif
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

            <div class="footer__col">
                <h2 class="label">Contact</h2>
                <ul>
                    @if ($contact['email'])<li><a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></li>@endif
                    @if ($contact['phone'])<li><a href="tel:{{ preg_replace('/[^0-9+]/', '', $contact['phone']) }}">{{ $contact['phone'] }}</a></li>@endif
                    @if ($contact['address'] || $contact['city'])
                        <li><address>{{ collect([$contact['address'], $contact['city'], $contact['country']])->filter()->implode(', ') }}</address></li>
                    @endif
                    @foreach (config('site.social') as $network => $url)
                        <li><a href="{{ $url }}" rel="noopener me" target="_blank">{{ $network }}<span class="sr-only"> (opens in a new tab)</span></a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="footer__wordmark" aria-hidden="true">Techatron</div>

        <div class="footer__bottom">
            <p>&copy; {{ now()->year }} {{ config('site.legal_name') }}. All rights reserved.</p>
            <ul>
                <li><a href="{{ route('privacy') }}">Privacy</a></li>
                <li><a href="{{ route('sitemap') }}">Sitemap</a></li>
            </ul>
        </div>
    </div>
</footer>
