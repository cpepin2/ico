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
        default => mail_via_php($subject, $body, $replyTo),
    };
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
    $autoload = ROOT_PATH . '/vendor/autoload.php';

    if (!is_readable($autoload) || SMTP_HOST === '') {
        error_log('icoSTL: SMTP transport selected but PHPMailer or SMTP_HOST is unavailable.');
        return false;
    }

    require_once $autoload;

    if (!class_exists(\PHPMailer\PHPMailer\PHPMailer::class)) {
        error_log('icoSTL: PHPMailer is not installed.');
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
        error_log('icoSTL: SMTP send failed — ' . $exception->getMessage());
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
