# Production setup

## Search engines

1. Confirm `SITE_URL` in the hosting environment or `includes/config.local.php`
   is the canonical HTTPS origin. Keep the `Sitemap:` URL in `robots.txt` in sync.
2. Deploy and open `/sitemap.xml`: expect HTTP 200 and XML containing the 12
   public page URLs. Apache needs `mod_rewrite` and `.htaccess` overrides;
   nginx needs the exact sitemap location from `nginx.conf.example`.
   `/sitemap.php` is a fallback if hosting cannot map `/sitemap.xml`; in that
   case update the robots sitemap URL and submit that same URL.
3. Add the site in [Google Search Console](https://search.google.com/search-console).
   Domain properties require the DNS record supplied by Google. For an HTTPS
   URL-prefix property, HTML tag verification can use `GOOGLE_SITE_VERIFICATION`:
   set only the supplied tag's `content` value in local config or the environment.
4. Add the site in [Bing Webmaster Tools](https://www.bing.com/webmasters/).
   Import the verified Google property, or use Bing's HTML tag option and set
   `BING_SITE_VERIFICATION` to its `content` value.
5. Check the public homepage source for the expected verification tag, complete
   verification in each account, and submit the canonical `/sitemap.xml` URL.
   Keep the verification settings in place after verification.
6. Use each account's URL inspection tools to check the homepage and assessment
   page. Submission does not guarantee indexing or rankings.

Empty verification settings emit no tags. No account-specific tokens or DNS
records are fabricated. Thank-you and error pages have `noindex` and are excluded
from the sitemap. The thank-you page remains crawlable so crawlers can read that
directive. Sitemap `lastmod` is omitted because deployment timestamps are not
reliable content-modification dates. Add new public pages to `sitemap.php`.

References: [Google ownership verification](https://support.google.com/webmasters/answer/9008080),
[Bing ownership verification](https://www.bing.com/webmasters/help/add-and-verify-site-12184f8b),
[Google sitemap guidance](https://developers.google.com/search/docs/crawling-indexing/sitemaps/build-sitemap).

## Contact form and SMTP

The repository defaults to PHP `mail()`. This is not evidence that the deployed
host delivers messages. Production overrides are deliberately not in Git.

1. For SMTP, run `composer require phpmailer/phpmailer` in your deployment build
   and deploy `vendor/`, or run it on the host. Preserve the generated dependency
   lock file in your deployment process for repeatable installations.
2. Set `MAIL_TRANSPORT=smtp`, `SMTP_HOST`, integer `SMTP_PORT`, `SMTP_USERNAME`,
   `SMTP_PASSWORD`, and `SMTP_ENCRYPTION` in the host's environment or ignored
   `includes/config.local.php`. Use `tls` for STARTTLS (usually port 587) or `ssl`
   for implicit TLS (usually port 465), following the provider's instructions.
   Both credentials can be empty only for a provider-authorized relay.
3. Confirm `MAIL_FROM` is a sender authorized by the provider and
   `CONTACT_RECIPIENT` is the intended inbox. Visitor addresses stay in Reply-To.
4. Enable PHP `mbstring` and `openssl`, maintain a working CA trust store, allow
   outbound access to the provider's SMTP port, and make `storage/ratelimit`
   writable by the PHP application user. Keep `APP_DEBUG=false` in production.
5. Run `php scripts/check-mail.php` as the application user with the same
   environment as the web process. It prints only fixed guidance and setting
   names. It does not print values, open connections, authenticate, or send mail.
   PASS validates local configuration only; PHP `mail()` and relay authorization
   still depend on hosting configuration.
6. With an authorized test submission, confirm receipt, spam placement, sender,
   Reply-To, and provider-required SPF/DKIM/DMARC DNS setup. A successful SMTP
   response means provider acceptance, not confirmed inbox delivery.

The SMTP adapter supports password authentication or an authorized relay. It does
not implement OAuth token acquisition. Microsoft 365 may require OAuth under
tenant policies; do not assume app passwords work or weaken security defaults.
Choose a compatible mail provider/relay, or arrange a separate OAuth integration.
See [Microsoft SMTP AUTH guidance](https://learn.microsoft.com/en-us/exchange/clients-and-mobile-in-exchange-online/authenticated-client-smtp-submission)
and [PHPMailer](https://github.com/PHPMailer/PHPMailer).

Do not paste credentials into issues, commits, screenshots, or diagnostic output.
SMTP failure logs intentionally omit raw exception messages. Apache/nginx block
the CLI scripts, tests, documentation, configuration, storage and vendor paths.

## Local validation

Run `php tests/production.php` for JSON-LD safety, rendered internal links,
canonical URLs, sitemap coverage, and verification-tag checks. Run
`php tests/mail-config.php` for mail configuration and SMTP adapter regressions.
Lint all application PHP files with `php -l`. These checks send no mail.
Apache/nginx configuration must also be validated and exercised on the target
host; the PHP built-in server does not interpret their configuration files.
