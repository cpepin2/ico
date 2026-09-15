<?php
declare(strict_types=1);

/**
 * icoSTL — central configuration.
 *
 * Real values belong in includes/config.local.php (git-ignored) or in the
 * environment. Everything here is a safe default or a placeholder; no secret
 * should ever be committed to this file.
 */

if (!defined('ICOSTL')) {
    define('ICOSTL', true);
}

define('ROOT_PATH', dirname(__DIR__));
define('INCLUDES_PATH', ROOT_PATH . '/includes');
define('STORAGE_PATH', ROOT_PATH . '/storage');

/**
 * Read a setting from the environment, falling back to a default.
 */
function env(string $key, string|bool|int|null $default = null): string|bool|int|null
{
    $value = getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }

    return match (strtolower($value)) {
        'true', '(true)'   => true,
        'false', '(false)' => false,
        'null', '(null)'   => null,
        default            => $value,
    };
}

// Local overrides load first so they can define() ahead of the defaults below.
if (is_readable(INCLUDES_PATH . '/config.local.php')) {
    require_once INCLUDES_PATH . '/config.local.php';
}

/**
 * Define a constant only if a local config has not already claimed it.
 */
function config_default(string $name, mixed $value): void
{
    if (!defined($name)) {
        define($name, $value);
    }
}

// ---------------------------------------------------------------------------
// Environment
// ---------------------------------------------------------------------------
config_default('APP_ENV', env('APP_ENV', 'production'));
config_default('APP_DEBUG', (bool) env('APP_DEBUG', false));

// ---------------------------------------------------------------------------
// Site identity
// ---------------------------------------------------------------------------
config_default('SITE_NAME', 'icoSTL');
config_default('SITE_TAGLINE', 'Ready, in case of.');
config_default('SITE_DESCRIPTOR', 'Technology / Security / Automation');

// Replace with the production domain. Used for canonical URLs, Open Graph
// tags, the sitemap and structured data. No trailing slash.
config_default('SITE_URL', env('SITE_URL', 'https://www.icostl.com'));

config_default('SITE_LOCALITY', 'St. Louis');
config_default('SITE_REGION', 'MO');
config_default('SITE_COUNTRY', 'US');

// ---------------------------------------------------------------------------
// Contact
// ---------------------------------------------------------------------------
// Where contact form submissions are delivered.
config_default('CONTACT_RECIPIENT', env('CONTACT_RECIPIENT', 'hello@icostl.com'));
config_default('CONTACT_PUBLIC_EMAIL', env('CONTACT_PUBLIC_EMAIL', 'hello@icostl.com'));

// Envelope sender. Must be a mailbox on your own domain or messages will be
// rejected by SPF/DMARC — never set this to the visitor's address.
config_default('MAIL_FROM', env('MAIL_FROM', 'website@icostl.com'));
config_default('MAIL_FROM_NAME', env('MAIL_FROM_NAME', 'icoSTL Website'));

// ---------------------------------------------------------------------------
// Mail transport
// ---------------------------------------------------------------------------
// 'mail' uses PHP's built-in mail(). 'smtp' requires PHPMailer (see README).
// 'log' writes messages to storage/logs/mail.log instead of sending — useful
// for local development.
config_default('MAIL_TRANSPORT', env('MAIL_TRANSPORT', 'mail'));

// SMTP settings — placeholders only. Set real values in config.local.php.
config_default('SMTP_HOST', env('SMTP_HOST', ''));
config_default('SMTP_PORT', (int) env('SMTP_PORT', 587));
config_default('SMTP_USERNAME', env('SMTP_USERNAME', ''));
config_default('SMTP_PASSWORD', env('SMTP_PASSWORD', ''));
config_default('SMTP_ENCRYPTION', env('SMTP_ENCRYPTION', 'tls'));

// ---------------------------------------------------------------------------
// Form protection
// ---------------------------------------------------------------------------
config_default('FORM_RATE_LIMIT_MAX', 5);        // submissions allowed...
config_default('FORM_RATE_LIMIT_WINDOW', 3600);  // ...per this many seconds
config_default('FORM_MIN_SECONDS', 3);           // reject near-instant submits

// ---------------------------------------------------------------------------
// Error handling
// ---------------------------------------------------------------------------
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}

date_default_timezone_set('America/Chicago');
