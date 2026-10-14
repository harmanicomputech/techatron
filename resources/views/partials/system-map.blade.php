{{-- Hero visual: an illustrative system architecture, with traffic flowing through it. --}}
<figure class="system" aria-label="Illustration of a software system: web, mobile and partner applications connected through an API gateway to services, a queue and a database, running on monitored cloud infrastructure.">
    <div class="system__frame">
        <div class="grid-bg" aria-hidden="true"></div>
        <div class="system__bar" aria-hidden="true">
            <span class="dots"><i></i><i></i><i></i></span>
            <span>system / production</span>
            <span class="system__status">healthy</span>
        </div>

        <svg class="system__map" viewBox="0 0 480 300" preserveAspectRatio="xMidYMin meet" aria-hidden="true" focusable="false">
            <defs>
                <linearGradient id="flow" x1="0" x2="1">
                    <stop offset="0" stop-color="#34E8AE" stop-opacity="0.2"/>
                    <stop offset="0.5" stop-color="#34E8AE"/>
                    <stop offset="1" stop-color="#7F97FF"/>
                </linearGradient>
            </defs>

            {{-- Edges --}}
            <path id="e1" class="edge" d="M128 52 C158 52 158 122 188 122"/>
            <path id="e2" class="edge" d="M128 122 L188 122"/>
            <path id="e3" class="edge" d="M128 192 C158 192 158 122 188 122"/>
            <path id="e4" class="edge" d="M292 122 C322 122 322 52 352 52"/>
            <path id="e5" class="edge" d="M292 122 L352 122"/>
            <path id="e6" class="edge" d="M292 122 C322 122 322 192 352 192"/>
            <path id="e7" class="edge" d="M404 144 L404 170"/>
            <path class="edge" d="M240 144 L240 236" stroke-dasharray="2 4"/>
            <path class="edge" d="M404 214 L404 236" stroke-dasharray="2 4"/>
            <path class="edge" d="M76 214 L76 236" stroke-dasharray="2 4"/>

            <path class="edge edge--flow" d="M128 52 C158 52 158 122 188 122"/>
            <path class="edge edge--flow" d="M292 122 L352 122"/>
            <path class="edge edge--flow" d="M292 122 C322 122 322 192 352 192"/>

            {{-- Packets --}}
            <circle class="packet" r="2.5"><animateMotion dur="2.4s" repeatCount="indefinite"><mpath href="#e1"/></animateMotion></circle>
            <circle class="packet packet--ion" r="2.5"><animateMotion dur="1.8s" begin="0.6s" repeatCount="indefinite"><mpath href="#e2"/></animateMotion></circle>
            <circle class="packet" r="2.5"><animateMotion dur="2.8s" begin="1.1s" repeatCount="indefinite"><mpath href="#e3"/></animateMotion></circle>
            <circle class="packet packet--ion" r="2.5"><animateMotion dur="2.2s" begin="0.3s" repeatCount="indefinite"><mpath href="#e4"/></animateMotion></circle>
            <circle class="packet" r="2.5"><animateMotion dur="1.6s" begin="0.9s" repeatCount="indefinite"><mpath href="#e5"/></animateMotion></circle>
            <circle class="packet" r="2.5"><animateMotion dur="2.6s" begin="1.5s" repeatCount="indefinite"><mpath href="#e6"/></animateMotion></circle>
            <circle class="packet packet--ion" r="2"><animateMotion dur="1.2s" begin="0.4s" repeatCount="indefinite"><mpath href="#e7"/></animateMotion></circle>

            {{-- Clients --}}
            <g class="node"><rect x="24" y="30" width="104" height="44" rx="8"/><text x="38" y="49">web app</text><text class="sub" x="38" y="63">browser</text></g>
            <g class="node"><rect x="24" y="100" width="104" height="44" rx="8"/><text x="38" y="119">mobile app</text><text class="sub" x="38" y="133">ios · android</text></g>
            <g class="node"><rect x="24" y="170" width="104" height="44" rx="8"/><text x="38" y="189">partners</text><text class="sub" x="38" y="203">payments · erp</text></g>

            {{-- Core --}}
            <rect class="ring" x="188" y="100" width="104" height="44" rx="8"/>
            <g class="node node--core"><rect x="188" y="100" width="104" height="44" rx="8"/><text x="202" y="119">api gateway</text><text class="sub" x="202" y="133">auth · limits</text></g>

            {{-- Back end --}}
            <g class="node"><rect x="352" y="30" width="104" height="44" rx="8"/><text x="366" y="49">services</text><text class="sub" x="366" y="63">business logic</text></g>
            <g class="node"><rect x="352" y="100" width="104" height="44" rx="8"/><text x="366" y="119">queue</text><text class="sub" x="366" y="133">jobs · events</text></g>
            <g class="node"><rect x="352" y="170" width="104" height="44" rx="8"/><text x="366" y="189">database</text><text class="sub" x="366" y="203">encrypted</text></g>

            {{-- Platform --}}
            <g class="node"><rect x="24" y="236" width="432" height="30" rx="8" stroke-dasharray="3 3"/><text x="38" y="255">cloud infrastructure</text><text class="sub" x="300" y="255">monitored · as code</text></g>
        </svg>
    </div>

    <div class="system__card system__card--checks" aria-hidden="true">
        <ul>
            <li><x-icon name="check" /> security review</li>
            <li><x-icon name="check" /> performance budget</li>
            <li><x-icon name="check" /> accessibility</li>
            <li><x-icon name="check" /> backups verified</li>
        </ul>
    </div>

    <div class="system__card system__card--log" aria-hidden="true">
        <header><span>release pipeline</span><span>main</span></header>
        <ul data-log>
            <li><span class="info">→</span> build started</li>
            <li><span class="ok">✓</span> unit &amp; integration tests passed</li>
            <li><span class="ok">✓</span> security scan clean</li>
            <li><span class="info">→</span> deploying to production</li>
            <li><span class="ok">✓</span> health checks passing</li>
        </ul>
    </div>
</figure>
