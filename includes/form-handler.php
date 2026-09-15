<?php
declare(strict_types=1);

/**
 * Contact form handler.
 *
 * Accepts POST only. Every check here is server-side; the client-side script
 * is a convenience layer and is never relied upon.
 */

require_once __DIR__ . '/config.php';
require_once INCLUDES_PATH . '/functions.php';
require_once INCLUDES_PATH . '/mailer.php';

start_secure_session();

// ---------------------------------------------------------------------------
// Allowed values
// ---------------------------------------------------------------------------

const SERVICE_OPTIONS = [
    'microsoft-365-assessment' => 'Microsoft 365 Assessment',
    'security'                 => 'Security',
    'automation'               => 'Automation',
    'ai-copilot'               => 'AI / Copilot',
    'advisory'                 => 'Technology Advisory',
    'not-sure'                 => 'Not Sure Yet',
];

const EMPLOYEE_OPTIONS = [
    '1-10'   => '1–10',
    '11-50'  => '11–50',
    '51-100' => '51–100',
    '100+'   => 'More than 100',
];

const FIELD_LIMITS = [
    'name'      => 100,
    'company'   => 120,
    'email'     => 180,
    'phone'     => 40,
    'message'   => 4000,
];

// ---------------------------------------------------------------------------
// Rate limiting
// ---------------------------------------------------------------------------

/**
 * A stable, non-identifying key for the requesting client.
 *
 * The IP is hashed so no raw address is written to disk.
 */
function rate_limit_key(): string
{
    $ip = (string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown');

    return hash('sha256', $ip . '|icostl-contact');
}

/**
 * Path to this client's rate limit record, or null if storage is unavailable.
 */
function rate_limit_file(): ?string
{
    $dir = STORAGE_PATH . '/ratelimit';

    if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
        // Fail open rather than block legitimate visitors on a storage fault,
        // but leave a trace so the misconfiguration is visible.
        error_log('icoSTL: rate limit directory is not writable.');
        return null;
    }

    return $dir . '/' . rate_limit_key() . '.json';
}

/**
 * Timestamps of this client's recent deliveries, within the rolling window.
 *
 * @return list<int>
 */
function rate_limit_hits(string $file): array
{
    if (!is_readable($file)) {
        return [];
    }

    $decoded = json_decode((string) file_get_contents($file), true);

    if (!is_array($decoded)) {
        return [];
    }

    $now    = time();
    $window = (int) FORM_RATE_LIMIT_WINDOW;

    return array_values(array_filter(
        $decoded,
        static fn ($ts): bool => is_int($ts) && ($now - $ts) < $window
    ));
}

/**
 * Whether this client has already used its delivery allowance.
 *
 * Read-only: a failed validation must not consume the allowance, or a visitor
 * who makes a few typos would lock themselves out of the form.
 */
function rate_limit_exceeded(): bool
{
    $file = rate_limit_file();

    if ($file === null) {
        return false;
    }

    return count(rate_limit_hits($file)) >= (int) FORM_RATE_LIMIT_MAX;
}

/**
 * Record a delivered message against the allowance.
 *
 * Called only after a message is actually sent, so the limit caps real mail
 * rather than form interactions.
 */
function rate_limit_record(): void
{
    $file = rate_limit_file();

    if ($file === null) {
        return;
    }

    $hits   = rate_limit_hits($file);
    $hits[] = time();

    file_put_contents($file, json_encode($hits), LOCK_EX);

    // Opportunistic cleanup of stale files so the directory cannot grow forever.
    if (random_int(1, 50) === 1) {
        prune_rate_limit_files(dirname($file), (int) FORM_RATE_LIMIT_WINDOW);
    }
}

function prune_rate_limit_files(string $dir, int $window): void
{
    foreach (glob($dir . '/*.json') ?: [] as $path) {
        if (is_file($path) && (time() - filemtime($path)) > ($window * 2)) {
            @unlink($path);
        }
    }
}

// ---------------------------------------------------------------------------
// Flash state
// ---------------------------------------------------------------------------

/**
 * Store errors and previously entered values, then return to the form.
 *
 * Values are kept in the session rather than the query string so nothing
 * user-supplied ends up in a URL, a log, or a referrer header.
 */
function fail_with(array $errors, array $input): never
{
    $_SESSION['contact_flash'] = [
        'errors' => $errors,
        'input'  => $input,
    ];

    header('Location: /contact.php#contact-form', true, 303);
    exit;
}

// ---------------------------------------------------------------------------
// Request handling
// ---------------------------------------------------------------------------

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: /contact.php', true, 303);
    exit;
}

/**
 * Read a POST field as a trimmed string, with control characters removed.
 */
function post_field(string $key, int $maxLength): string
{
    $value = $_POST[$key] ?? '';

    if (!is_string($value)) {
        return '';
    }

    // Strip control characters except tab and newline.
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value) ?? '';
    $value = trim($value);

    return mb_substr($value, 0, $maxLength, 'UTF-8');
}

$input = [
    'name'      => post_field('name', FIELD_LIMITS['name']),
    'company'   => post_field('company', FIELD_LIMITS['company']),
    'email'     => post_field('email', FIELD_LIMITS['email']),
    'phone'     => post_field('phone', FIELD_LIMITS['phone']),
    'employees' => post_field('employees', 20),
    'service'   => post_field('service', 40),
    'message'   => post_field('message', FIELD_LIMITS['message']),
];

$errors = [];

// --- CSRF -------------------------------------------------------------------

if (!csrf_verify($_POST['csrf_token'] ?? null)) {
    fail_with(
        ['form' => 'Your session expired before the form was submitted. Please review your details and try again.'],
        $input
    );
}

// --- Honeypot ----------------------------------------------------------------
// A real visitor never sees this field. Anything in it is automated, so accept
// the request silently rather than telling the bot it was caught.

if (trim((string) ($_POST['website'] ?? '')) !== '') {
    header('Location: /thank-you.php', true, 303);
    exit;
}

// --- Timing ------------------------------------------------------------------

$startedAt = (int) ($_POST['form_started'] ?? 0);
if ($startedAt > 0 && (time() - $startedAt) < (int) FORM_MIN_SECONDS) {
    header('Location: /thank-you.php', true, 303);
    exit;
}

// --- Rate limit ---------------------------------------------------------------

if (rate_limit_exceeded()) {
    fail_with(
        ['form' => 'We have received several messages from this connection recently. Please try again later, or email us directly.'],
        $input
    );
}

// --- Field validation ----------------------------------------------------------

if ($input['name'] === '') {
    $errors['name'] = 'Please enter your name.';
} elseif (mb_strlen($input['name']) < 2) {
    $errors['name'] = 'Please enter your full name.';
}

if ($input['company'] === '') {
    $errors['company'] = 'Please enter your company name.';
}

if ($input['email'] === '') {
    $errors['email'] = 'Please enter your business email address.';
} elseif (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email address.';
}

if ($input['phone'] !== '' && !preg_match('/^[0-9+().\- ]{7,40}$/', $input['phone'])) {
    $errors['phone'] = 'Please enter a valid phone number, or leave this blank.';
}

if (!array_key_exists($input['employees'], EMPLOYEE_OPTIONS)) {
    $errors['employees'] = 'Please select how many people work at your company.';
}

if (!array_key_exists($input['service'], SERVICE_OPTIONS)) {
    $errors['service'] = 'Please select what you are interested in.';
}

if ($input['message'] === '') {
    $errors['message'] = 'Please tell us a little about what is going on.';
} elseif (mb_strlen($input['message']) < 20) {
    $errors['message'] = 'Please add a little more detail so we can respond usefully.';
}

// --- Obvious spam ----------------------------------------------------------------

$spamSignals = ['[url=', '[/url]', '<a href', 'bit.ly/', 'viagra', 'casino', 'crypto giveaway'];
$haystack    = mb_strtolower($input['message'] . ' ' . $input['name'] . ' ' . $input['company']);

foreach ($spamSignals as $signal) {
    if (str_contains($haystack, $signal)) {
        // Treat as accepted so the sender gains no feedback.
        header('Location: /thank-you.php', true, 303);
        exit;
    }
}

if ($errors !== []) {
    fail_with($errors, $input);
}

// ---------------------------------------------------------------------------
// Compose and send
// ---------------------------------------------------------------------------

$subject = sprintf('Website enquiry — %s (%s)', $input['company'], SERVICE_OPTIONS[$input['service']]);

$body = implode("\n", [
    'New enquiry from the icoSTL website.',
    '',
    'Name:      ' . $input['name'],
    'Company:   ' . $input['company'],
    'Email:     ' . $input['email'],
    'Phone:     ' . ($input['phone'] !== '' ? $input['phone'] : '(not provided)'),
    'Employees: ' . EMPLOYEE_OPTIONS[$input['employees']],
    'Interest:  ' . SERVICE_OPTIONS[$input['service']],
    '',
    '--- Message ---',
    '',
    $input['message'],
    '',
    '---',
    'Submitted: ' . date('c'),
]);

$sent = send_mail($subject, $body, $input['email']);

if (!$sent) {
    error_log('icoSTL: contact form delivery failed for ' . $input['email']);

    fail_with(
        ['form' => 'We could not send your message just now. Please try again, or email us directly at ' . CONTACT_PUBLIC_EMAIL . '.'],
        $input
    );
}

// Count this delivery against the allowance now that mail has actually gone out.
rate_limit_record();

// Rotate the token so the same submission cannot be replayed.
unset($_SESSION['csrf_token'], $_SESSION['contact_flash']);

header('Location: /thank-you.php', true, 303);
exit;
