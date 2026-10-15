@php
    /*
     | The "build studio": an editor that types code for each kind of product
     | while the preview assembles itself. Purely illustrative; the code is
     | written for readability, not to be run.
     */
    $k = fn ($t) => '<span class="tk-k">'.$t.'</span>';   // keyword
    $f = fn ($t) => '<span class="tk-f">'.$t.'</span>';   // function / component
    $s = fn ($t) => '<span class="tk-s">'.$t.'</span>';   // string
    $c = fn ($t) => '<span class="tk-c">'.$t.'</span>';   // comment
    $p = fn ($t) => '<span class="tk-p">'.$t.'</span>';   // property

    $studio = [
        'website' => [
            'label' => 'Website',
            'icon' => 'globe',
            'file' => 'home.blade.php',
            'code' => [
                $c('// Fast, search-friendly, built to convert'),
                '&lt;'.$f('Hero').' '.$p('title').'='.$s('"Grow with us"').' /&gt;',
                '&lt;'.$f('Services').' '.$p('layout').'='.$s('"cards"').' /&gt;',
                '&lt;'.$f('Testimonials').' '.$p('autoplay').' /&gt;',
                '&lt;'.$f('ContactForm').' '.$p('to').'='.$s('"sales"').' /&gt;',
                '',
                $k('deploy').' '.$s('--edge --ssl'),
            ],
        ],
        'mobile' => [
            'label' => 'Mobile app',
            'icon' => 'mobile',
            'file' => 'App.tsx',
            'code' => [
                $c('// One codebase, iOS and Android'),
                $k('const').' app = '.$f('createApp').'({',
                '  '.$p('screens').': ['.$s("'Home'").', '.$s("'Wallet'").', '.$s("'Profile'").'],',
                '  '.$p('payments').': '.$k('true').',',
                '  '.$p('offline').': '.$k('true').',',
                '});',
                $k('publish').'(app, ['.$s("'ios'").', '.$s("'android'").']);',
            ],
        ],
        'software' => [
            'label' => 'Software',
            'icon' => 'code',
            'file' => 'routes/api.php',
            'code' => [
                $c('// Your process, automated'),
                $f('Route').'::'.$f('get').'('.$s("'/orders'").', [Orders::'.$k('class').']);',
                $f('Route').'::'.$f('post').'('.$s("'/approve'").', Approve::'.$k('class').');',
                '',
                '$dashboard-&gt;'.$f('chart').'('.$s("'revenue'").')',
                '    -&gt;'.$f('live').'()',
                '    -&gt;'.$f('share').'('.$s("'team'").');',
            ],
        ],
    ];

    $chips = [
        ['AI', 'a', 1.4], ['Cloud', 'b', 0.9], ['APIs', 'c', 1.2], ['iOS', 'd', 1.6],
        ['Android', 'e', 1.1], ['SEO', 'f', 1.5], ['UI/UX', 'g', 0.8], ['Analytics', 'h', 1.3],
    ];
@endphp

<div class="studio-stage" data-scene>
    {{-- The logo's eclipse rising behind the window --}}
    <div class="hero__sun orb" aria-hidden="true">@include('partials.orb')</div>

    {{-- Floating technology tags --}}
    <ul class="tech-chips" aria-hidden="true">
        @foreach ($chips as [$label, $pos, $depth])
            <li class="tech-chip tech-chip--{{ $pos }}" data-depth="{{ $depth }}" data-intro="chip"><span>{{ $label }}</span></li>
        @endforeach
    </ul>

    <div class="studio is-running" data-studio data-intro="studio">
        <div class="studio__bar">
            <span class="studio__dots" aria-hidden="true"><i></i><i></i><i></i></span>
            <div class="studio__tabs" role="tablist" aria-label="What we build">
                @foreach ($studio as $key => $item)
                    <button class="studio__tab" type="button" role="tab" id="studio-tab-{{ $key }}"
                        aria-controls="studio-panel-{{ $key }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                        @unless ($loop->first) tabindex="-1" @endunless>
                        <x-icon :name="$item['icon']" /> <span>{{ $item['label'] }}</span>
                    </button>
                @endforeach
            </div>
            <span class="studio__live" aria-hidden="true"><i></i> Live</span>
        </div>

        @foreach ($studio as $key => $item)
            <div class="studio__panel {{ $loop->first ? 'is-active' : '' }}" id="studio-panel-{{ $key }}" role="tabpanel"
                aria-labelledby="studio-tab-{{ $key }}" @unless ($loop->first) hidden @endunless>
                <div class="studio__body">
                    {{-- Editor --}}
                    <div class="studio__code" aria-hidden="true">
                        <div class="studio__file"><x-icon name="code" /> {{ $item['file'] }}</div>
                        <ol class="code">
                            @foreach ($item['code'] as $line)
                                @php($chars = max(1, mb_strlen(html_entity_decode(strip_tags($line)))))
                                <li><span class="code__line" style="--n: {{ $chars }}; --d: {{ $loop->index * 0.45 }}s">{!! $line ?: '&nbsp;' !!}</span></li>
                            @endforeach
                        </ol>
                    </div>

                    {{-- Live preview --}}
                    <div class="studio__preview" aria-hidden="true">
                        @if ($key === 'website')
                            <div class="pv-site">
                                <div class="pv-site__nav pv" style="--d: .5s"><i class="logo"></i><span></span><span></span><span></span><b></b></div>
                                <div class="pv-site__hero pv" style="--d: .9s">
                                    <div class="copy"><i class="h"></i><i class="h short"></i><i class="t"></i><i class="t"></i><b></b></div>
                                    <div class="art"></div>
                                </div>
                                <div class="pv-site__cards">
                                    @foreach ([1.4, 1.6, 1.8] as $d)
                                        <div class="pv" style="--d: {{ $d }}s"><i></i><span></span><span class="short"></span></div>
                                    @endforeach
                                </div>
                                <div class="pv-site__form pv" style="--d: 2.3s"><span></span><span></span><b>Send</b></div>
                            </div>
                        @elseif ($key === 'mobile')
                            <div class="pv-phones">
                                <div class="pv-phone pv" style="--d: .5s">
                                    <div class="screen">
                                        <i class="h"></i>
                                        <div class="balance pv" style="--d: 1.1s"><span></span><b></b></div>
                                        @foreach ([1.5, 1.8, 2.1] as $d)
                                            <div class="row pv" style="--d: {{ $d }}s"><i></i><span></span></div>
                                        @endforeach
                                        <div class="tabs"><i></i><i></i><i></i><i></i></div>
                                    </div>
                                </div>
                                <div class="pv-phone pv-phone--back pv" style="--d: .9s">
                                    <div class="screen"><div class="card pv" style="--d: 1.6s"></div><div class="pay pv" style="--d: 2.2s">Pay now</div></div>
                                </div>
                                <span class="pv-store pv" style="--d: 2.6s"><x-icon name="check" /> Published</span>
                            </div>
                        @else
                            <div class="pv-dash">
                                <div class="pv-dash__side pv" style="--d: .4s"><i></i><i></i><i></i><i></i></div>
                                <div class="pv-dash__main">
                                    <div class="pv-dash__stats">
                                        @foreach ([.8, 1, 1.2] as $d)
                                            <div class="pv" style="--d: {{ $d }}s"><span></span><b></b></div>
                                        @endforeach
                                    </div>
                                    <div class="pv-dash__chart pv" style="--d: 1.4s">
                                        <svg viewBox="0 0 300 110" preserveAspectRatio="none">
                                            <path class="area" d="M0 95 C30 90 50 70 80 72 S130 45 160 50 S220 20 250 24 S285 10 300 8 L300 110 L0 110Z"/>
                                            <path class="line" d="M0 95 C30 90 50 70 80 72 S130 45 160 50 S220 20 250 24 S285 10 300 8"/>
                                        </svg>
                                    </div>
                                    <div class="pv-dash__table">
                                        @foreach ([2, 2.2, 2.4] as $d)
                                            <div class="pv" style="--d: {{ $d }}s"><i></i><span></span><em>Approved</em></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <div class="studio__status" aria-hidden="true">
            <ol class="studio__steps">
                @foreach (['Design', 'Build', 'Test', 'Deploy'] as $step)
                    <li style="--s: {{ $loop->index }}"><x-icon name="check" /> {{ $step }}</li>
                @endforeach
            </ol>
            <span class="studio__progress"><i></i></span>
            <span class="studio__env"><i></i> Live in production</span>
        </div>
    </div>
</div>
