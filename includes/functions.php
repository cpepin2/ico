<?php
declare(strict_types=1);

if (!defined('ICOSTL')) {
    http_response_code(403);
    exit('Direct access is not permitted.');
}

/**
 * Escape a string for safe output in HTML.
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Start a session with hardened cookie settings.
 */
function start_secure_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => is_https(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_name('icostl_session');
    session_start();
}

/**
 * Whether the current request arrived over HTTPS.
 */
function is_https(): bool
{
    if (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off') {
        return true;
    }

    // Behind a load balancer or reverse proxy.
    if (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') {
        return true;
    }

    return (int) ($_SERVER['SERVER_PORT'] ?? 80) === 443;
}

/**
 * Send baseline security headers. Called before any output.
 */
function send_security_headers(): void
{
    if (headers_sent()) {
        return;
    }

    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), interest-cohort=()');
    header('X-Frame-Options: SAMEORIGIN');

    // Scoped to what the site actually loads: its own assets plus Google Fonts.
    $csp = implode('; ', [
        "default-src 'self'",
        "base-uri 'self'",
        "script-src 'self'",
        "style-src 'self' https://fonts.googleapis.com",
        "font-src 'self' https://fonts.gstatic.com",
        "img-src 'self' data:",
        "form-action 'self'",
        "frame-ancestors 'self'",
        "object-src 'none'",
    ]);
    header('Content-Security-Policy: ' . $csp);

    // Only advertise HSTS once HTTPS is actually confirmed.
    if (is_https()) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }
}

// ---------------------------------------------------------------------------
// CSRF
// ---------------------------------------------------------------------------

/**
 * Return the session CSRF token, generating one on first use.
 */
function csrf_token(): string
{
    start_secure_session();

    if (empty($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/**
 * Render the hidden CSRF input.
 */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

/**
 * Constant-time comparison of a submitted token against the session token.
 */
function csrf_verify(?string $token): bool
{
    start_secure_session();

    $expected = $_SESSION['csrf_token'] ?? '';
    if (!is_string($expected) || $expected === '' || !is_string($token) || $token === '') {
        return false;
    }

    return hash_equals($expected, $token);
}

// ---------------------------------------------------------------------------
// URLs and assets
// ---------------------------------------------------------------------------

/**
 * Build an absolute URL from a site-root-relative path.
 */
function url(string $path = '/'): string
{
    return rtrim(SITE_URL, '/') . '/' . ltrim($path, '/');
}

/**
 * Asset URL with a cache-busting stamp based on file modification time.
 */
function asset(string $path): string
{
    $relative = '/assets/' . ltrim($path, '/');
    $absolute = ROOT_PATH . $relative;
    $version  = is_file($absolute) ? (string) filemtime($absolute) : '1';

    return $relative . '?v=' . $version;
}

/**
 * The current request path, without query string.
 */
function current_path(): string
{
    $uri = (string) ($_SERVER['REQUEST_URI'] ?? '/');

    return parse_url($uri, PHP_URL_PATH) ?: '/';
}

/**
 * Whether a nav link points at the page currently being viewed.
 */
function is_current(string $path): bool
{
    $current = rtrim(current_path(), '/');
    $target  = rtrim($path, '/');

    if ($target === '' || $target === '/index.php') {
        return $current === '' || $current === '/index.php';
    }

    return $current === $target;
}

// ---------------------------------------------------------------------------
// Partials
// ---------------------------------------------------------------------------

/**
 * Render a partial from includes/partials with the given variables scoped to it.
 *
 * The partial is required inside a closure so that only the caller's data is in
 * scope. Extracting into this function's own scope would let its parameters
 * shadow the data: extract() with EXTR_SKIP refuses to overwrite an existing
 * variable, so a key like 'name' would silently lose to the parameter of the
 * same name and the partial would receive the wrong value.
 */
function partial(string $partial, array $data = []): void
{
    $path = INCLUDES_PATH . '/partials/' . basename($partial) . '.php';

    if (!is_file($path)) {
        if (APP_DEBUG) {
            echo '<!-- missing partial: ' . e($partial) . ' -->';
        }
        return;
    }

    (static function (string $__path, array $__data): void {
        extract($__data, EXTR_SKIP);
        require $__path;
    })($path, $data);
}
