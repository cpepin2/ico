<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$page = [
    'title'       => 'icoSTL | Technology, Security & Automation Consulting',
    'description' => 'Practical technology consulting for businesses that want stronger Microsoft 365 security, smarter automation, better technology decisions, and greater readiness for what comes next.',
    'path'        => '/',
    'body_class'  => 'page-home',
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'    => 'Ready, in case of.',
    'headline'   => "Technology works better when you're ready.",
    'body'       => 'Practical technology consulting for businesses that want to be ready for what comes next.',
    'ctas'       => [
        ['label' => 'Schedule a Consultation', 'href' => '/contact.php', 'style' => 'primary'],
        ['label' => 'Explore the Microsoft 365 Assessment', 'href' => '/microsoft-365-assessment.php', 'style' => 'ghost'],
    ],
    'descriptor' => 'Technology / Security / Automation',
]);
?>

    <!-- Positioning -->
    <section class="section">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => "Built for what's next.",
                    'headline' => 'Be ready before technology becomes urgent.',
                ]); ?>

                <div class="prose">
                    <p>Employees leave. Permissions change. Software accumulates. Manual processes stick around longer than they should. New technology creates opportunities, but it also creates decisions about access, ownership, security, and process.</p>
                    <p>icoSTL helps leadership understand what the business depends on, where control is weak, and what deserves attention first.</p>
                    <p>The work spans Microsoft 365, security, technology decisions, automation, and AI readiness, with recommendations tied to real business impact.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Four service pillars -->
    <section class="section section--dark">
        <div class="container">
            <?php partial('section-heading', [
                'eyebrow'  => 'Ready for what comes next.',
                'headline' => 'Technology problems rarely stay in one lane.',
            ]); ?>

            <div class="card-grid card-grid--4">
<?php
$pillars = [
    [
        'icon'  => 'secure',
        'label' => 'Secure',
        'case'  => 'In case of risk.',
        'body'  => 'Understand who has access, strengthen important controls, and reduce unnecessary exposure across Microsoft 365 and the systems your business depends on.',
        'cta'   => 'Explore Security',
        'href'  => '/security.php',
    ],
    [
        'icon'  => 'advise',
        'label' => 'Advise',
        'case'  => 'In case of change.',
        'body'  => 'Get independent guidance on software, vendors, technology priorities, roadmaps, and decisions that affect the business.',
        'cta'   => 'Explore Advisory',
        'href'  => '/advisory.php',
    ],
    [
        'icon'  => 'automate',
        'label' => 'Automate',
        'case'  => 'In case of growth.',
        'body'  => 'Reduce repetitive work, improve handoffs, and connect processes using tools such as Power Automate, Zoho, CRM workflows, forms, approvals, and integrations.',
        'cta'   => 'Explore Automation',
        'href'  => '/automation.php',
    ],
    [
        'icon'  => 'prepare',
        'label' => 'Prepare',
        'case'  => 'In case of opportunity.',
        'body'  => 'Get your permissions, data access, governance, and processes in order before rolling out Copilot, AI, or another major technology change.',
        'cta'   => 'Explore Readiness',
        'href'  => '/ai-readiness.php',
    ],
];
foreach ($pillars as $pillar): ?>
                <article class="help-card">
                    <span class="help-card__icon" aria-hidden="true"><?php partial('icon', ['name' => $pillar['icon']]); ?></span>
                    <h3 class="help-card__title"><?= e($pillar['label']) ?></h3>
                    <p class="help-card__case"><?= e($pillar['case']) ?></p>
                    <p class="help-card__body"><?= e($pillar['body']) ?></p>
                    <a class="link-arrow" href="<?= e($pillar['href']) ?>">
                        <?= e($pillar['cta']) ?><span class="link-arrow__glyph" aria-hidden="true">&rarr;</span>
                    </a>
                </article>
<?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Flagship assessment -->
    <section class="section">
        <div class="container">
            <div class="split">
                <div>
                    <?php partial('section-heading', [
                        'eyebrow'  => 'Start with clarity.',
                        'headline' => 'Know before you need to know.',
                    ]); ?>

                    <div class="prose">
                        <p>The Microsoft 365 Security &amp; Operations Assessment gives leadership a current-state view of the Microsoft 365 environment and a prioritized plan for what should happen next.</p>
                        <p>You'll understand the important findings, why they matter to the business, what should be addressed first, and which improvements can wait.</p>
                    </div>

                    <div class="price-callout">
                        <span class="price-callout__amount">Starting at $995</span>
                        <span class="price-callout__note">Most organizations with 11–50 Microsoft&nbsp;365 users: $1,500 fixed fee.</span>
                    </div>

                    <div class="button-group">
                        <a class="btn btn--primary" href="/microsoft-365-assessment.php">Explore the Assessment</a>
                    </div>
                </div>

                <div>
                    <h3 class="eyebrow">Review areas</h3>
                    <ul class="scope-list">
<?php
$reviewAreas = [
    'Identity and authentication',
    'Administrative access',
    'Microsoft 365 security',
    'Email configuration',
    'SharePoint, OneDrive and Teams',
    'External sharing',
    'Audit visibility',
    'Onboarding and offboarding',
    'Licensing efficiency',
    'AI and Copilot readiness',
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
    <section class="section section--surface">
        <div class="container">
            <?php partial('section-heading', [
                'eyebrow'  => 'Engagement output',
                'headline' => 'What this looks like in practice.',
                'body'     => 'Engagements produce specific, usable output: prioritized findings, working automations, a sequenced plan, and an accurate picture of who can reach what.',
            ]); ?>

            <div class="card-grid card-grid--2">
<?php
$practice = [
    ['security',   'Security Review',        'Identify risky access, authentication gaps, and configuration issues.'],
    ['automation', 'Process Automation',     'Replace repetitive manual steps with automated workflows.'],
    ['planning',   'Technology Planning',    'Turn scattered systems and decisions into a sequenced plan.'],
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

    <!-- Differentiation -->
    <section class="section">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'Practical clarity.',
                    'headline' => 'No technology theater.',
                    'body'     => "icoSTL translates technical findings into decisions leadership can use.\n\nFindings are explained in plain language, prioritized by business impact, and paired with specific recommendations. The goal is to show you what matters, what can wait, and what a sensible next step looks like.",
                ]); ?>

                <div class="card-grid card-grid--2">
<?php
$points = [
    ['Focus on the real environment', 'Recommendations are based on the systems, people, constraints, and business requirements that exist today.'],
    ['Prioritize what matters', 'Important findings come first. Useful improvements do not get presented with the same urgency as material problems.'],
    ['Recommend practical changes', 'Solutions are sized to the business, its resources, and the outcome you are trying to achieve.'],
    ['Connect technology to the business', 'Security, access, automation, licensing, and governance matter because of what they affect: people, operations, cost, risk, and growth.'],
];
foreach ($points as [$title, $body]): ?>
                    <div class="value-block">
                        <h3 class="value-block__title"><?= e($title) ?></h3>
                        <p class="value-block__body"><?= e($body) ?></p>
                    </div>
<?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Process -->
    <section class="section section--dark">
        <div class="container">
            <?php partial('section-heading', [
                'eyebrow'  => 'Clear from the start.',
                'headline' => 'A straightforward consulting process.',
            ]); ?>

            <div class="process">
<?php
$steps = [
    ['01', 'Understand', 'Define the business problem, desired outcome, relevant systems, and constraints.'],
    ['02', 'Assess', 'Review the systems, access, processes, and evidence relevant to the engagement.'],
    ['03', 'Prioritize', 'Turn findings into a practical sequence of actions based on business impact.'],
    ['04', 'Improve', 'Implement defined changes or coordinate the work with your existing provider.'],
    ['05', 'Stay Ready', 'Use icoSTL Stewardship for recurring oversight as accounts, permissions, systems, and business requirements change.'],
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

    <!-- Who we work with -->
    <section class="section">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'Who we work with',
                    'headline' => 'Built for businesses that need technology to work better.',
                    'body'     => 'icoSTL works with small and growing organizations that rely on Microsoft 365, cloud applications, shared systems, and evolving business processes, but may not have a full internal technology team.',
                ]); ?>

                <div>
                    <p class="text-lead">Engagements often start when a business is:</p>
                    <ul class="situation-list">
<?php
$situations = [
    'growing quickly',
    'adding or removing employees',
    'working around inconsistent access or permissions',
    'relying on manual workflows',
    'evaluating new software',
    'preparing for AI adoption',
    'unsure whether Microsoft 365 is configured properly',
    'improving security without adding complexity',
];
foreach ($situations as $situation): ?>
                        <li><?= e($situation) ?></li>
<?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Existing IT provider -->
    <section class="section section--surface">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'Works with your existing team.',
                    'headline' => 'icoSTL can work alongside your IT provider.',
                ]); ?>

                <div class="prose">
                    <p>Many businesses already have an MSP, internal IT resource, software vendor, or other technology partner.</p>
                    <p>icoSTL can provide independent assessment, defined implementation, governance, automation, or technology guidance while your existing provider continues handling the work they already own.</p>
                    <p>That separation is intentional. icoSTL focuses on defined consulting outcomes rather than becoming another help desk.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- St. Louis -->
    <section class="section">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'St. Louis / Real Impact',
                    'headline' => 'Based in St. Louis. Built to work anywhere.',
                ]); ?>

                <div class="prose">
                    <p>icoSTL works with businesses in St. Louis and remotely.</p>
                    <p>Most engagements center on Microsoft 365, cloud platforms, digital systems, and business processes, so the work can be delivered effectively without making geography the deciding factor.</p>
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
                    'headline' => 'Technology experience grounded in real operations.',
                ]); ?>

                <div>
                    <div class="prose">
                        <p>Charlie Pepin's background spans business operations, communications, IT administration, security and governance, Microsoft 365, Zoho, and digital systems.</p>
                        <p>At Pack3000, he served as Microsoft 365 Global Administrator while managing day-to-day IT operations and supporting a distributed workforce across the United States, Canada, and Mexico. His work included access controls, company-wide 2FA, security and governance policies, Zoho administration, user support, and web operations.</p>
                        <p>That cross-functional experience shapes how icoSTL approaches consulting: understand the people, systems, and processes involved before recommending what should change.</p>
                    </div>

                    <div class="button-group">
                        <a class="btn btn--ghost" href="/about.php">About icoSTL</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
partial('cta-section', [
    'eyebrow'  => 'Be ready before you need to be.',
    'headline' => 'Get a clear picture of what needs attention.',
    'body'     => "If you have questions about Microsoft 365, access and security controls, technology processes, automation, or AI readiness, start with a consultation. We'll define the problem and determine whether the right next step is an assessment, a specific project, ongoing advisory work, or something you can handle internally.",
    'ctas'     => [
        ['label' => 'Schedule a Consultation', 'href' => '/contact.php', 'style' => 'primary'],
        ['label' => 'Explore the Microsoft 365 Assessment', 'href' => '/microsoft-365-assessment.php', 'style' => 'ghost'],
    ],
]);

require __DIR__ . '/includes/footer.php';
