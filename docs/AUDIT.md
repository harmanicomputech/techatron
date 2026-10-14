# Phase 1 audit and creative direction

_Prepared 14 October 2026 for the rebuild of techatronagency.com._

## 1. What currently exists

**Repository.** `harmanicomputech/techatron` was empty, so there was no existing stack to keep or migrate.

**Live website.** The current site at https://techatronagency.com/ **could not be inspected directly** from the build environment: the domain did not resolve (DNS `ENOTFOUND`), and the Wayback Machine was also unavailable. The only information available came from search-engine snippets of the homepage. Everything below is therefore unverified until the owner confirms it.

From those snippets, the current homepage:

- Is titled "Techatron Consulting Limited" and positions the company as an IT services firm.
- Lists **managed services** (day-to-day IT support, management and monitoring), **mobile development** (custom apps built around a client's brand), **cloud services** (choosing cloud solutions to fit the business) and **data centre / hosting**. One snippet also lists **cybersecurity**.
- Shows AWS, Microsoft Azure, Google Cloud and Microsoft Defender in what it calls a partner list.
- Gives an office in Ikeja, Lagos, a +234 phone number and a `hello@` address on the techatronagency.com domain. The full address and phone number were not visible.
- Makes claims that **look like theme or template filler**, and have **not** been carried over:
  - a 5/5 rating from 31 reviews
  - "20 years in business"
  - a data centre "first in the USA to meet ANSI/TIA-942 Rated 4" requirements
  - a "London public-safety travel app" showcase

## 2. What has been retained

- **Company name and legal name:** Techatron Consulting Limited.
- **Location:** Lagos, Nigeria.
- **Public email:** `hello@techatronagency.com`, configurable in `.env`.
- **Services from the current site:**
  - Managed IT
  - Mobile apps
  - Cloud and infrastructure, which absorbs data centre and hosting
  - Cybersecurity
- **Cloud platforms named on the current site:** AWS, Azure and Google Cloud. They are listed as platforms Techatron works with, **not** as partnerships.
- **Probable legacy URLs:** these redirect permanently to the new structure (`routes/web.php`).

## 3. What changed and why

| Area | Before (as far as could be seen) | Now |
|---|---|---|
| Positioning | Generic IT services agency | Software engineering and technology consulting partner |
| Services | 4 or 5 IT services | 7 disciplines, each with problem, audience, value, capabilities and deliverables. Custom software, APIs/integration and technology consulting are **proposed additions**, in line with the brief. |
| Proof | Ratings and claims that could not be verified | No unverifiable claims. Credibility comes from clear process, engineering standards and specific language. Work, testimonials and insights appear automatically once real content exists. |
| Conversion | Unknown | Project brief form, "what happens next" on every key page, a service pre-selected from each service page |
| SEO | Unknown | Page titles and descriptions, canonicals, Open Graph, Organization/Service/Breadcrumb JSON-LD, sitemap, environment-aware robots, legacy redirects |

## 4. Creative direction

**Concept: "the system behind the business".** The site presents Techatron as the people who understand how the whole system fits together, not as a list of services. The hero shows an illustrative production architecture with live traffic and a release pipeline. It demonstrates engineering fluency in a way a stock image or a meaningless 3D object cannot.

- **Palette.** The existing brand colours could not be inspected, so this is a proposal.
  - Near-black "ink" as the base.
  - A single signal-green accent (`#34E8AE`) for action and live states.
  - A secondary ion-blue (`#7F97FF`) for data and diagrams.
  - A warm paper tone for light sections, so long pages have rhythm.
  - All colours are tokens in `resources/css/app.css`, so adopting the official brand colours is a one-place change.
- **Typography.** Geist for headlines and text: crisp, engineered, less ubiquitous than Inter. Geist Mono for technical labels, indexes and specs, which gives the "engineering document" feel. Both are self-hosted variable fonts (about 52 KB for Latin), with no third-party font requests.
- **Layout.** Oversized editorial headlines and asymmetric section heads. Compositions change deliberately from section to section:
  - a problem index list
  - a tabbed service explorer
  - a scroll-driven timeline
  - an engineering bento grid
  - a step sequence
- **Motion.** Purposeful and cheap:
  - SVG traffic flowing through the system map
  - a sequenced deployment log
  - reveal on scroll
  - a timeline that fills as you read

  All of it is CSS or SMIL with about 5 KB of JavaScript, and all of it is disabled under `prefers-reduced-motion`.
- **Logo.** The mark in the header (a "T" whose stem ends in a node) is an **interim placeholder** until the official logo is supplied.

## 5. Architecture

- **Stack.** Laravel 13 with Blade, hand-written CSS and vanilla JS via Vite.
  - Laravel gives server-side form validation, mail, rate limiting, CSRF and an easy route to shared hosting. The same stack is used on the team's other projects.
  - No Tailwind or JS framework. Bespoke design system markup stays more readable in plain CSS with tokens, and the whole front end weighs about 10 KB of CSS and 2 KB of JS gzipped.
- **Content.** Copy lives in `resources/content/*.php`, separate from templates. It can be reviewed and edited without touching the design, and could later move to a CMS behind the same `Content` class.
- **Information architecture:**
  - `/`, `/services`, `/services/{7 slugs}`, `/approach`, `/about`, `/contact`, `/privacy`
  - `/work` (honest empty state, `noindex` until populated)
  - `/insights` (404 and hidden from navigation until articles exist)
  - `/sitemap.xml`, `/robots.txt`
- **Security:**
  - CSP and security headers
  - CSRF protection
  - a honeypot field and a minimum-time check on the form
  - per-IP rate limiting
  - strict validation with an allowlist of service values
  - escaped output everywhere
  - Markdown for articles is rendered with raw HTML stripped

## 6. Questions for the owner

These materially affect the outcome:

1. **Logo and brand assets.** Please send the official logo (SVG preferred) and any brand colours or fonts. The palette above is a proposal.
2. **Service catalogue.** Confirm the seven services. Custom software, APIs/integration and technology consulting were added for the repositioning. Is cybersecurity a genuine current offering? Does Techatron still operate or resell data-centre services?
3. **Case studies.** What delivered projects can be published, and with which clients' permission? For each one, the content needs:
   - context, challenge, solution and stack
   - verified outcomes
   - screenshots
   - a live link

   This is the biggest single improvement still available.
4. **Testimonials.** Any genuine client quotes with names, roles and permission?
5. **Contact details.** Full office address, phone, WhatsApp, social profiles, and the inbox that should receive enquiries. Also: is there a response time you are comfortable promising (for example, "within one business day")?
6. **Company facts.** Founding year, team size or leadership bios, and any **real** certifications or vendor partnerships (for example Microsoft or AWS partner status) that can be evidenced.
7. **Technology stack.** Which languages, frameworks and tools does the team actually deliver with? Only these will be shown.
8. **Commercial practices.** Confirm the engagement models on `/approach` and the commitments in the copy (support after launch, documentation and handover). Does the client own the code and IP?
9. **Old URLs.** An export of the old sitemap or Search Console pages, so every valuable URL can be redirected.
10. **Privacy notice.** The notice is written for the Nigeria Data Protection Act 2023 and describes what this site actually does. It should be reviewed by your legal adviser before launch.
