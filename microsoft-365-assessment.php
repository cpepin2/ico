<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/seo.php';

$faqs = [
    [
        'question' => 'How long does the assessment take?',
        'answer'   => 'Most assessments are completed within two weeks of receiving access. Larger or more complex environments may take longer, and we will tell you before starting if we expect that to be the case.',
    ],
    [
        'question' => 'What access do you need?',
        'answer'   => 'The assessment is primarily read-only. We request delegated or scoped administrative access sufficient to review configuration, and we agree the specific level of access with you in writing before any review begins.',
    ],
    [
        'question' => 'Will this disrupt our environment?',
        'answer'   => 'No. The assessment reviews configuration and reports on it. We do not change settings during the assessment unless you explicitly ask us to and agree the change separately.',
    ],
    [
        'question' => 'Do we have to buy remediation work afterwards?',
        'answer'   => 'No. You can address findings internally, hand the report to your existing IT provider, or engage icoSTL. The report is yours either way.',
    ],
    [
        'question' => 'Does this replace a penetration test or a compliance audit?',
        'answer'   => 'No. This is a configuration and operations review of your Microsoft 365 environment. It is not a penetration test, and it is not a certification or compliance audit.',
    ],
];

$page = [
    'title'       => 'Microsoft 365 Security Assessment | icoSTL',
    'description' => 'Identify Microsoft 365 access, security, operational, licensing, and AI-readiness issues with a structured icoSTL assessment.',
    'path'        => '/microsoft-365-assessment.php',
    'og_image'    => '/assets/images/og-assessment.png',
    'breadcrumbs' => ['Home' => '/', 'Services' => '/services.php', 'Microsoft 365 Assessment' => '/microsoft-365-assessment.php'],
    'faq'         => $faqs,
    'schema'      => [[
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        'name'        => 'Microsoft 365 Security & Operations Assessment',
        'serviceType' => 'Microsoft 365 security and operations review',
        'provider'    => ['@id' => url('/#organization')],
        'areaServed'  => ['@type' => 'Country', 'name' => 'United States'],
        'description' => 'A structured review of Microsoft 365 identity, access, security, sharing, auditing, licensing, employee lifecycle, and AI readiness.',
        'offers'      => [
            '@type'         => 'Offer',
            'priceCurrency' => 'USD',
            'price'         => '995',
            'description'   => 'Starting price for organizations with 1–10 Microsoft 365 users.',
            'url'           => url('/microsoft-365-assessment.php'),
        ],
    ]],
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'  => 'Know before you need to know.',
    'headline' => 'Microsoft 365 Security & Operations Assessment',
    'body'     => 'A structured review of the technology your business depends on every day.',
    'ctas'     => [
        ['label' => 'Schedule a 20-Minute Discovery Call', 'href' => '/contact.php', 'style' => 'primary'],
    ],
]);
?>

    <!-- Intro -->
    <section class="section">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'Microsoft 365 grows quietly.',
                    'headline' => '“Is this actually configured the way it should be?”',
                ]); ?>

                <div class="prose">
                    <p>Accounts are added. Employees leave. Administrators change. Files are shared. Guests accumulate. Licenses expand. New applications are connected.</p>
                    <p>And eventually someone asks that question.</p>
                    <p>icoSTL helps you answer it.</p>

                    <div class="price-callout">
                        <span class="price-callout__amount">Starting at $995</span>
                        <span class="price-callout__note">Fixed fee, scoped by user count.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scope -->
    <section class="section section--dark">
        <div class="container">
            <?php partial('section-heading', [
                'eyebrow'  => 'Assessment scope',
                'headline' => 'What we review.',
            ]); ?>

            <ul class="scope-list">
<?php
$scope = [
    'Identity', 'Authentication', 'Administrative Access', 'Email',
    'SharePoint', 'OneDrive', 'Teams', 'External Sharing',
    'Auditing', 'Licensing', 'Employee Lifecycle', 'Governance', 'AI Readiness',
];
foreach ($scope as $item): ?>
                <li><?php partial('icon', ['name' => 'check']); ?><span><?= e($item) ?></span></li>
<?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- Deliverables -->
    <section class="section">
        <div class="container">
            <?php partial('section-heading', [
                'eyebrow'  => 'What you receive',
                'headline' => 'Findings you can act on.',
            ]); ?>

            <div class="card-grid card-grid--4">
<?php
$deliverables = [
    ['01', 'Executive Summary', 'A plain-language overview written for leadership, not for administrators.'],
    ['02', 'Risk Dashboard', 'A structured view of what was reviewed and where attention is needed.'],
    ['03', 'Prioritized Findings', 'Each finding rated by business impact, so the list has an order.'],
    ['04', '30-Day Roadmap', 'A practical sequence for what to address first, and what can wait.'],
];
foreach ($deliverables as [$number, $title, $body]): ?>
                <div class="deliverable">
                    <p class="deliverable__number"><?= e($number) ?></p>
                    <h3 class="deliverable__title"><?= e($title) ?></h3>
                    <p class="deliverable__body"><?= e($body) ?></p>
                </div>
<?php endforeach; ?>
            </div>

            <div class="promise u-mt-xl">
                <p class="promise__line">What we found.</p>
                <p class="promise__line">Why it matters.</p>
                <p class="promise__line">How important it is.</p>
                <p class="promise__line">What should happen next.</p>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section class="section section--surface">
        <div class="container">
            <?php partial('section-heading', [
                'eyebrow'  => 'Transparent pricing',
                'headline' => 'Fixed fee, scoped by size.',
            ]); ?>

            <div class="pricing">
<?php
$tiers = [
    ['1–10 users', '$995', null, false],
    ['11–50 users', '$1,500', 'Most common', true],
    ['51–100 users', '$2,500', null, false],
    ['100+ users', 'Custom', 'Scoped with you', false],
];
foreach ($tiers as [$size, $amount, $flag, $featured]): ?>
                <div class="pricing__tier<?= $featured ? ' pricing__tier--featured' : '' ?>">
                    <p class="pricing__size"><?= e($size) ?></p>
                    <p class="pricing__amount"><?= e($amount) ?></p>
<?php if ($flag !== null): ?>
                    <p class="pricing__flag"><?= e($flag) ?></p>
<?php endif; ?>
                </div>
<?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- No forced upsell -->
    <section class="section">
        <div class="container">
            <div class="no-upsell">
                <div>
                    <p class="eyebrow">No forced upsell</p>
                    <h2>The report stands on its own.</h2>
                    <span class="accent-rule" aria-hidden="true"></span>
                </div>
                <div class="prose">
                    <p>You can fix findings internally, hand the report to your current IT provider, or engage icoSTL for remediation.</p>
                    <p>The assessment is valuable even if icoSTL never performs another hour of work.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section section--bordered">
        <div class="container container--narrow">
            <?php partial('section-heading', [
                'eyebrow'  => 'Common questions',
                'headline' => 'Before you start.',
            ]); ?>

            <?php partial('faq', ['faqs' => $faqs]); ?>
        </div>
    </section>

<?php
partial('cta-section', [
    'eyebrow'  => 'Be ready before you need to be.',
    'headline' => 'Start with a 20-minute conversation.',
    'body'     => 'We will talk through your environment, confirm scope, and give you a fixed price before any work begins.',
    'ctas'     => [
        ['label' => 'Schedule a Discovery Call', 'href' => '/contact.php', 'style' => 'primary'],
        ['label' => 'See All Services', 'href' => '/services.php', 'style' => 'ghost'],
    ],
]);

require __DIR__ . '/includes/footer.php';
