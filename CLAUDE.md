# Techatron Consulting website

Website for Techatron Consulting Limited, a full-service digital agency in Lagos specialising in website, software and mobile app development. Laravel 13, Blade, hand-written CSS, and JS built with Vite. Typefaces: Bricolage Grotesque (variable, 800) for the homepage hero headline only (`--font-hero`), Poppins (400/500/600/700) for all other text, Geist Mono for small technical labels. Motion uses GSAP (ScrollTrigger, SplitText) and Lenis; there is no CSS or UI framework.

## Commands

- `php artisan test` — run the test suite
- `vendor/bin/pint` — format PHP (CI runs `pint --test`)
- `npm run dev` / `npm run build` — assets
- `composer run dev` — local server + Vite

## Layout

- `resources/content/*.php` — all site copy (services, approach, challenges, principles, engagements, platforms, technologies, clients, work, testimonials, insights). Edit copy here, not in templates. Read through `App\Support\Content`. Each service has a `group`: `specialty` (websites, software, mobile — always first), `digital` (campaigns, brand/UI-UX) or `technology`.
- `config/site.php` — company details; contact details come from `.env` and are hidden when blank
- `routes/web.php` — pages, contact form, sitemap/robots, legacy redirects (redirects must stay above `/services/{slug}`)
- `app/Http/Controllers/` — thin controllers; `EnquiryController` + `StoreEnquiryRequest` handle the project brief form
- `resources/views/layouts/app.blade.php` — `<head>`: titles, canonical, Open Graph, Organization JSON-LD. Pages set `@section('title')`, `@section('description')`, optional `@push('schema')`
- `resources/views/components/` — `x-icon`, `x-glyph`, `x-eyebrow`, `x-page-hero`, `x-cta`
- `resources/css/app.css` imports `resources/css/partials/*.css`. `tokens.css` holds the brand colours (blue `#0B34B7`, charcoal `#282828`, both from the logo) and the semantic tokens.
  - Light is the default theme. `[data-theme="dark"]` on `<html>` switches to charcoal, never black.
  - `.section--alt`, `.section--ink` and `.section--brand` re-theme a section by redefining semantic tokens.
  - Components use semantic tokens (`--bg`, `--fg`, `--accent`, `--accent-text`, …), never raw palette values.
- `public/js/theme.js` applies the saved theme before first paint. `resources/js/modules/theme.js` runs the toggle, with a circular View Transition reveal.
- Homepage hero: `resources/views/partials/hero-studio.blade.php` (the "build studio": tabs Website/Mobile app/Software, typing code, self-building previews, status bar) styled in `resources/css/partials/studio.css` and driven by `resources/js/modules/studio.js` (auto-cycles every 7s; stops when a visitor picks a tab; never cycles under reduced motion).
- `resources/js/modules/motion.js` — every animation is opt-in through data attributes:
  - `data-reveal`, `data-split` (do not use on headings that contain gradient text), `data-scrub` and `data-parallax`
  - `data-depth` (hero pointer parallax), `data-tilt`, `data-spotlight`, `data-magnetic` and `data-cursor="Label"`
  - `data-hscroll` (pinned horizontal scroll) and `data-stack` (stacking cards)
- All motion is skipped under `prefers-reduced-motion`, and pages must stay complete without JS: hidden states are set by JS, never by CSS alone.
- Logos: `public/images/logo.png` (light) and `logo-dark.png` (recoloured wordmark). The favicon is the eclipse mark as SVG.
- `app/Http/Middleware/SecurityHeaders.php` — CSP and security headers. The CSP forbids inline scripts (JSON-LD data blocks are fine) and third-party origins; update it if you add an external service.
- `docs/AUDIT.md` — Phase 1 audit, design rationale, open questions

## Content rules

Never invent clients, testimonials, statistics, certifications, partnerships, awards or outcomes. The footer's technology row (`resources/content/technologies.php`) says "Technologies we build with" — do not relabel those companies as partners unless Techatron holds their official partner status. Sections for client logos, work, testimonials and insights hide themselves while their content files are empty — leave them empty rather than adding placeholders. Concept work must be marked `'type' => 'concept'`. Copy is British English.

## Enquiry form

Stored in `enquiries`, then emailed to `CONTACT_INBOX` (falls back to `MAIL_FROM_ADDRESS`). A mail failure is logged and never loses the enquiry. Spam protection: CSRF, honeypot field `website`, encrypted render timestamp (`started`, minimum 3 s), rate limit `enquiries` (3/min, 20/day per IP).
