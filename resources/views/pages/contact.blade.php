@extends('layouts.app')

@section('title', 'Start a project')
@section('description', 'Tell Techatron about your website, software, mobile app or digital campaign. A short brief is enough to start the conversation.')

@section('content')
    @php($contact = config('site.contact'))

    <x-page-hero
        :crumbs="['Contact' => null]"
        eyebrow="Start a conversation"
        title="Let’s build something remarkable together."
        lead="Tell us what you want to launch, fix or grow. A few sentences are enough to start; the more context you share, the more useful our first reply will be." />

    <section class="section section--flush-top" id="enquiry" aria-label="Project enquiry">
        <div class="container contact-layout">
            <div>
                @if (session('enquiry_sent'))
                    <div class="form-success" role="status" tabindex="-1" data-autofocus>
                        <div class="form-success__icon"><x-icon name="check" /></div>
                        <h2 class="h2" style="margin-bottom: 1rem">Thank you, {{ session('enquiry_sent') }}. Your brief is with us.</h2>
                        <p class="lead" style="margin-bottom: 2rem">
                            Someone from our team will read it properly and reply{{ $contact['response_time'] ? ' '.$contact['response_time'] : '' }} to arrange a conversation. If anything is urgent, email
                            @if ($contact['email'])<a class="text-link" href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>@else us @endif.
                        </p>
                        <div class="actions">
                            <a class="btn" href="{{ route('approach') }}">See how we deliver</a>
                            <a class="btn" href="{{ route('home') }}">Back to home</a>
                        </div>
                    </div>
                @else
                    <div class="contact-card" data-reveal>
                    <form class="form" method="POST" action="{{ route('contact.store') }}" data-enquiry novalidate>
                        @csrf
                        <input type="hidden" name="started" value="{{ $started }}">
                        <div class="hp" aria-hidden="true">
                            <label for="hp-website">Leave this field empty</label>
                            <input type="text" id="hp-website" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        @if ($errors->any())
                            <div class="alert alert--error" role="alert" tabindex="-1" data-autofocus>
                                <strong>Please check the highlighted fields.</strong>
                                @if ($errors->has('started') || $errors->has('website'))
                                    <ul><li>{{ $errors->first('started') ?: $errors->first('website') }}</li></ul>
                                @endif
                            </div>
                        @endif

                        <div class="form__row">
                            @include('partials.field', ['name' => 'name', 'label' => 'Your name', 'required' => true, 'autocomplete' => 'name', 'requiredMessage' => 'Please tell us your name.'])
                            @include('partials.field', ['name' => 'email', 'label' => 'Work email', 'type' => 'email', 'required' => true, 'autocomplete' => 'email', 'requiredMessage' => 'We need an email address to reply to you.'])
                        </div>
                        <div class="form__row">
                            @include('partials.field', ['name' => 'organisation', 'label' => 'Organisation', 'autocomplete' => 'organization'])
                            @include('partials.field', ['name' => 'phone', 'label' => 'Phone', 'type' => 'tel', 'autocomplete' => 'tel', 'pattern' => '[0-9+()\-.\s]{6,40}', 'patternMessage' => 'Please use digits and + ( ) - only.'])
                        </div>

                        <div class="form__section">
                            <fieldset class="field">
                                <legend>What can we help with? <span class="optional">(choose any)</span></legend>
                                @foreach (['specialty' => 'Development', 'digital' => 'Digital agency', 'technology' => 'Technology'] as $group => $groupLabel)
                                    <div class="choice-group">
                                        <span class="label">{{ $groupLabel }}</span>
                                        <div class="choice-grid">
                                            @foreach ($services->where('group', $group) as $service)
                                                <label class="choice">
                                                    <input type="checkbox" name="services[]" value="{{ $service['slug'] }}"
                                                        @checked(in_array($service['slug'], old('services', $selected), true))>
                                                    <span>{{ $service['short'] }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                @error('services')<p class="error">{{ $message }}</p>@enderror
                            </fieldset>

                            <div class="form__row">
                                <div class="field">
                                    <label for="stage">Where are you now? <span class="optional">(optional)</span></label>
                                    <select class="input" id="stage" name="stage">
                                        <option value="">Select one</option>
                                        @foreach ($stages as $value => $label)
                                            <option value="{{ $value }}" @selected(old('stage') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="field">
                                    <label for="timeline">Ideal timing <span class="optional">(optional)</span></label>
                                    <select class="input" id="timeline" name="timeline">
                                        <option value="">Select one</option>
                                        @foreach ($timelines as $value => $label)
                                            <option value="{{ $value }}" @selected(old('timeline') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="field">
                                <label for="message">About the project</label>
                                <p class="hint" id="message-hint">What are you trying to achieve, what is getting in the way, and is there a deadline or budget we should know about?</p>
                                <textarea class="input" id="message" name="message" rows="7" required minlength="20" maxlength="5000"
                                    aria-describedby="message-hint message-error" data-required="Tell us a little about what you need."
                                    @error('message') aria-invalid="true" @enderror>{{ old('message') }}</textarea>
                                <p class="error" id="message-error" @error('message') @else hidden @enderror>@error('message'){{ $message }}@enderror</p>
                            </div>
                        </div>

                        <div class="field">
                            <label class="consent" for="consent">
                                <input type="checkbox" id="consent" name="consent" value="1" required @checked(old('consent'))
                                    aria-describedby="consent-error" data-required="Please confirm we may use these details to respond."
                                    @error('consent') aria-invalid="true" @enderror>
                                <span>I agree that {{ config('site.name') }} may use these details to respond to my enquiry, as described in the <a class="text-link" href="{{ route('privacy') }}">privacy notice</a>.</span>
                            </label>
                            <p class="error" id="consent-error" @error('consent') @else hidden @enderror>@error('consent'){{ $message }}@enderror</p>
                        </div>

                        <div class="form__submit">
                            <button class="btn btn--primary btn--lg" type="submit">
                                <span class="btn__label">Send your brief</span> <x-icon name="arrow" class="arrow" /><span class="spinner" aria-hidden="true"></span>
                            </button>
                            <p class="dim" style="font-size: var(--text-sm)">No newsletters. No sharing your details.</p>
                        </div>
                    </form>
                    </div>
                @endif
            </div>

            <aside class="contact-aside" aria-label="Other ways to reach us" data-reveal>
                <div class="next-step">
                    <p class="label label--accent">What happens next</p>
                    <ol class="process-list">
                        <li><span><strong>We read your brief</strong>A person, not an autoresponder, reviews every enquiry.</span></li>
                        <li><span><strong>We arrange a call</strong>To understand your goals, constraints and timing.</span></li>
                        <li><span><strong>You receive a proposal</strong>Scope, approach, timeline and cost in writing.</span></li>
                    </ol>
                </div>
                @if ($contact['email'] || $contact['phones'] || $contact['address'] || $contact['city'])
                    <div class="next-step">
                        <p class="label label--accent">Direct contact</p>
                        <dl class="contact-channels">
                            @if ($contact['email'])
                                <div><dt>Email</dt><dd><a class="text-link" href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></dd></div>
                            @endif
                            @if ($contact['phones'])
                                <div><dt>Phone</dt><dd>
                                    @foreach ($contact['phones'] as $phone)
                                        <a class="text-link" href="tel:{{ \App\Support\Phone::e164($phone) }}">{{ \App\Support\Phone::display($phone) }}</a>@if (! $loop->last)<br>@endif
                                    @endforeach
                                </dd></div>
                            @endif
                            @if ($contact['whatsapp'])
                                <div><dt>WhatsApp</dt><dd><a class="text-link" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact['whatsapp']) }}" rel="noopener" target="_blank">{{ $contact['whatsapp'] }}<span class="sr-only"> (opens in a new tab)</span></a></dd></div>
                            @endif
                            @if ($contact['address'] || $contact['city'])
                                <div><dt>Office</dt><dd><address style="font-style: normal">{{ collect([$contact['address'], $contact['city'], $contact['country']])->filter()->implode(', ') }}</address></dd></div>
                            @endif
                        </dl>
                        @if (config('site.social'))
                            <p class="label" style="margin: 1.5rem 0 0.75rem">Follow us</p>
                            @include('partials.socials')
                        @endif
                    </div>
                @endif
            </aside>
        </div>
    </section>
@endsection
