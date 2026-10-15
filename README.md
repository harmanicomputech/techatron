# Techatron Consulting — website

The website for Techatron Consulting Limited, a full-service digital agency specialising in website, software and mobile app development.

It is built with Laravel 13, Blade and hand-written CSS, bundled with Vite. Text is set in Poppins. Motion uses GSAP (ScrollTrigger, SplitText) and Lenis. The site is light by default, with a charcoal dark mode, and every animation respects `prefers-reduced-motion`.

See [`docs/AUDIT.md`](docs/AUDIT.md) for the audit, the creative direction and the open questions.

## Local development

Requirements: PHP 8.3+, Composer, Node 22+.

```sh
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
composer run dev        # http://localhost:8000 with Vite hot reload
```

Run the checks before pushing:

```sh
php artisan test
vendor/bin/pint --test
npm run build
```

## Editing content

All copy lives in `resources/content/`:

| File | What it controls |
|---|---|
| `services.php` | Services, grouped as `specialty` (websites, software, mobile), `digital` (campaigns, brand/UI-UX) and `technology`. They drive the homepage, `/services`, every service page, navigation and footer. |
| `challenges.php` | The "Recognise any of these?" problem list |
| `approach.php` | Delivery phases (homepage timeline and `/approach`) |
| `principles.php` | Engineering standards |
| `engagements.php` | Ways to engage |
| `platforms.php` | Platforms shown on the homepage. Only list what the team genuinely uses. |
| `work.php` | Case studies. The homepage section and the nav link appear once this file has entries. |
| `technologies.php` | "Technologies we build with" row in the footer (Google, AWS, Java, Microsoft, Meta). Not a partnership claim. |
| `clients.php` | Client logos below the homepage hero (files in `public/images/clients/`). Hidden while empty; six or more logos scroll continuously. |
| `testimonials.php` | Verified client quotes. Hidden while empty. |
| `insights.php` + `insights/{slug}.md` | Articles. The page and nav link appear once this file has entries. |

Company and contact details are set in `.env` (see `.env.example`) and read through `config/site.php`. Leave a value blank to hide it.

**Never publish invented clients, testimonials, statistics or outcomes.**

## Enquiries

The project brief form at `/contact`:

- stores every submission in the `enquiries` table
- emails it to `CONTACT_INBOX` (or `MAIL_FROM_ADDRESS`), with the visitor as the reply-to address

You must configure SMTP (`MAIL_*`) in production. Until then, enquiries are still saved to the database and the `log` mailer writes the notification to `storage/logs`.

## Deployment

**Production `.env`:**

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://techatronagency.com`
- the `MAIL_*` settings
- a MySQL or SQLite database

`robots.txt` allows crawling only when `APP_ENV=production`. Every other environment sends `noindex`.

**Steps:**

```sh
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan config:cache route:cache view:cache
```

**On shared hosting without a terminal:**

1. Run the build locally.
2. Upload the project outside `public_html`.
3. Point the domain's document root at `public/`. If you cannot, copy `public/` into `public_html` and update the paths in `index.php`.
4. Run the migrations once (the only table the site adds is `enquiries`).

**Before launch**, confirm the open questions in `docs/AUDIT.md`. In particular:

- replace the interim logo mark (`resources/views/components/logo-mark.blade.php`, `public/favicon.*`, `public/images/logo.png`)
- add redirects for any other old URLs in `routes/web.php`
