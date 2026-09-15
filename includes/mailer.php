<?php
declare(strict_types=1);

if (!defined('ICOSTL')) {
    http_response_code(403);
    exit('Direct access is not permitted.');
}

/**
 * Mail abstraction.
 *
 * Transports: 'mail' (PHP built-in), 'smtp' (PHPMailer, if installed) and
 * 'log' (writes to storage/logs/mail.log for local development).
 *
 * Swapping transports is a configuration change only — see README.
 */

/**
 * Strip anything that could break out of a mail header.
 *
 * Header injection works by smuggling CR/LF into a header value, so any value
 * destined for a header passes through here first.
 */
function mail_sanitize_header(string $value): string
{
    return trim(str_replace(["\r", "\n", "\0", "%0a", "%0d"], '', $value));
}

/**
 * Send a plain-text message.
 *
 * @param string      $subject
 * @param string      $body
 * @param string|null $replyTo Validated sender address, or null.
 * @return bool True when the transport accepted the message.
 */
function send_mail(string $subject, string $body, ?string $replyTo = null): bool
{
    if (mail_configuration_errors() !== []) {
        error_log('icoSTL: Mail configuration is invalid. Run the CLI mail readiness check.');
        return false;
    }
    $subject = mail_sanitize_header($subject);

    // Only ever trust a reply-to that still validates after sanitising.
    if ($replyTo !== null) {
        $replyTo = mail_sanitize_header($replyTo);
        if (!filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
            $replyTo = null;
        }
    }

    return match (MAIL_TRANSPORT) {
        'smtp'  => mail_via_smtp($subject, $body, $replyTo),
        'log'   => mail_via_log($subject, $body, $replyTo),
        'mail'  => mail_via_php($subject, $body, $replyTo),
        default => false,
    };
}

/** Configuration-only checks. Return setting names and guidance, never values. */
function mail_configuration_errors(): array
{
    $errors = [];
    if (!in_array(MAIL_TRANSPORT, ['mail', 'smtp', 'log'], true)) {
        $errors[] = 'MAIL_TRANSPORT must be mail, smtp, or log.';
    }
    foreach (['MAIL_FROM', 'CONTACT_RECIPIENT'] as $name) {
        $value = constant($name);
        if (!is_string($value) || preg_match('/[\r\n\x00]/', $value) || !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $errors[] = $name . ' must be a valid email address.';
        }
    }
    if (MAIL_TRANSPORT === 'smtp') {
        if (!is_string(SMTP_HOST) || trim(SMTP_HOST) === '' || preg_match('/[\s;\/]/', SMTP_HOST)) {
            $errors[] = 'SMTP_HOST must be a single hostname or IP address.';
        }
        if (!is_int(SMTP_PORT) || SMTP_PORT < 1 || SMTP_PORT > 65535) {
            $errors[] = 'SMTP_PORT must be an integer between 1 and 65535.';
        }
        if (!in_array(SMTP_ENCRYPTION, ['tls', 'ssl'], true)) {
            $errors[] = 'SMTP_ENCRYPTION must be tls (STARTTLS) or ssl (implicit TLS).';
        }
        if (!is_string(SMTP_USERNAME) || !is_string(SMTP_PASSWORD)
            || ((SMTP_USERNAME === '') !== (SMTP_PASSWORD === ''))) {
            $errors[] = 'Set both SMTP_USERNAME and SMTP_PASSWORD, or neither for an authorized relay.';
        }
        if (!extension_loaded('openssl')) {
            $errors[] = 'The OpenSSL extension is required for SMTP TLS.';
        }
        $autoload = ROOT_PATH . '/vendor/autoload.php';
        if (is_readable($autoload)) {
            require_once $autoload;
        }
        if (!class_exists(\PHPMailer\PHPMailer\PHPMailer::class)) {
            $errors[] = 'Install PHPMailer with Composer before selecting SMTP.';
        }
    }
    return $errors;
}

/**
 * PHP's built-in mail(). Adequate for low volume on standard hosting.
 */
function mail_via_php(string $subject, string $body, ?string $replyTo): bool
{
    $from = mail_sanitize_header(MAIL_FROM);
    $name = mail_sanitize_header(MAIL_FROM_NAME);

    $headers = [
        'From'         => sprintf('%s <%s>', $name, $from),
        'Content-Type' => 'text/plain; charset=UTF-8',
        'MIME-Version' => '1.0',
        'X-Mailer'     => 'icoSTL',
    ];

    if ($replyTo !== null) {
        $headers['Reply-To'] = $replyTo;
    }

    $headerLines = [];
    foreach ($headers as $key => $value) {
        $headerLines[] = $key . ': ' . $value;
    }

    // -f sets the envelope sender, which improves SPF alignment on shared hosts.
    return mail(
        mail_sanitize_header(CONTACT_RECIPIENT),
        $subject,
        $body,
        implode("\r\n", $headerLines),
        '-f' . $from
    );
}

/**
 * SMTP via PHPMailer. Requires `composer require phpmailer/phpmailer`.
 */
function mail_via_smtp(string $subject, string $body, ?string $replyTo): bool
{
    if (mail_configuration_errors() !== []) {
        error_log('icoSTL: SMTP configuration is invalid. Run the CLI mail readiness check.');
        return false;
    }

    $mailer = new \PHPMailer\PHPMailer\PHPMailer(true);

    try {
        $mailer->isSMTP();
        $mailer->Host       = SMTP_HOST;
        $mailer->Port       = SMTP_PORT;
        $mailer->SMTPAuth   = SMTP_USERNAME !== '';
        $mailer->Username   = SMTP_USERNAME;
        $mailer->Password   = SMTP_PASSWORD;
        $mailer->CharSet    = 'UTF-8';
        $mailer->SMTPDebug  = 0;
        $mailer->Timeout    = 15;

        if (SMTP_ENCRYPTION !== '') {
            $mailer->SMTPSecure = SMTP_ENCRYPTION;
        }

        $mailer->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $mailer->addAddress(CONTACT_RECIPIENT);

        if ($replyTo !== null) {
            $mailer->addReplyTo($replyTo);
        }

        $mailer->Subject = $subject;
        $mailer->Body    = $body;

        return $mailer->send();
    } catch (\Throwable $exception) {
        // Provider exceptions can contain server responses and private addresses.
        error_log('icoSTL: SMTP send failed. Check the provider and CLI readiness check.');
        return false;
    }
}

/**
 * Development transport — appends the message to a log file.
 */
function mail_via_log(string $subject, string $body, ?string $replyTo): bool
{
    $logDir = STORAGE_PATH . '/logs';

    if (!is_dir($logDir) && !mkdir($logDir, 0775, true) && !is_dir($logDir)) {
        return false;
    }

    $entry = sprintf(
        "=== %s ===\nTo: %s\nReply-To: %s\nSubject: %s\n\n%s\n\n",
        date('c'),
        CONTACT_RECIPIENT,
        $replyTo ?? '(none)',
        $subject,
        $body
    );

    return file_put_contents($logDir . '/mail.log', $entry, FILE_APPEND | LOCK_EX) !== false;
}
