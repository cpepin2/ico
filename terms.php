<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$page = [
    'title'       => 'Terms of Use | icoSTL',
    'description' => 'The terms that apply to your use of the icoSTL website.',
    'path'        => '/terms.php',
    'breadcrumbs' => ['Home' => '/', 'Terms' => '/terms.php'],
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'  => 'Legal',
    'headline' => 'Terms of Use',
    'compact'  => true,
]);
?>

    <section class="section">
        <div class="container container--narrow">
            <div class="alert">
                <p class="alert__title">Template — review before publishing</p>
                <p>
                    These terms are a starting template. They have not been reviewed by an attorney.
                    Have counsel review and adapt them before relying on them publicly.
                </p>
            </div>

            <div class="legal u-mt-xl">
                <p class="legal__updated">Last updated: <?= e(date('F Y')) ?></p>

                <h2>Acceptance</h2>
                <p>
                    By using this website you agree to these terms. If you do not agree with them,
                    please do not use the site.
                </p>

                <h2>Informational purpose</h2>
                <p>
                    The content on this website is provided for general information about icoSTL and
                    its services. It does not constitute technical, legal, financial, or compliance
                    advice for your specific situation, and it should not be relied upon as such.
                </p>
                <p>
                    Engaging icoSTL for consulting work is governed by a separate written agreement.
                    Nothing on this website, and no submission of the contact form, creates a client
                    relationship.
                </p>

                <h2>No guarantee of outcome</h2>
                <p>
                    Technology and security work reduces risk; it does not eliminate it. icoSTL does
                    not guarantee that any system will be secure against all threats, and does not
                    certify compliance with any standard or regulation.
                </p>

                <h2>Intellectual property</h2>
                <p>
                    The content, design, and branding on this website are owned by icoSTL unless
                    otherwise noted. You may view and share the content for personal or internal
                    business purposes. You may not republish it commercially without permission.
                </p>

                <h2>Acceptable use</h2>
                <p>You agree not to:</p>
                <ul>
                    <li>Use the site for any unlawful purpose</li>
                    <li>Attempt to gain unauthorised access to the site or its infrastructure</li>
                    <li>Interfere with the operation of the site or its availability to others</li>
                    <li>Submit automated or abusive traffic through the contact form</li>
                </ul>

                <h2>External links</h2>
                <p>
                    This site may link to third-party resources. We do not control those resources and
                    are not responsible for their content or practices.
                </p>

                <h2>Limitation of liability</h2>
                <p>
                    To the fullest extent permitted by law, icoSTL is not liable for any indirect,
                    incidental, or consequential damages arising from your use of this website.
                    The site is provided on an "as is" basis.
                </p>

                <h2>Governing law</h2>
                <p>
                    These terms are governed by the laws of the State of Missouri, without regard to
                    its conflict of law provisions.
                </p>

                <h2>Changes</h2>
                <p>
                    We may revise these terms from time to time. The revision date above reflects the
                    most recent change.
                </p>

                <h2>Contact</h2>
                <p>
                    Questions about these terms can be sent to
                    <a href="mailto:<?= e(CONTACT_PUBLIC_EMAIL) ?>"><?= e(CONTACT_PUBLIC_EMAIL) ?></a>.
                </p>
            </div>
        </div>
    </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
