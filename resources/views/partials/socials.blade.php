@if (config('site.social'))
    <ul class="socials" aria-label="{{ config('site.name') }} on social media">
        @foreach (config('site.social') as $network => $url)
            <li>
                <a href="{{ $url }}" rel="noopener me" target="_blank" data-cursor="hover">
                    <x-social-icon :name="$network" />
                    <span class="sr-only">{{ $network }} (opens in a new tab)</span>
                </a>
            </li>
        @endforeach
    </ul>
@endif
