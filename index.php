<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$page = [
    'title'       => 'icoSTL | Technology, Security & Automation Consulting',
    'description' => 'icoSTL helps small and growing businesses secure Microsoft 365, improve technology operations, automate repetitive work, and make better technology decisions.',
    'path'        => '/',
    'body_class'  => 'page-home',
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'headline'   => 'Technology, security, and automation for small and growing businesses.',
    'body'       => 'icoSTL helps businesses secure Microsoft 365, improve technology operations, automate repetitive work, and make better technology decisions.',
    'lead'       => 'Practical solutions. Clear priorities. Better prepared businesses.',
    'ctas'       => [
        ['label' => 'Schedule a Consultation', 'href' => '/contact.php', 'style' => 'primary'],
        ['label' => 'See Our Services', 'href' => '/services.php', 'style' => 'ghost'],
    ],
    'tagline'    => 'Ready, in case of.',
    'descriptor' => 'Technology / Security / Automation',
]);
?>

    <!-- What we help with -->
    <section class="section">
        <div class="container">
            <?php partial('section-heading', [
                'eyebrow'  => 'What we help with',
                'headline' => 'Your technology should support your business, not create uncertainty.',
                'body'     => 'icoSTL helps organizations improve security, simplify systems, reduce unnecessary manual work, and make smarter technology decisions.',
            ]); ?>

            <div class="card-grid card-grid--4">
<?php
$helpWith = [
    [
        'icon'  => 'secure',
        'label' => 'Secure',
        'body'  => 'Protect accounts, access, systems, and business information.',
        'href'  => '/security.php',
        'items' => [
            'Microsoft 365 security',
            'MFA and identity controls',
            'Administrative access review',
            'Email security',
            'Employee onboarding and offboarding',
            'Security and governance procedures',
        ],
    ],
    [
        'icon'  => 'advise',
        'label' => 'Advise',
        'body'  => 'Make better technology decisions with clear, practical guidance.',
        'href'  => '/advisory.php',
        'items' => [
            'Technology strategy',
            'Vendor and software evaluation',
            'Systems planning',
            'Technology roadmaps',
            'Process improvement',
            'Fractional technology leadership',
        ],
    ],
    [
        'icon'  => 'automate',
        'label' => 'Automate',
        'body'  => 'Reduce repetitive work and build processes that scale.',
        'href'  => '/automation.php',
        'items' => [
            'Power Automate',
            'Zoho workflows',
            'CRM automation',
            'Forms and approvals',
            'Notifications and reporting',
            'AI-assisted workflows',
        ],
    ],
    [
        'icon'  => 'prepare',
        'label' => 'Prepare',
        'body'  => 'Get your business ready for new technology before adoption becomes urgent.',
        'href'  => '/ai-readiness.php',
        'items' => [
            'Microsoft 365 Copilot readiness',
            'AI readiness',
            'AI governance',
            'Permission cleanup',
            'Data-access preparation',
            'Technology adoption planning',
        ],
    ],
];
foreach ($helpWith as $service): ?>
                <article class="help-card">
                    <span class="help-card__icon" aria-hidden="true"><?php partial('icon', ['name' => $service['icon']]); ?></span>
                    <h3 class="help-card__title"><?= e($service['label']) ?></h3>
                    <p class="help-card__body"><?= e($service['body']) ?></p>
                    <ul class="help-card__list">
<?php foreach ($service['items'] as $item): ?>
                        <li><?= e($item) ?></li>
<?php endforeach; ?>
                    </ul>
                    <a class="link-arrow" href="<?= e($service['href']) ?>">
                        <?= e($service['label']) ?> services<span class="link-arrow__glyph" aria-hidden="true">&rarr;</span>
                    </a>
                </article>
<?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Flagship assessment -->
    <section class="section section--dark">
        <div class="container">
            <div class="split">
                <div>
                    <?php partial('section-heading', [
                        'eyebrow'  => 'Start here',
                        'headline' => 'Start With a Microsoft 365 Security & Operations Assessment',
                        'body'     => "Know what's working, what isn't, and what should be addressed first.",
                    ]); ?>

                    <div class="prose">
                        <p>icoSTL reviews your Microsoft 365 environment to identify security risks, access issues, operational gaps, licensing inefficiencies, and opportunities for improvement.</p>
                        <p>You receive clear findings, prioritized recommendations, and a practical roadmap for what to do next.</p>
                    </div>

                    <div class="price-callout">
                        <span class="price-callout__amount">Starting at $995</span>
                        <span class="price-callout__note">Fixed fee, scoped by user count.</span>
                    </div>

                    <div class="button-group">
                        <a class="btn btn--primary" href="/microsoft-365-assessment.php">Learn About the Assessment</a>
                    </div>
                </div>

                <div>
                    <h3 class="eyebrow">What gets reviewed</h3>
                    <ul class="scope-list">
<?php
$reviewAreas = [
    'Identity and authentication',
    'Administrative access',
    'Microsoft 365 security',
    'Email configuration',
    'SharePoint, OneDrive, and Teams',
    'External sharing and guest access',
    'Auditing and security visibility',
    'Employee onboarding and offboarding',
    'Licensing and operational efficiency',
    'AI and Microsoft 365 Copilot readiness',
];
foreach ($reviewAreas as $area): ?>
                        <li><?php partial('icon', ['name' => 'check']); ?><span><?= e($area) ?></span></li>
<?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- What this looks like in practice -->
    <section class="section">
        <div class="container">
            <?php partial('section-heading', [
                'eyebrow'  => 'Concrete output',
                'headline' => 'What This Looks Like in Practice',
                'body'     => 'Engagements produce specific, usable output: clear findings, working automations, prioritised plans, and a real picture of who can reach what.',
            ]); ?>

            <div class="card-grid card-grid--2">
<?php
$practice = [
    ['security',   'Security Review',        'Identify risky access, authentication gaps, and configuration issues.'],
    ['automation', 'Process Automation',     'Replace repetitive manual steps with automated workflows.'],
    ['planning',   'Technology Planning',    'Turn scattered systems and decisions into a clear roadmap.'],
    ['visibility', 'Operational Visibility', 'Understand who has access, what systems matter, and where risk exists.'],
];
foreach ($practice as [$key, $title, $caption]): ?>
                <figure class="practice">
                    <div class="practice__visual"><?php partial('practice-visual', ['name' => $key]); ?></div>
                    <figcaption class="practice__caption">
                        <h3 class="practice__title"><?= e($title) ?></h3>
                        <p class="practice__body"><?= e($caption) ?></p>
                    </figcaption>
                </figure>
<?php endforeach; ?>
            </div>

            <p class="practice__note">Illustrative examples of engagement output. No client information is shown.</p>
        </div>
    </section>

    <!-- Who we work with -->
    <section class="section section--surface">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'Who we work with',
                    'headline' => 'Built for Businesses That Need Technology to Work Better',
                    'body'     => 'icoSTL works with small and growing organizations that rely on Microsoft 365, cloud applications, shared systems, and evolving business processes—but may not have a full internal technology team.',
                ]); ?>

                <div>
                    <p class="text-lead">We are especially useful when your business is:</p>
                    <ul class="situation-list">
<?php
$situations = [
    'growing quickly',
    'adding or removing employees',
    'struggling with inconsistent access or permissions',
    'relying on manual workflows',
    'evaluating new software',
    'preparing for AI adoption',
    'unsure whether Microsoft 365 is configured properly',
    'trying to improve security without creating unnecessary complexity',
];
foreach ($situations as $situation): ?>
                        <li><?= e($situation) ?></li>
<?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Why icoSTL -->
    <section class="section">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'Why icoSTL',
                    'headline' => 'Practical Technology Advice Without the Noise',
                    'body'     => "icoSTL combines hands-on technology experience with real business operations experience.\n\nWe focus on what matters: your people, your systems, and your processes.\n\nThat means recommendations are based on how your business actually works—not on selling unnecessary software, creating fear, or making technology more complicated than it needs to be.",
                ]); ?>

                <div class="card-grid">
<?php
$proofPoints = [
    ['Business-first', 'Technology decisions should support business goals.'],
    ['Practical',      'Recommendations should be realistic, prioritized, and actionable.'],
    ['Clear',          'You should understand what is wrong, why it matters, and what to do next.'],
];
foreach ($proofPoints as [$title, $body]): ?>
                    <div class="value-block">
                        <h3 class="value-block__title"><?= e($title) ?></h3>
                        <p class="value-block__body"><?= e($body) ?></p>
                    </div>
<?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Existing IT provider -->
    <section class="section section--bordered">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'Already have IT support?',
                    'headline' => "Good. We don't need to replace them.",
                ]); ?>

                <div class="prose">
                    <p>icoSTL can work alongside your MSP, internal IT team, software vendors, or other technology partners.</p>
                    <p>Sometimes the right role is implementation. Sometimes it is independent assessment. Sometimes it is helping leadership understand what questions to ask.</p>
                    <p>The objective is better technology—not replacing a provider simply for the sake of replacing them.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Founder -->
    <section class="section section--surface">
        <div class="container">
            <div class="founder">
                <?php partial('section-heading', [
                    'eyebrow'  => 'Founder & Principal Consultant',
                    'headline' => 'Built From Real Operational Experience',
                ]); ?>

                <div>
                    <div class="prose">
                        <p>icoSTL was founded by Charlie Pepin, whose background spans IT operations, Microsoft 365 administration, security and compliance, Zoho administration, marketing, communications, and business operations.</p>
                        <p>That cross-functional experience shapes the way icoSTL approaches technology: not as isolated software, but as the intersection of people, systems, and processes.</p>
                    </div>

                    <div class="button-group">
                        <a class="btn btn--ghost" href="/about.php">About icoSTL</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Local -->
    <section class="section">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'St. Louis / Real Impact',
                    'headline' => 'Based in St. Louis. Built to work anywhere.',
                ]); ?>

                <div class="prose">
                    <p>icoSTL is rooted in St. Louis and provides consulting for businesses locally and remotely.</p>
                    <p>Our work is designed around cloud platforms, digital systems, business processes, and practical collaboration—not unnecessary onsite dependence.</p>
                </div>
            </div>
        </div>
    </section>

<?php
partial('cta-section', [
    'eyebrow'  => 'Not sure where to start?',
    'headline' => "That's exactly what the first conversation is for.",
    'body'     => "We'll talk through your current environment, what is working, what is creating friction, and where the biggest opportunities may be.",
    'ctas'     => [
        ['label' => 'Schedule a Consultation', 'href' => '/contact.php', 'style' => 'primary'],
        ['label' => 'Learn About the Assessment', 'href' => '/microsoft-365-assessment.php', 'style' => 'ghost'],
    ],
]);

require __DIR__ . '/includes/footer.php';
