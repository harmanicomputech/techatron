# Techatron Consulting website

Corporate website for Techatron Consulting Limited (software engineering and technology consulting, Lagos). Laravel 13, Blade, hand-written CSS and vanilla JS built with Vite. No CSS or JS framework.

## Commands

- `php artisan test` — run the test suite
- `vendor/bin/pint` — format PHP (CI runs `pint --test`)
- `npm run dev` / `npm run build` — assets
- `composer run dev` — local server + Vite

## Layout

- `resources/content/*.php` — all site copy (services, approach, challenges, principles, engagements, platforms, work, testimonials, insights). Edit copy here, not in templates. Read through `App\Support\Content`.
- `config/site.php` — company details; contact details come from `.env` and are hidden when blank
- `routes/web.php` — pages, contact form, sitemap/robots, legacy redirects (redirects must stay above `/services/{slug}`)
- `app/Http/Controllers/` — thin controllers; `EnquiryController` + `StoreEnquiryRequest` handle the project brief form
- `resources/views/layouts/app.blade.php` — `<head>`: titles, canonical, Open Graph, Organization JSON-LD. Pages set `@section('title')`, `@section('description')`, optional `@push('schema')`
- `resources/views/components/` — `x-icon`, `x-glyph`, `x-eyebrow`, `x-page-hero`, `x-cta`, `x-logo-mark`
- `resources/css/app.css` — design tokens at the top; `.theme-paper` flips a section to the light palette by redefining semantic tokens (`--bg`, `--fg`, `--accent-text`, …). Use semantic tokens in components, never raw palette values.
- `resources/js/app.js` — progressive enhancement only (menus, tabs, reveal, timeline, form validation). Every page must work without JS.
- `app/Http/Middleware/SecurityHeaders.php` — CSP and security headers. The CSP forbids inline scripts (JSON-LD data blocks are fine) and third-party origins; update it if you add an external service.
- `docs/AUDIT.md` — Phase 1 audit, design rationale, open questions

## Content rules

Never invent clients, testimonials, statistics, certifications, partnerships, awards or outcomes. Sections for work, testimonials and insights hide themselves while their content files are empty — leave them empty rather than adding placeholders. Concept work must be marked `'type' => 'concept'`. Copy is British English.

## Enquiry form

Stored in `enquiries`, then emailed to `CONTACT_INBOX` (falls back to `MAIL_FROM_ADDRESS`). A mail failure is logged and never loses the enquiry. Spam protection: CSRF, honeypot field `website`, encrypted render timestamp (`started`, minimum 3 s), rate limit `enquiries` (3/min, 20/day per IP).
