{{-- Client logos. Hidden until resources/content/clients.php has entries. --}}
@if ($clients->isNotEmpty())
    @php
        // Six or more logos drift in two rows, in opposite directions;
        // fewer sit in a single static row.
        $scrolls = $clients->count() >= 6;
        $rows = $scrolls ? $clients->values()->split(2) : collect([$clients->values()]);
    @endphp
    <section class="clients" id="clients" aria-labelledby="clients-title">
        <div class="container clients__head">
            <x-eyebrow data-reveal>Our clients</x-eyebrow>
            <h2 class="h2" id="clients-title" data-reveal>Trusted by ambitious organisations.</h2>
        </div>

        <div class="clients__rows {{ $scrolls ? 'is-scrolling' : '' }}" data-reveal>
            @foreach ($rows as $row)
                <div class="clients__row {{ $loop->even ? 'clients__row--reverse' : '' }}"
                    style="--duration: {{ max(28, $row->count() * 6) }}s">
                    <div class="clients__track">
                        @foreach (range(1, $scrolls ? 2 : 1) as $copy)
                            <ul class="clients__group" @if ($copy > 1) aria-hidden="true" @endif>
                                @foreach ($row as $client)
                                    @php($linked = ! empty($client['url']) && $copy === 1)
                                    <li class="client">
                                        <{{ $linked ? 'a' : 'span' }} class="client__card"
                                            @if ($linked) href="{{ $client['url'] }}" rel="noopener" target="_blank" @endif>
                                            <img class="client__logo" src="{{ asset($client['logo']) }}"
                                                alt="{{ $copy === 1 ? $client['name'] : '' }}"
                                                width="{{ $client['width'] }}" height="{{ $client['height'] }}"
                                                style="--w: {{ $client['width'] }}px; --h: {{ $client['height'] }}px"
                                                loading="lazy" decoding="async">
                                            @if ($linked)<span class="sr-only"> (opens in a new tab)</span>@endif
                                        </{{ $linked ? 'a' : 'span' }}>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
