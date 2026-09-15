<?php
declare(strict_types=1);

/**
 * Local configuration template.
 *
 * Copy to config.local.php and fill in real values:
 *
 *     cp includes/config.local.example.php includes/config.local.php
 *
 * config.local.php is git-ignored. Never commit real credentials.
 *
 * Every constant here is optional — anything left out falls back to the
 * default in config.php.
 */

// --- Environment ---------------------------------------------------------
// define('APP_ENV', 'production');
// define('APP_DEBUG', false);

// --- Site ----------------------------------------------------------------
// Production domain, no trailing slash. Used for canonical URLs and OG tags.
// define('SITE_URL', 'https://www.icostl.com');

// Ownership verification: paste only the content value, not the entire tag.
// define('GOOGLE_SITE_VERIFICATION', '');
// define('BING_SITE_VERIFICATION', '');

// --- Contact -------------------------------------------------------------
// Where form submissions are delivered.
// define('CONTACT_RECIPIENT', 'charlie@icostl.com');

// Shown publicly on the site.
// define('CONTACT_PUBLIC_EMAIL', 'hello@icostl.com');

// Envelope sender — must be a mailbox on your own domain for SPF/DMARC.
// define('MAIL_FROM', 'website@icostl.com');
// define('MAIL_FROM_NAME', 'icoSTL Website');

// --- Mail transport ------------------------------------------------------
// 'mail' — PHP built-in (works out of the box on most shared hosting)
// 'smtp' — PHPMailer over SMTP (recommended for deliverability)
// 'log'  — writes to storage/logs/mail.log, for local development
// define('MAIL_TRANSPORT', 'smtp');

// --- SMTP ----------------------------------------------------------------
// Use your provider's documented SMTP endpoint and credentials.
// This adapter supports username/password or an authorized relay, not OAuth.
// Microsoft 365 tenant policies may require OAuth; an app password is not a
// general workaround. See docs/production-setup.md before choosing a provider.
//
// define('SMTP_HOST', 'smtp.example.com');
// define('SMTP_PORT', 587);
// define('SMTP_USERNAME', 'website@icostl.com');
// define('SMTP_PASSWORD', 'REPLACE_WITH_PROVIDER_CREDENTIAL');
// define('SMTP_ENCRYPTION', 'tls');

// Hostinger example:
// define('SMTP_HOST', 'smtp.hostinger.com');
// define('SMTP_PORT', 465);
// define('SMTP_ENCRYPTION', 'ssl');

// --- Form protection -----------------------------------------------------
// define('FORM_RATE_LIMIT_MAX', 5);
// define('FORM_RATE_LIMIT_WINDOW', 3600);
