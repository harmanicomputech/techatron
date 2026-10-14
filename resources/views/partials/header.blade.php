@php
    $links = array_filter([
        $hasWork ? ['label' => 'Work', 'route' => 'work.index', 'active' => 'work.*'] : null,
        ['label' => 'Approach', 'route' => 'approach', 'active' => 'approach'],
        ['label' => 'About', 'route' => 'about', 'active' => 'about'],
        $hasInsights ? ['label' => 'Insights', 'route' => 'insights.index', 'active' => 'insights.*'] : null,
    ]);
@endphp
<header class="site-header" data-header>
    <div class="container">
        <div class="site-header__bar">
            <a class="brand" href="{{ route('home') }}" aria-label="{{ config('site.name') }} home" data-cursor="hover">
                <img class="logo-light" src="{{ asset('images/logo.png') }}" alt="" width="332" height="52">
                <img class="logo-dark" src="{{ asset('images/logo-dark.png') }}" alt="" width="332" height="52">
            </a>

            <nav class="nav" aria-label="Main">
                <div class="nav__item" data-mega>
                    <button class="nav__link" type="button" aria-expanded="false" aria-controls="mega-services" data-mega-trigger
                        @if (request()->routeIs('services.*')) aria-current="page" @endif>
                        Services <x-icon name="chevron" class="chev" />
                    </button>
                    <div class="mega" id="mega-services" data-mega-panel data-open="false">
                        <div class="mega__cols">
                            @foreach ($navGroups as $group => $items)
                                <div class="mega__group {{ $loop->first ? 'mega__group--featured' : '' }}">
                                    <span class="label">{{ $group }}</span>
                                    <ul>
                                        @foreach ($items as $item)
                                            <li>
                                                <a class="mega__link" href="{{ route('services.show', $item['slug']) }}">
                                                    <strong>{{ $item['name'] }}</strong>
                                                    @if ($loop->parent->first)<span>{{ $item['blurb'] }}</span>@endif
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                        <div class="mega__foot">
                            <span>Not sure which fits? Tell us the problem and we will shape the solution.</span>
                            <a class="arrow-link" href="{{ route('services.index') }}">All services <x-icon name="arrow" class="arrow" /></a>
                        </div>
                    </div>
                </div>
                @foreach ($links as $link)
                    <a class="nav__link" href="{{ route($link['route']) }}" @if (request()->routeIs($link['active'])) aria-current="page" @endif>{{ $link['label'] }}</a>
                @endforeach
                <a class="nav__link" href="{{ route('contact') }}" @if (request()->routeIs('contact')) aria-current="page" @endif>Contact</a>
            </nav>

            <div class="header-actions">
                <button class="icon-btn theme-toggle" type="button" data-theme-toggle aria-label="Switch to dark mode" aria-pressed="false">
                    <x-icon name="sun" class="sun" />
                    <x-icon name="moon" class="moon" />
                </button>
                <a class="btn btn--primary" href="{{ route('contact') }}" data-magnetic><span class="btn__label">Start a project</span> <x-icon name="arrow" class="arrow" /></a>
                <button class="icon-btn menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-nav" aria-label="Open menu" data-menu-toggle>
                    <span></span><span></span>
                </button>
            </div>
        </div>
    </div>
</header>

<div class="mobile-nav" id="mobile-nav" data-open="false">
    <nav class="mobile-nav__primary" aria-label="Mobile">
        <a href="{{ route('services.index') }}" style="--i: 0">Services <span class="mono">{{ str_pad($navServices->count(), 2, '0', STR_PAD_LEFT) }}</span></a>
        @foreach ($links as $link)
            <a href="{{ route($link['route']) }}" style="--i: {{ $loop->iteration }}">{{ $link['label'] }}</a>
        @endforeach
        <a href="{{ route('contact') }}" style="--i: {{ count($links) + 1 }}">Contact</a>
    </nav>
    <div>
        <p class="label">What we do</p>
        <div class="mobile-nav__services">
            @foreach ($navServices as $item)
                <a href="{{ route('services.show', $item['slug']) }}">{{ $item['short'] }}</a>
            @endforeach
        </div>
    </div>
    <a class="btn btn--primary btn--lg btn--block" href="{{ route('contact') }}">Start a project <x-icon name="arrow" class="arrow" /></a>
</div>
