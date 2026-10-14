<?php

/*
|--------------------------------------------------------------------------
| Company details
|--------------------------------------------------------------------------
|
| Anything that varies per deployment, or that still needs confirming, comes
| from the environment. A blank value hides the matching element on the site
| rather than showing a placeholder, so nothing unverified is ever published.
|
*/

return [

    'name' => 'Techatron Consulting',
    'legal_name' => env('SITE_LEGAL_NAME', 'Techatron Consulting Limited'),
    'tagline' => 'Full-service digital agency',

    'description' => 'Techatron is a full-service digital agency in Lagos specialising in website, software and mobile app development, with the design, digital campaigns and technology support to help them grow.',

    'contact' => [
        // Where project enquiries are delivered. Not shown on the site.
        'inbox' => env('CONTACT_INBOX') ?: env('MAIL_FROM_ADDRESS'),

        // Public contact details, confirmed by Techatron. Environment values
        // override them; a blank value keeps the default.
        'email' => env('CONTACT_EMAIL') ?: 'hello@techatronagency.com',
        // Comma-separated, in local format; shown in order.
        'phones' => array_values(array_filter(array_map('trim', explode(',', env('CONTACT_PHONES') ?: '09022016978,07045414419')))),
        'whatsapp' => env('CONTACT_WHATSAPP'),
        'address' => env('CONTACT_ADDRESS') ?: '13 Adepele Street, Ikeja',
        'city' => env('CONTACT_CITY') ?: 'Lagos',
        'country' => env('CONTACT_COUNTRY') ?: 'Nigeria',
        'country_code' => env('CONTACT_COUNTRY_CODE') ?: 'NG',

        // e.g. "within one business day". Leave blank to make no promise.
        'response_time' => env('CONTACT_RESPONSE_TIME'),
    ],

    // Keys must match an icon in resources/views/components/social-icon.blade.php.
    'social' => [
        'LinkedIn' => env('SOCIAL_LINKEDIN') ?: 'https://www.linkedin.com/company/techatron-consulting-limited/',
        'Instagram' => env('SOCIAL_INSTAGRAM') ?: 'https://www.instagram.com/techatronconsultingltd/',
        'X' => env('SOCIAL_X') ?: 'https://x.com/techatronagency',
        'Facebook' => env('SOCIAL_FACEBOOK') ?: 'https://web.facebook.com/techatronconsultingltd',
        'TikTok' => env('SOCIAL_TIKTOK') ?: 'https://www.tiktok.com/@techatronconsultingltd',
    ],

    // Year the company was founded. Blank hides it.
    'founded' => env('SITE_FOUNDED'),

    // Path under public/ to the Open Graph image (1200 x 630).
    'og_image' => 'images/og-default.png',

    // Date shown on the privacy notice. Update whenever the notice changes.
    'privacy_updated' => '2026-10-14',

];
