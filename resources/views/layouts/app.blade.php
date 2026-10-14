@php
    $siteName = config('site.name');
    $pageTitle = trim($__env->yieldContent('title'));
    $fullTitle = $pageTitle ? $pageTitle.' — '.$siteName : $siteName.' — '.config('site.tagline');
    $description = trim($__env->yieldContent('description')) ?: config('site.description');
    $canonical = trim($__env->yieldContent('canonical')) ?: url()->current();
    $ogImage = asset(config('site.og_image'));
    $contact = config('site.contact');
    $organization = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        '@id' => url('/').'#organization',
        'name' => config('site.legal_name'),
        'alternateName' => $siteName,
        'url' => url('/'),
        'logo' => asset('images/logo.png'),
        'description' => config('site.description'),
        'email' => $contact['email'] ?: null,
        'telephone' => $contact['phones'] ? \App\Support\Phone::e164($contact['phones'][0]) : null,
        'contactPoint' => collect($contact['phones'])->map(fn ($phone) => [
            '@type' => 'ContactPoint',
            'telephone' => \App\Support\Phone::e164($phone),
            'contactType' => 'customer service',
            'areaServed' => $contact['country_code'],
            'availableLanguage' => 'English',
        ])->all() ?: null,
        'foundingDate' => config('site.founded') ?: null,
        'address' => array_filter([
            '@type' => 'PostalAddress',
            'streetAddress' => $contact['address'] ?: null,
            'addressLocality' => $contact['city'] ?: null,
            'addressCountry' => $contact['country_code'] ?: null,
        ]),
        'sameAs' => array_values(config('site.social')) ?: null,
    ]);
@endphp
<!DOCTYPE html>
<html lang="en-GB" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $canonical }}">
    @unless (app()->isProduction())
        <meta name="robots" content="noindex, nofollow">
    @endunless
    @hasSection('robots')
        <meta name="robots" content="@yield('robots')">
    @endif

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $pageTitle ?: $fullTitle }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="en_GB">
    <meta name="twitter:card" content="summary_large_image">

    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('js/theme.js') }}"></script>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script type="application/ld+json">{!! json_encode($organization, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    @stack('schema')
</head>
<body>
    <a class="skip-link" href="#main">Skip to content</a>
    <div class="scroll-progress" aria-hidden="true" data-progress></div>

    @include('partials.header')

    <main id="main" tabindex="-1">
        @yield('content')
    </main>

    @include('partials.footer')

    <div class="cursor is-hidden" aria-hidden="true" data-cursor-el>
        <div class="cursor__ring"><span class="cursor__label"></span></div>
        <div class="cursor__dot"></div>
    </div>
</body>
</html>
