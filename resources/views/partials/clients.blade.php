{{-- Client logos. Hidden until resources/content/clients.php has entries. --}}
@if ($clients->isNotEmpty())
    @php($scrolls = $clients->count() >= 6)
    <section class="clients" id="clients" aria-labelledby="clients-title">
        <div class="container clients__head" data-reveal>
            <span class="clients__rule" aria-hidden="true"></span>
            <h2 class="label" id="clients-title">Trusted by organisations we are proud to work with</h2>
            <span class="clients__rule" aria-hidden="true"></span>
        </div>

        <div class="{{ $scrolls ? 'clients__marquee' : 'container' }}" data-reveal>
            <div class="clients__track" @if ($scrolls) style="--duration: {{ max(30, $clients->count() * 5) }}s" @endif>
                @foreach (range(1, $scrolls ? 2 : 1) as $copy)
                    <ul class="clients__group {{ $scrolls ? '' : 'clients__group--static' }}" @if ($copy > 1) aria-hidden="true" @endif>
                        @foreach ($clients as $client)
                            <li class="client">
                                @php($tag = ! empty($client['url']) && $copy === 1 ? 'a' : 'span')
                                <{{ $tag }} class="client__tile"
                                    @if ($tag === 'a') href="{{ $client['url'] }}" rel="noopener" target="_blank" @endif
                                    @if ($copy > 1) tabindex="-1" @endif>
                                    <img class="client__logo {{ ! empty($client['logo_dark']) ? 'has-dark' : '' }}" src="{{ asset($client['logo']) }}"
                                        alt="{{ $copy === 1 ? $client['name'] : '' }}" loading="lazy" decoding="async">
                                    @if (! empty($client['logo_dark']))
                                        <img class="client__logo client__logo--dark" src="{{ asset($client['logo_dark']) }}" alt="" loading="lazy" decoding="async">
                                    @endif
                                    @if ($tag === 'a')<span class="sr-only"> (opens in a new tab)</span>@endif
                                </{{ $tag }}>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    </section>
@endif
