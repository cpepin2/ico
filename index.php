<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$page = [
    'title'       => 'icoSTL | Technology, Security & Automation Consulting',
    'description' => 'Practical technology consulting for businesses that want stronger systems, better security, smarter automation, and greater readiness.',
    'path'        => '/',
    'body_class'  => 'page-home',
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'  => 'Ready, in case of.',
    'headline' => "Technology works better when you're ready.",
    'body'     => 'Practical technology consulting for businesses that want stronger systems, better security, smarter automation, and a clearer path forward.',
    'ctas'     => [
        ['label' => 'Assess Your Environment', 'href' => '/microsoft-365-assessment.php', 'style' => 'primary'],
        ['label' => 'Get in Touch', 'href' => '/contact.php', 'style' => 'ghost'],
    ],
    'descriptor' => 'Technology / Security / Automation',
]);
?>

    <!-- Intro -->
    <section class="section">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => "Built for what's next.",
                    'headline' => 'Technology should create confidence—not uncertainty.',
                ]); ?>

                <div class="prose">
                    <p>As businesses grow, technology gets more complicated.</p>
                    <p>Employees come and go. Permissions accumulate. Software gets added. Processes stay manual. Security responsibilities become unclear. New tools like AI introduce opportunities—and new questions.</p>
                    <p>icoSTL helps businesses get ahead of those moments.</p>
                    <p>We assess what exists, identify what matters, strengthen weak points, simplify operations, and build practical systems that help your business stay ready.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- In case of -->
    <section class="section section--dark">
        <div class="container">
            <?php partial('section-heading', [
                'eyebrow'  => 'What are you ready for?',
                'headline' => 'Built around the moments that matter.',
            ]); ?>

            <?php partial('pillars'); ?>
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
                        'body'     => 'The icoSTL Microsoft 365 Security & Operations Assessment provides a structured review of the technology your business depends on every day.',
                    ]); ?>

                    <div class="promise">
                        <p class="promise__line">What we found.</p>
                        <p class="promise__line">Why it matters.</p>
                        <p class="promise__line">How important it is.</p>
                        <p class="promise__line">What should happen next.</p>
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
                    <h3 class="eyebrow">Review areas include</h3>
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

    <!-- Why icoSTL -->
    <section class="section section--surface">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'Practical clarity.',
                    'headline' => 'No technology theater.',
                    'body'     => "Technology consulting should not leave leadership with a longer list of acronyms than they started with.\n\nicoSTL translates technical findings into practical business decisions.",
                ]); ?>

                <div class="card-grid card-grid--2">
<?php
$valueBlocks = [
    ['Real problems.', 'Not hypothetical complexity for its own sake.'],
    ['Clear priorities.', 'Not a hundred recommendations presented as equally urgent.'],
    ['Practical solutions.', 'Appropriate to the size, needs, and resources of the business.'],
    ['Business impact.', 'Because technology exists to support the organization—not the other way around.'],
];
foreach ($valueBlocks as [$title, $body]): ?>
                    <div class="value-block">
                        <h3 class="value-block__title"><?= e($title) ?></h3>
                        <p class="value-block__body"><?= e($body) ?></p>
                    </div>
<?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Services overview -->
    <section class="section">
        <div class="container">
            <?php partial('section-heading', [
                'eyebrow'  => 'Technology / Security / Automation',
                'headline' => 'Practical help where technology meets operations.',
            ]); ?>

<?php
$overview = [
    ['Secure', 'In case of risk.', ['Microsoft 365 security', 'Identity and MFA', 'Administrative access', 'Email security', 'External sharing', 'Audit configuration'], '/security.php'],
    ['Advise', 'In case of change.', ['Technology strategy', 'Vendor evaluation', 'Software selection', 'Technology roadmaps', 'Budget planning', 'Fractional leadership'], '/advisory.php'],
    ['Automate', 'In case of growth.', ['Power Automate', 'Zoho automation', 'CRM workflows', 'Forms and approvals', 'Reporting', 'Integrations'], '/automation.php'],
    ['Prepare', 'In case of opportunity.', ['Copilot readiness', 'Permission review', 'AI governance', 'Data-access review', 'Deployment planning', 'Adoption strategy'], '/ai-readiness.php'],
];
foreach ($overview as [$label, $case, $items, $href]): ?>
            <div class="capability">
                <div class="capability__header">
                    <h3 class="capability__label"><?= e($label) ?></h3>
                    <p class="capability__case"><?= e($case) ?></p>
                    <span class="accent-rule" aria-hidden="true"></span>
                    <a class="link-arrow" href="<?= e($href) ?>">Explore <?= e($label) ?><span class="link-arrow__glyph" aria-hidden="true">&rarr;</span></a>
                </div>
                <ul class="capability__list">
<?php foreach ($items as $item): ?>
                    <li><?= e($item) ?></li>
<?php endforeach; ?>
                </ul>
            </div>
<?php endforeach; ?>

            <div class="button-group">
                <a class="btn btn--ghost" href="/services.php">See all services</a>
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

    <!-- Existing IT provider -->
    <section class="section">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'Already have IT support?',
                    'headline' => "Good. We don't need to replace them.",
                ]); ?>

                <div class="prose">
                    <p>icoSTL can work alongside your MSP, internal IT team, software vendors, or other technology partners.</p>
                    <p>Sometimes the right role is implementation.</p>
                    <p>Sometimes it is independent assessment.</p>
                    <p>Sometimes it is helping leadership understand what questions to ask.</p>
                    <p>The objective is better technology—not replacing a provider simply for the sake of replacing them.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Local -->
    <section class="section section--surface">
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

    <!-- Founder -->
    <section class="section">
        <div class="container">
            <div class="founder">
                <?php partial('section-heading', [
                    'eyebrow'  => 'Founder & Principal Consultant',
                    'headline' => 'Technology experience shaped by real operations.',
                ]); ?>

                <div>
                    <div class="prose">
                        <p>Charlie Pepin's professional background spans operations, marketing, communications, IT, security/compliance, and business systems.</p>
                        <p>His corporate experience includes Microsoft 365 global administration, IT operations, security and governance work, Zoho administration, web operations, and support for a distributed workforce.</p>
                        <p>At Pack3000, he served as Microsoft 365 Global Administrator, managed day-to-day IT operations and user support, and was responsible for technology access and organizational security requirements.</p>
                        <p>His work also included access controls, company-wide 2FA, security and governance policies, Zoho CRM/Mail/Campaigns administration, and web/digital operations.</p>
                    </div>

                    <p class="founder__closing">
                        People. Systems. Processes.
                        <span>Understand all three. Improve all three.</span>
                    </p>

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
    'headline' => 'What would you want to know before technology becomes urgent?',
    'body'     => "If you're unsure about your Microsoft 365 environment, technology processes, security controls, automation opportunities, or readiness for AI, that's a good place to start.",
    'ctas'     => [
        ['label' => 'Schedule a Discovery Call', 'href' => '/contact.php', 'style' => 'primary'],
        ['label' => 'Explore the Microsoft 365 Assessment', 'href' => '/microsoft-365-assessment.php', 'style' => 'ghost'],
    ],
]);

require __DIR__ . '/includes/footer.php';
