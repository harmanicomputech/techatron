@props([
    'title' => 'Have a business challenge worth solving?',
    'body' => 'Tell us what you are trying to achieve. We will come back with honest questions, a clear view of the options, and what it would take to deliver.',
    'service' => null,
])
<section class="section section--tight" aria-labelledby="cta-title">
    <div class="container">
        <div class="cta" data-reveal>
            <div class="grid-bg" aria-hidden="true"></div>
            <div class="cta__grid">
                <div>
                    <x-eyebrow>Start a conversation</x-eyebrow>
                    <h2 class="display" id="cta-title">{{ $title }}</h2>
                </div>
                <div>
                    <p>{{ $body }}</p>
                    <div class="actions">
                        <a class="btn btn--primary btn--lg" href="{{ route('contact', $service ? ['service' => $service] : []) }}">
                            Discuss your project <x-icon name="arrow" class="arrow" />
                        </a>
                    </div>
                    @if ($email = config('site.contact.email'))
                        <p class="cta__contact">Prefer email? <a href="mailto:{{ $email }}">{{ $email }}</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
