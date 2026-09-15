<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$page = [
    'title'       => 'Privacy Policy | icoSTL',
    'description' => 'How icoSTL collects, uses, and protects information submitted through this website.',
    'path'        => '/privacy.php',
    'breadcrumbs' => ['Home' => '/', 'Privacy' => '/privacy.php'],
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'  => 'Legal',
    'headline' => 'Privacy Policy',
    'compact'  => true,
]);
?>

    <section class="section">
        <div class="container container--narrow">
            <div class="alert">
                <p class="alert__title">Template — review before publishing</p>
                <p>
                    This policy is a starting template reflecting how the website is currently built.
                    It has not been reviewed by an attorney. Have counsel review and adapt it before
                    relying on it publicly.
                </p>
            </div>

            <div class="legal u-mt-xl">
                <p class="legal__updated">Last updated: <?= e(date('F Y')) ?></p>

                <h2>Who we are</h2>
                <p>
                    icoSTL is a technology consulting practice based in St. Louis, Missouri.
                    This policy describes how we handle information collected through this website.
                </p>

                <h2>Information we collect</h2>
                <h3>Information you provide</h3>
                <p>When you submit the contact form, we collect the information you enter:</p>
                <ul>
                    <li>Name</li>
                    <li>Company name</li>
                    <li>Business email address</li>
                    <li>Phone number, if you choose to provide one</li>
                    <li>Approximate number of employees</li>
                    <li>The service you are interested in</li>
                    <li>The message you write</li>
                </ul>
                <p>
                    Please do not submit passwords, credentials, or other sensitive information
                    through this form.
                </p>

                <h3>Information collected automatically</h3>
                <p>
                    This website does not use third-party analytics or advertising trackers.
                    Our hosting provider maintains standard server logs, which may include IP
                    addresses, browser details, and timestamps.
                </p>
                <p>
                    To limit repeat form submissions, we store a one-way cryptographic hash derived
                    from your IP address for a short period. The original address is not retained in
                    that record.
                </p>

                <h3>Cookies</h3>
                <p>
                    We set a single session cookie that supports the contact form's security
                    protections. It contains no marketing or tracking data and expires when you
                    close your browser.
                </p>

                <h2>How we use information</h2>
                <ul>
                    <li>To respond to your enquiry</li>
                    <li>To arrange and conduct a discovery conversation</li>
                    <li>To provide the services you request</li>
                    <li>To protect this website against automated abuse</li>
                </ul>
                <p>We do not sell your information, and we do not share it for advertising purposes.</p>

                <h2>Service providers</h2>
                <p>
                    We rely on third parties for website hosting and email delivery. These providers
                    process information on our behalf and only as needed to deliver their service.
                </p>

                <h2>Retention</h2>
                <p>
                    We keep enquiry correspondence for as long as needed to respond and to maintain
                    ordinary business records. Rate-limiting records are discarded automatically
                    within hours.
                </p>

                <h2>Your choices</h2>
                <p>
                    You may ask us to provide, correct, or delete the information you have sent us.
                    Contact us at <a href="mailto:<?= e(CONTACT_PUBLIC_EMAIL) ?>"><?= e(CONTACT_PUBLIC_EMAIL) ?></a>
                    and we will respond within a reasonable period.
                </p>

                <h2>Security</h2>
                <p>
                    We take reasonable measures to protect information submitted through this site,
                    including transport encryption and restricted access. No method of transmission
                    or storage is completely secure, and we cannot guarantee absolute security.
                </p>

                <h2>Children</h2>
                <p>
                    This website is intended for business use and is not directed at children under 13.
                    We do not knowingly collect information from children.
                </p>

                <h2>Changes</h2>
                <p>
                    We may update this policy from time to time. The revision date above reflects the
                    most recent change.
                </p>

                <h2>Contact</h2>
                <p>
                    Questions about this policy can be sent to
                    <a href="mailto:<?= e(CONTACT_PUBLIC_EMAIL) ?>"><?= e(CONTACT_PUBLIC_EMAIL) ?></a>.
                </p>
            </div>
        </div>
    </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
