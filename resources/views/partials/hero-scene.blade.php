{{-- Decorative hero composition: the logo's eclipse, a website, an app and campaign/brand cards. --}}
<div class="scene" aria-hidden="true" data-scene>
    <div class="layer orb" data-depth="0.25" data-intro="orb">@include('partials.orb')</div>

    <div class="layer l-browser" data-depth="0.5" data-intro="browser">
        <div class="mock mock-browser">
            <div class="mock-browser__bar">
                <span class="dots"><i></i><i></i><i></i></span>
                <span class="mock-browser__url"><x-icon name="lock" /> yourbrand.com</span>
            </div>
            <div class="mock-browser__body">
                <div class="mock-nav"><span class="logo"></span><span class="sk"></span><span class="sk"></span><span class="sk"></span><span class="pill"></span></div>
                <div class="mock-hero">
                    <div class="mock-hero__copy">
                        <span class="h" style="width: 95%"></span>
                        <span class="h" style="width: 70%"></span>
                        <span class="sk sk--soft" style="width: 90%"></span>
                        <span class="sk sk--soft" style="width: 75%"></span>
                        <span class="btns"><i></i><i></i></span>
                    </div>
                    <div class="mock-hero__art"></div>
                </div>
                <div class="mock-cards">
                    @for ($i = 0; $i < 3; $i++)
                        <div><span class="ic"></span><span class="sk" style="width: 80%"></span><span class="sk sk--soft" style="width: 60%"></span></div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <div class="layer l-phone" data-depth="0.9" data-intro="phone">
        <div class="mock-phone">
            <div class="mock-phone__screen">
                <div class="greet"><span class="sk" style="width: 40%"></span><span class="sk" style="width: 65%; height: 0.6rem; background: var(--fg)"></span></div>
                <div class="balance"><span class="sk" style="width: 40%"></span><span class="sk big"></span></div>
                @for ($i = 0; $i < 3; $i++)
                    <div class="row"><i></i><span class="sk sk--soft"></span></div>
                @endfor
                <div class="tabs"><i></i><i></i><i></i><i></i></div>
            </div>
        </div>
    </div>

    <div class="layer l-chart" data-depth="1.2" data-intro="card">
        <div class="float-card">
            <div class="chart-head"><span class="label">Campaign reach</span><span class="trend">▲ Growing</span></div>
            <div class="chart-bars">
                @foreach ([38, 52, 46, 64, 58, 78, 92] as $h)
                    <i style="--h: {{ $h }}%; --d: {{ $loop->index }}"></i>
                @endforeach
            </div>
        </div>
    </div>

    <div class="layer l-palette" data-depth="1" data-intro="card">
        <div class="float-card">
            <span class="label">Brand system</span>
            <div class="swatches">
                <i style="background: #0B34B7"></i><i style="background: #282828"></i><i style="background: #18B6FF"></i><i style="background: #FFFFFF"></i>
            </div>
            <div class="type-sample">Aa <small>Poppins</small></div>
        </div>
    </div>

    <div class="layer l-deploy" data-depth="1.4" data-intro="card">
        <div class="float-card"><span class="ok"><x-icon name="check" /></span> Live in production</div>
    </div>
</div>
