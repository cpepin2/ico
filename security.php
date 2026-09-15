<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$page = [
    'title'       => 'Microsoft 365 Security Consulting | icoSTL',
    'description' => 'Strengthen Microsoft 365 identity, access, email, sharing, auditing, and operating procedures with practical security consulting from icoSTL.',
    'path'        => '/security.php',
    'breadcrumbs' => ['Home' => '/', 'Services' => '/services.php', 'Security' => '/security.php'],
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'  => 'In case of risk.',
    'headline' => "Know what's exposed before it becomes urgent.",
    'body'     => 'Security problems are often less dramatic than people expect—and more preventable.',
    'ctas'     => [
        ['label' => 'Start with an Assessment', 'href' => '/microsoft-365-assessment.php', 'style' => 'primary'],
        ['label' => 'Talk With icoSTL', 'href' => '/contact.php', 'style' => 'ghost'],
    ],
]);

partial('service-body', [
    'intro_eyebrow'  => 'Practical security.',
    'intro_headline' => 'Strengthen what the business actually relies on.',
    'intro' => [
        'icoSTL helps organizations strengthen Microsoft 365 identity, access, email, sharing, auditing, and operating procedures.',
        'Most of what we find is not exotic. It is an administrator account that never had MFA enforced, a departed employee whose access was never fully removed, a SharePoint site shared more widely than anyone intended, or an audit setting that was never turned on.',
        'These are fixable. They are considerably easier to fix before they matter.',
    ],
    'areas_label'    => 'Primary areas',
    'areas_headline' => 'Where we focus.',
    'areas' => [
        'Identity',
        'MFA',
        'Administrative access',
        'Conditional Access',
        'Email security',
        'SPF / DKIM / DMARC',
        'Guest access',
        'External sharing',
        'Audit configuration',
        'Employee lifecycle controls',
        'Security operating procedures',
    ],
    'approach_headline' => 'How security work runs.',
    'approach' => [
        ['Review first.', 'We establish what is actually configured before recommending any change.'],
        ['Prioritize by impact.', 'Findings are ordered by what would genuinely affect the business, not by severity labels alone.'],
        ['Change deliberately.', 'Agreed changes are made in a planned sequence, with you informed at each step.'],
    ],
]);

echo '<section class="section section--surface"><div class="container container--narrow"><p class="note">'
    . 'icoSTL provides security consulting and configuration review. We do not perform penetration testing, '
    . 'issue compliance certifications, or provide 24/7 monitoring.'
    . '</p></div></section>';

partial('cta-section', [
    'eyebrow'  => 'Be ready before you need to be.',
    'headline' => 'Start with what you actually have.',
    'body'     => 'A structured review of your Microsoft 365 environment is the most direct way to find out where you stand.',
    'ctas'     => [
        ['label' => 'Start with an Assessment', 'href' => '/microsoft-365-assessment.php', 'style' => 'primary'],
        ['label' => 'Talk With icoSTL', 'href' => '/contact.php', 'style' => 'ghost'],
    ],
]);

require __DIR__ . '/includes/footer.php';
