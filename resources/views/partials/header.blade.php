@php
    $links = array_filter([
        ['label' => 'Approach', 'route' => 'approach', 'active' => 'approach'],
        $hasWork ? ['label' => 'Work', 'route' => 'work.index', 'active' => 'work.*'] : null,
        ['label' => 'About', 'route' => 'about', 'active' => 'about'],
        $hasInsights ? ['label' => 'Insights', 'route' => 'insights.index', 'active' => 'insights.*'] : null,
    ]);
@endphp
<header class="site-header" data-header>
    <div class="container site-header__inner">
        <a class="brand" href="{{ route('home') }}" aria-label="{{ config('site.name') }} home">
            <x-logo-mark />
            <span>Techatron</span>
            <small>Consulting</small>
        </a>

        <nav class="nav" aria-label="Main">
            <div class="nav__item" data-mega>
                <button class="nav__link" type="button" aria-expanded="false" aria-controls="mega-services" data-mega-trigger
                    @if (request()->routeIs('services.*')) aria-current="page" @endif>
                    Services <x-icon name="chevron" class="chev" />
                </button>
                <div class="mega" id="mega-services" data-mega-panel data-open="false">
                    <ul class="mega__grid">
                        @foreach ($navServices as $item)
                            <li>
                                <a class="mega__link" href="{{ route('services.show', $item['slug']) }}">
                                    <span class="mono">{{ $item['index'] }}</span>
                                    <strong>{{ $item['name'] }}</strong>
                                    <span>{{ $item['blurb'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mega__foot">
                        <span>Not sure which fits? Start with the problem.</span>
                        <a class="arrow-link" href="{{ route('services.index') }}">All services <x-icon name="arrow" class="arrow" /></a>
                    </div>
                </div>
            </div>
            @foreach ($links as $link)
                <a class="nav__link" href="{{ route($link['route']) }}" @if (request()->routeIs($link['active'])) aria-current="page" @endif>{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <div class="header-cta">
            <a class="btn btn--primary" href="{{ route('contact') }}">Discuss your project</a>
            <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-nav" aria-label="Open menu" data-menu-toggle>
                <span></span><span></span>
            </button>
        </div>
    </div>
</header>

<div class="mobile-nav" id="mobile-nav" data-open="false">
    <nav class="mobile-nav__primary" aria-label="Mobile">
        <a href="{{ route('services.index') }}">Services <span class="mono">{{ str_pad($navServices->count(), 2, '0', STR_PAD_LEFT) }}</span></a>
        @foreach ($links as $link)
            <a href="{{ route($link['route']) }}">{{ $link['label'] }}</a>
        @endforeach
        <a href="{{ route('contact') }}">Contact</a>
    </nav>
    <div>
        <p class="label">Services</p>
        <div class="mobile-nav__services">
            @foreach ($navServices as $item)
                <a href="{{ route('services.show', $item['slug']) }}">{{ $item['name'] }}</a>
            @endforeach
        </div>
    </div>
    <a class="btn btn--primary btn--lg btn--block" href="{{ route('contact') }}">Discuss your project <x-icon name="arrow" class="arrow" /></a>
</div>
