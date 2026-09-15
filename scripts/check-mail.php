<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once dirname(__DIR__) . '/includes/config.php';
require_once INCLUDES_PATH . '/mailer.php';

$errors = mail_configuration_errors();
if (!extension_loaded('mbstring')) {
    $errors[] = 'The mbstring extension is required by the contact form.';
}
if (!is_writable(STORAGE_PATH . '/ratelimit')) {
    $errors[] = 'storage/ratelimit must be writable by the application user.';
}
if (MAIL_TRANSPORT === 'log' && !is_writable(STORAGE_PATH . '/logs')) {
    $errors[] = 'storage/logs must be writable for the log transport.';
}
if (APP_ENV === 'production' && MAIL_TRANSPORT === 'log') {
    $errors[] = 'The log transport does not deliver mail; select mail or smtp in production.';
}
if (APP_ENV === 'production' && APP_DEBUG) {
    $errors[] = 'APP_DEBUG must be false in production.';
}
foreach ($errors as $error) {
    echo 'FAIL: ' . $error . PHP_EOL;
}
echo $errors === [] ? "PASS: Local mail configuration checks.\n" : "FAIL: Mail setup is incomplete.\n";
echo "No connection was opened and no message was sent.\n";
echo "Run as the web application user with the same environment as PHP-FPM/Apache.\n";
echo "Credentials, provider authorization, TLS connectivity, DNS alignment and inbox delivery still need a controlled live test.\n";
exit($errors === [] ? 0 : 1);
