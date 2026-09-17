<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$page = [
    'title'       => 'Services | Technology, Security & Automation | icoSTL',
    'description' => 'Microsoft 365 security, technology advisory, business process automation, and Copilot readiness for small and growing businesses in St. Louis and remotely.',
    'path'        => '/services.php',
    'breadcrumbs' => ['Home' => '/', 'Services' => '/services.php'],
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'  => 'Practical technology. Real solutions.',
    'headline' => 'Prepare. Protect. Move forward.',
    'body'     => 'icoSTL secures Microsoft 365, tightens access controls, automates repetitive work, and turns scattered technology decisions into a clear plan.',
    'ctas'     => [
        ['label' => 'Start With an Assessment', 'href' => '/microsoft-365-assessment.php', 'style' => 'primary'],
        ['label' => 'Get in Touch', 'href' => '/contact.php', 'style' => 'ghost'],
    ],
]);

$capabilities = [
    [
        'label' => 'Secure',
        'case'  => 'In case of risk.',
        'href'  => '/security.php',
        'items' => [
            'Microsoft 365 security',
            'Identity and authentication',
            'MFA',
            'Administrative access',
            'Conditional Access',
            'Email security',
            'SPF, DKIM, DMARC',
            'External sharing',
            'Guest access',
            'Audit configuration',
            'Security procedures',
            'Onboarding and offboarding controls',
        ],
    ],
    [
        'label' => 'Advise',
        'case'  => 'In case of change.',
        'href'  => '/advisory.php',
        'items' => [
            'Technology strategy',
            'Vendor evaluation',
            'Software selection',
            'Systems planning',
            'Technology roadmaps',
            'Security prioritization',
            'Technology budgeting',
            'Fractional technology leadership',
        ],
    ],
    [
        'label' => 'Automate',
        'case'  => 'In case of growth.',
        'href'  => '/automation.php',
        'items' => [
            'Microsoft Power Automate',
            'Zoho automation',
            'CRM workflows',
            'Forms and approvals',
            'Notifications',
            'Employee workflows',
            'Reporting',
            'Integrations',
            'AI-assisted workflows',
        ],
    ],
    [
        'label' => 'Prepare',
        'case'  => 'In case of opportunity.',
        'href'  => '/ai-readiness.php',
        'items' => [
            'Microsoft 365 Copilot readiness',
            'AI governance',
            'Permission review',
            'Oversharing remediation',
            'Data-access review',
            'AI procedures',
            'Deployment planning',
            'Adoption strategy',
        ],
    ],
];
?>

    <section class="section">
        <div class="container">
<?php foreach ($capabilities as $capability): ?>
            <div class="capability">
                <div class="capability__header">
                    <h2 class="capability__label"><?= e($capability['label']) ?></h2>
                    <p class="capability__case"><?= e($capability['case']) ?></p>
                    <span class="accent-rule" aria-hidden="true"></span>
                    <a class="link-arrow" href="<?= e($capability['href']) ?>">
                        Explore <?= e($capability['label']) ?><span class="link-arrow__glyph" aria-hidden="true">&rarr;</span>
                    </a>
                </div>
                <ul class="capability__list">
<?php foreach ($capability['items'] as $item): ?>
                    <li><?= e($item) ?></li>
<?php endforeach; ?>
                </ul>
            </div>
<?php endforeach; ?>
        </div>
    </section>

    <!-- Process: moved here from the homepage, which now leads with what icoSTL does -->
    <section class="section section--dark">
        <div class="container">
            <?php partial('section-heading', [
                'eyebrow'  => 'How engagements run',
                'headline' => 'A straightforward consulting process.',
            ]); ?>

            <div class="process">
<?php
$steps = [
    ['01', 'Understand', 'We start with the business problem—not the software.'],
    ['02', 'Assess', 'We review the relevant systems, processes, risks, and constraints.'],
    ['03', 'Prioritize', 'You get clear recommendations based on business impact.'],
    ['04', 'Improve', 'icoSTL can implement the agreed changes or work alongside your existing provider.'],
    ['05', 'Stay Ready', 'icoSTL Stewardship helps prevent important controls and processes from quietly drifting over time.'],
];
foreach ($steps as [$number, $title, $body]): ?>
                <div class="process__step">
                    <p class="process__number"><?= e($number) ?> / <?= e($title) ?></p>
                    <div>
                        <h3 class="process__title"><?= e($title) ?></h3>
                        <p class="process__body"><?= e($body) ?></p>
                    </div>
                </div>
<?php endforeach; ?>
            </div>
        </div>
    </section>

<?php
partial('cta-section', [
    'eyebrow'  => 'Start with clarity.',
    'headline' => 'Not sure which service you need?',
    'body'     => "That is a normal place to start. Tell us what is happening in the business and we will help you work out what matters first.",
    'ctas'     => [
        ['label' => 'Schedule a Discovery Call', 'href' => '/contact.php', 'style' => 'primary'],
        ['label' => 'Explore the Microsoft 365 Assessment', 'href' => '/microsoft-365-assessment.php', 'style' => 'ghost'],
    ],
]);

require __DIR__ . '/includes/footer.php';
