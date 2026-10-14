@extends('layouts.app')

@section('title', 'Privacy notice')
@section('description', 'How Techatron Consulting collects, uses and protects personal data submitted through this website.')

@section('content')
    @php($contact = config('site.contact'))
    <x-page-hero :crumbs="['Privacy' => null]" eyebrow="Legal" title="Privacy notice" lead="How we handle the personal data you share with us through this website." />

    <section class="section section--flush-top">
        <div class="container">
            <div class="prose">
                <p>This notice explains how {{ config('site.legal_name') }} (“Techatron”, “we”, “us”) collects and uses personal data through this website. We process personal data in line with the Nigeria Data Protection Act 2023 and other laws that apply to us.</p>

                <h2>What we collect</h2>
                <p>When you send an enquiry through our contact form we collect the details you choose to provide: your name, email address, organisation, phone number, the services you are interested in and your message. We also record the date of the enquiry, your IP address and your browser’s user agent to help us detect spam and abuse.</p>
                <p>If you email or call us directly, we keep the correspondence and the contact details it contains.</p>

                <h2>How we use it</h2>
                <ul>
                    <li>To respond to your enquiry and discuss a potential project with you.</li>
                    <li>To prepare proposals and, if we work together, to manage our relationship.</li>
                    <li>To protect this website and our systems against spam, fraud and misuse.</li>
                </ul>
                <p>We rely on your consent, given when you submit the form, and on our legitimate interest in responding to business enquiries and keeping our systems secure. We do not use your details for marketing newsletters, and we do not sell or rent them to anyone.</p>

                <h2>Who we share it with</h2>
                <p>We share personal data only with service providers that help us operate this website and our business, such as our hosting and email providers, under terms that require them to protect it. We may disclose information where the law requires us to.</p>

                <h2>How long we keep it</h2>
                <p>We keep enquiries only for as long as needed to respond, follow up and keep reasonable business records, and we delete or anonymise them when they are no longer required.</p>

                <h2>Cookies</h2>
                <p>This website uses only the cookies it needs to work: a session cookie and a security token that protects forms against cross-site request forgery. We do not use advertising or analytics cookies.</p>

                <h2>Security</h2>
                <p>Data sent to this website is encrypted in transit. Access to enquiries is limited to the people who need it to respond to you.</p>

                <h2>Your rights</h2>
                <p>You may ask us for a copy of the personal data we hold about you, ask us to correct or delete it, withdraw your consent, or object to how we use it. You also have the right to complain to the Nigeria Data Protection Commission.</p>

                <h2>Contact</h2>
                <p>For any privacy question or request, contact us{{ $contact['email'] ? ' at ' : '' }}@if ($contact['email'])<a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>@endif.</p>

                <p class="dim">Last updated {{ \Illuminate\Support\Carbon::parse(config('site.privacy_updated'))->format('j F Y') }}.</p>
            </div>
        </div>
    </section>
@endsection
