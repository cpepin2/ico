<?php
declare(strict_types=1);
namespace PHPMailer\PHPMailer {
    // Test double: no network calls and no messages are sent.
    class PHPMailer {
        public function __construct(bool $exceptions = true) {}
        public function isSMTP(): void { throw new \RuntimeException('PRIVATE_PROVIDER_RESPONSE'); }
    }
}
namespace {
    if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
    $case = $argv[1] ?? '';
    if ($case === '') {
        foreach (['valid', 'invalid-transport', 'missing-password', 'bad-port', 'bad-encryption', 'bad-address', 'exception'] as $scenario) {
            $process = proc_open([PHP_BINARY, __FILE__, $scenario], [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
            $output = stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
            fclose($pipes[1]); fclose($pipes[2]);
            if (proc_close($process) !== 0 || str_contains($output, 'PRIVATE_PROVIDER_RESPONSE')) {
                throw new \RuntimeException('Mail regression failed: ' . $scenario);
            }
        }
        echo "PASS: Mail config rejects invalid settings; SMTP exceptions stay private. No mail sent.\n";
        exit;
    }
    define('ICOSTL', true);
    define('ROOT_PATH', dirname(__DIR__));
    define('MAIL_TRANSPORT', $case === 'invalid-transport' ? 'smpt' : 'smtp');
    define('MAIL_FROM', $case === 'bad-address' ? "sender@example.com\r\nBcc: test@example.com" : 'sender@example.com');
    define('MAIL_FROM_NAME', 'Test sender');
    define('CONTACT_RECIPIENT', 'recipient@example.com');
    define('SMTP_HOST', 'smtp.example.com');
    define('SMTP_PORT', $case === 'bad-port' ? 0 : 587);
    define('SMTP_ENCRYPTION', $case === 'bad-encryption' ? '' : 'tls');
    define('SMTP_USERNAME', 'fixture');
    define('SMTP_PASSWORD', $case === 'missing-password' ? '' : 'fixture');
    require ROOT_PATH . '/includes/mailer.php';
    $errors = mail_configuration_errors();
    $valid = in_array($case, ['valid', 'exception'], true);
    if (($errors === []) !== $valid) { exit(1); }
    if ($case === 'exception' && send_mail('Fixture', 'Fixture')) { exit(1); }
    if (!$valid && send_mail('Fixture', 'Fixture')) { exit(1); }
}
