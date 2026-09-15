# icoSTL — Production Website

Practical technology consulting for businesses that want to be ready for what
comes next.

Built as a modular PHP site with no framework, no build step, and no database.
It runs on any standard PHP 8.1+ host.

---

## Table of contents

- [Requirements](#requirements)
- [Project structure](#project-structure)
- [Local development](#local-development)
- [Configuring the contact form](#configuring-the-contact-form)
- [Installing PHPMailer for SMTP](#installing-phpmailer-for-smtp)
- [Replacing brand assets](#replacing-brand-assets)
- [Adding photography](#adding-photography)
- [Adding insights articles](#adding-insights-articles)
- [Deployment](#deployment)
- [Production security checklist](#production-security-checklist)
- [Design system reference](#design-system-reference)
- [Accessibility notes](#accessibility-notes)

---

## Requirements

| Requirement | Notes |
|---|---|
| PHP 8.1 or newer | Uses `match`, `never` return type, readonly-safe patterns |
| `mbstring` extension | Multibyte-safe input truncation |
| Apache with `mod_rewrite` | Or nginx — see `nginx.conf.example` |
| Writable `storage/` directory | Rate limiting and optional mail logging |

No database. No Composer dependencies unless you opt into PHPMailer.

---

## Project structure

```
/
├── index.php                      Home
├── services.php                   Services overview
├── microsoft-365-assessment.php   Flagship assessment offer
├── security.php                   Security consulting
├── automation.php                 Automation consulting
├── ai-readiness.php               AI & Copilot readiness
├── advisory.php                   Technology advisory
├── about.php                      About
├── insights.php                   Insights landing
├── contact.php                    Contact form
├── privacy.php / terms.php        Legal (templates — see note below)
├── thank-you.php                  Post-submission confirmation
├── 404.php                        Not found
├── sitemap.php                    XML sitemap (served at /sitemap.xml)
├── robots.txt
├── .htaccess                      Apache config
├── nginx.conf.example             nginx equivalent
│
├── includes/
│   ├── config.php                 Defaults and constants (safe to commit)
│   ├── config.local.example.php   Template for real values
│   ├── config.local.php           Your real values — GIT-IGNORED
│   ├── functions.php              Escaping, CSRF, URLs, partial loader
│   ├── seo.php                    Meta tags and JSON-LD schema
│   ├── header.php / nav.php / footer.php
│   ├── mailer.php                 Transport abstraction
│   ├── form-handler.php           Contact form POST endpoint
│   └── partials/
│       ├── page-hero.php          Page hero
│       ├── section-heading.php    Eyebrow + headline + accent rule
│       ├── service-card.php       "In case of…" card
│       ├── service-body.php       Shared body for the four service pages
│       ├── capability-list.php    Two-column capability listing
│       ├── pillars.php            The four brand pillars
│       ├── cta-section.php        Closing call to action
│       ├── faq.php                Accessible <details> FAQ
│       └── icon.php               Inline outline icons
│
├── assets/
│   ├── css/   reset, variables, base, layout, components, pages, responsive
│   ├── js/    main.js (nav), forms.js (contact enhancements)
│   ├── images/  og-default.png
│   ├── icons/
│   └── logos/   favicon.svg, logo.svg, logo-reverse.svg, mark.svg,
│                apple-touch-icon.png
│
└── storage/       Runtime state — git-ignored, must be writable
    ├── ratelimit/
    └── logs/
```

### How a page is composed

Each page sets a `$page` array, requires the header, renders content through
partials, then requires the footer:

```php
<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';

$page = [
    'title'       => 'Page Title | icoSTL',
    'description' => 'Unique meta description.',
    'path'        => '/example.php',
    'breadcrumbs' => ['Home' => '/', 'Example' => '/example.php'],
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'  => 'Eyebrow text.',
    'headline' => 'Headline.',
]);

require __DIR__ . '/includes/footer.php';
```

Page chrome is never duplicated — change the header once and every page follows.

---

## Local development

PHP's built-in server is enough:

```bash
php -S localhost:8000
```

Then open <http://localhost:8000>.

For a closer match to production (custom 404, `/sitemap.xml`), use a router:

```bash
cat > router.php <<'PHP'
<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($path === '/')            { require __DIR__ . '/index.php'; return true; }
if ($path === '/sitemap.xml') { require __DIR__ . '/sitemap.php'; return true; }
if (is_file(__DIR__ . $path)) { return false; }
http_response_code(404);
require __DIR__ . '/404.php';
return true;
PHP

php -S localhost:8000 router.php
```

For local work, set the log mail transport so nothing is actually sent:

```php
// includes/config.local.php
define('MAIL_TRANSPORT', 'log');   // writes to storage/logs/mail.log
define('APP_DEBUG', true);
define('SITE_URL', 'http://localhost:8000');
```

Syntax-check everything before committing:

```bash
find . -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l
```

---

## Configuring the contact form

**Never commit real credentials.** `includes/config.local.php` is git-ignored.

```bash
cp includes/config.local.example.php includes/config.local.php
```

Then set, at minimum:

```php
define('SITE_URL',           'https://www.icostl.com');  // no trailing slash
define('CONTACT_RECIPIENT',  'charlie@icostl.com');      // where mail is delivered
define('CONTACT_PUBLIC_EMAIL','hello@icostl.com');       // shown on the site
define('MAIL_FROM',          'website@icostl.com');      // envelope sender
```

`MAIL_FROM` **must** be a mailbox on your own domain. Setting it to the
visitor's address breaks SPF/DMARC and gets your mail rejected. The visitor's
address is attached as `Reply-To` instead, so replying still reaches them.

Values can also come from environment variables (`SITE_URL`,
`CONTACT_RECIPIENT`, `SMTP_HOST`, …), which is often cleaner on hosts that
expose an env editor.

### Transports

| `MAIL_TRANSPORT` | Behaviour |
|---|---|
| `mail` (default) | PHP's built-in `mail()`. Works on most shared hosting. |
| `smtp` | PHPMailer over SMTP. Best deliverability. |
| `log` | Appends to `storage/logs/mail.log`. Development only. |

### Built-in protections

The handler enforces all of the following server-side:

- POST-only; GET redirects back to the form
- CSRF token, compared with `hash_equals`, rotated after a successful send
- Honeypot field (`website`) — silently accepted so bots get no feedback
- Timing check — submissions faster than `FORM_MIN_SECONDS` are treated as bots
- Rate limit — 5 **delivered** messages per IP per hour by default
- Allow-list validation on both `<select>` fields
- Length caps and control-character stripping on every field
- CR/LF stripped from anything reaching a mail header (no header injection)
- Errors and previous input round-trip through the session, never the URL

Failed validation does **not** consume the rate-limit allowance, so a visitor
correcting typos cannot lock themselves out.

The rate-limit store keys on a SHA-256 hash of the IP — no raw address is
written to disk.

---

## Installing PHPMailer for SMTP

```bash
composer require phpmailer/phpmailer
```

Then in `includes/config.local.php`:

```php
define('MAIL_TRANSPORT',  'smtp');
define('SMTP_HOST',       'smtp.example.com');
define('SMTP_PORT',       587);
define('SMTP_USERNAME',   'website@icostl.com');
define('SMTP_PASSWORD',   'your-provider-credential');
define('SMTP_ENCRYPTION', 'tls');
```

`mailer.php` degrades safely: if `vendor/autoload.php` or `SMTP_HOST` is
missing it logs the problem and reports failure rather than throwing.

This adapter supports username/password authentication or an authorized relay. Microsoft 365 tenant policies may require OAuth, which needs a separate integration; app passwords are not a general workaround. See [production setup](docs/production-setup.md) for SMTP readiness checks and search-engine verification steps.

---

## Replacing brand assets

Everything in `assets/logos/` is a **placeholder** built to the correct
proportions and colours. Swap in the production files using the same filenames
and no code changes are needed.

| File | Used for | Replace with |
|---|---|---|
| `favicon.svg` | Browser tab icon | Production favicon SVG |
| `apple-touch-icon.png` | iOS home screen (180×180) | Production PNG, 180×180 |
| `logo.svg` | Wordmark, light backgrounds | Production SVG, **text converted to outlines** |
| `logo-reverse.svg` | Wordmark, dark backgrounds | Production SVG, outlined |
| `mark.svg` | Standalone "i" mark | Production SVG |
| `assets/images/og-default.png` | Social share card, sitewide (1200×630) | Optional — already branded |
| `assets/images/og-assessment.png` | Social share card, assessment page | Optional — already branded |

The two OG cards are real renders in Assistant with the wordmark, tagline and
Signal Orange furniture — not placeholders. Any page can override the sitewide
card by setting `'og_image' => '/assets/images/your-card.png'` in its `$page`
array, as `microsoft-365-assessment.php` does.

**The header and footer wordmark is rendered in CSS, not from an SVG file**
(`.wordmark` in `components.css`) — live text, so it stays crisp at any size and
is readable by screen readers. It uses Assistant 800 plus the Signal Orange
square. If you would rather use the production SVG there, replace the markup in
`includes/nav.php` and `includes/footer.php` with an `<img>` pointing at
`logo-reverse.svg`.

The logo has not been redrawn or reinterpreted — the placeholders use the real
wordmark text in the brand typeface with the orange square accent.

---

## Adding photography

The site currently ships **without photography** and is entirely typographic.
This is deliberate: no stock imagery was invented, and the brand kit's
photography direction (monochrome, real environments, St. Louis architecture)
needs real assets.

To add a hero image, drop the file in `assets/images/` and add to
`assets/css/pages.css`:

```css
.page-home .hero--dark {
    background-image:
        linear-gradient(90deg, rgba(0,0,0,.95) 40%, rgba(0,0,0,.55) 100%),
        url("/assets/images/hero-arch.jpg");
    background-size: cover;
    background-position: center right;
}
```

The gradient keeps headline contrast above 4.5:1 over the image — keep it.

Follow the brand kit direction: monochrome or near-monochrome, real business
environments, systems and infrastructure, St. Louis context. Signal Orange only
as a restrained accent. Serve images at 2× the display size, compressed, and add
`loading="lazy"` to anything below the fold.

---

## Adding insights articles

`insights.php` renders an empty state until the `$insights` array has entries.
No placeholder articles were invented. To publish, add entries:

```php
$insights = [
    [
        'title'   => 'What actually happens when an employee leaves',
        'summary' => 'Offboarding is a process problem before it is a technical one.',
        'topic'   => 'Security',
        'date'    => '2026-10-02',
        'href'    => '/insights/offboarding.php',
    ],
];
```

The card grid and empty state switch automatically. For more than a handful of
articles, move the array into its own file or a flat-file loader.

---

## Deployment

### Hostinger (Git — recommended)

No credentials leave GitHub.

1. hPanel → **Websites → Advanced → GIT**
2. Repository: `https://github.com/cpepin2/ico`
3. Branch: your deploy branch. Directory: `public_html`
4. Private repo? Add the deploy key Hostinger generates to GitHub →
   **Settings → Deploy keys** (read-only is enough)
5. **Deploy**, or copy the auto-deploy webhook URL into GitHub →
   **Settings → Webhooks** so pushes deploy themselves

Then, once on the server:

```bash
cp includes/config.local.example.php includes/config.local.php
# edit with real values
chmod -R 755 storage
```

`config.local.php` is git-ignored, so it survives deploys and is never
overwritten.

> Because Git deploy puts the repo root at your web root, `.htaccess` blocks
> direct access to `/includes/`, `/storage/`, `/vendor/`, `.git`, and
> `config.local.php`. Verify after deploying — see the checklist below.

### Manual upload (SFTP)

Upload everything except `.git/`, then create `config.local.php` and make
`storage/` writable. Do not upload `config.local.php` from your machine if it
contains development settings.

### nginx

Use `nginx.conf.example` as a starting point. Adjust `server_name`, `root`, and
the PHP-FPM socket path.

---

## Production security checklist

Before going live:

- [ ] `config.local.php` exists on the server with real values, and is **not** in git
- [ ] `APP_DEBUG` is `false` (the default) in production
- [ ] HTTPS certificate installed and working
- [ ] Uncomment the HTTPS redirect block in `.htaccess`
- [ ] Uncomment the `Strict-Transport-Security` header in `.htaccess` — **only after** HTTPS is confirmed working, since HSTS is hard to undo
- [ ] Pick a canonical host (`www` or apex) and uncomment that redirect
- [ ] `storage/` is writable by the web server but **not** web-accessible
- [ ] Confirm `https://yourdomain.com/includes/config.php` returns 403/404
- [ ] Confirm `https://yourdomain.com/storage/logs/mail.log` returns 403/404
- [ ] Confirm `https://yourdomain.com/.git/config` returns 403/404
- [ ] Send a real test submission and confirm it arrives
- [ ] Check the test mail did not land in spam — configure SPF, DKIM and DMARC for the sending domain
- [ ] Update `SITE_URL` and the `Sitemap:` line in `robots.txt` to the live domain
- [ ] Submit `/sitemap.xml` to Google Search Console
- [ ] Have counsel review `privacy.php` and `terms.php`, then remove the template warning banners

### Verifying the include protection

```bash
curl -o /dev/null -w "%{http_code}\n" https://yourdomain.com/includes/config.php
# expect 403 or 404 — a 200 means mod_rewrite is not active
```

---

## Design system reference

All tokens live in `assets/css/variables.css`. Change them there, never inline.

```css
--color-black:  #000000;   /* ~70% — primary text, headings, dark sections */
--color-white:  #ffffff;   /* ~25% — backgrounds, space, clarity            */
--color-orange: #ff5a36;   /* ~5%  — Signal Orange: CTAs, rules, accents    */
--color-border: #e0e0e0;   /* 1px dividers                                  */
```

Spacing uses a fixed scale — `--space-xs` 4px through `--space-2xl` 80px. Avoid
arbitrary values; if something needs an in-between size, the layout is usually
the thing to fix.

Type is **Assistant** at three weights: 800 headlines, 600 subheads/labels/buttons,
400 body. Loaded from Google Fonts with `preconnect` and `display=swap`.

> **Optional:** self-hosting Assistant removes a third-party request, improves
> LCP slightly, and lets you drop `fonts.googleapis.com` from the CSP. Download
> the WOFF2 files, put them in `assets/fonts/`, add `@font-face` rules with
> `font-display: swap`, and remove the Google Fonts links from `header.php`.

### Signal Orange and contrast

Signal Orange on white is **3.10:1** — fine for rules, borders and icons (WCAG
requires 3:1 for non-text UI) but below the 4.5:1 needed for body text. So:

- `--color-orange` (`#ff5a36`) — fills, rules, borders, and text **on black**
- `--color-orange-text` (`#cc3616`) — orange **text on light backgrounds**

Primary buttons use **white text on Signal Orange**, as specified in the brand
kit. That pairing measures 3.10:1 — see the accessibility note below.

---

## Accessibility notes

Built to WCAG 2.2 AA:

- Semantic landmarks, one `<h1>` per page, no skipped heading levels
- Skip link to `#main` as the first tab stop
- 3px Signal Orange focus ring on every interactive element, with a light halo on dark surfaces
- Mobile nav toggles with `aria-expanded`, closes on Escape, returns focus to the trigger
- Form errors use `aria-invalid`, `aria-describedby`, and a focusable `role="alert"` summary linking to each field
- Every interactive target is at least 44px tall
- FAQ uses native `<details>` and works with JavaScript disabled
- `prefers-reduced-motion` honoured globally
- No information conveyed by colour alone
- All colour pairs verified at 4.5:1 for text and 3:1 for UI, with one
  documented exception below

### Known exception: primary button text

Primary buttons use **white text on Signal Orange**, matching the approved brand
kit. That combination measures **3.10:1**, below the 4.5:1 WCAG AA threshold for
text at this size.

This is a deliberate brand decision, recorded here so it is not mistaken for an
oversight and silently "fixed". Everything else on the site meets AA.

To trade the kit's appearance for full AA compliance, set `color` to
`var(--color-black)` on `.btn--primary` and `.btn--primary:hover` in
`assets/css/components.css` — black on the same orange measures 6.77:1. The
orange itself does not change either way.

Note that this applies only to button *fills*. Orange **text** on light
backgrounds still uses the darker `--color-orange-text` (`#cc3616`), and the
skip link and selection highlight still use black on orange — those are
accessibility affordances rather than brand surfaces, so they were left at
their compliant values.

---

## Content constraints

This site makes **no** claims about certifications, partner status, client
counts, testimonials, case studies, awards, or staff size, because none were
provided. Credibility comes from clear scope, transparent pricing, a documented
process, and real founder experience.

If you add claims later, make sure they are accurate and substantiated.

## Production verification

See [production setup](docs/production-setup.md) for Google/Bing verification, sitemap checks, SMTP requirements, and safe CLI validation.
