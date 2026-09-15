<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$page = [
    'title'       => 'About icoSTL | Ready, in case of.',
    'description' => 'icoSTL prepares businesses for the moments when technology matters most. Practical consulting rooted in St. Louis.',
    'path'        => '/about.php',
    'breadcrumbs' => ['Home' => '/', 'About' => '/about.php'],
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'  => 'Why “in case of”?',
    'headline' => 'Readiness is built into the name.',
    'body'     => 'Most businesses discover technology problems at exactly the wrong moment.',
]);
?>

    <!-- The moment -->
    <section class="section">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'The wrong moment',
                    'headline' => 'Technology that ran quietly in the background suddenly becomes business-critical.',
                ]); ?>

                <div class="prose">
                    <p>An employee leaves.</p>
                    <p>An account is compromised.</p>
                    <p>A customer asks a security question.</p>
                    <p>The company grows.</p>
                    <p>A new platform needs to integrate.</p>
                    <p>Leadership wants to adopt AI.</p>
                    <p>That's where the name comes from.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Meaning -->
    <section class="section section--dark">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'The meaning',
                    'headline' => 'ico = In Case Of.',
                ]); ?>

                <div class="prose">
                    <p>It is a reminder to prepare before the moment arrives.</p>
                    <p>It's a mindset, not a moment — practical technology for real-world readiness.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission -->
    <section class="section">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'Mission',
                    'headline' => 'icoSTL prepares businesses for the moments when technology matters most.',
                ]); ?>

                <div class="prose">
                    <p>We help organizations strengthen systems, improve security, simplify operations, and use automation intelligently so they can move forward with greater confidence.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- People. Systems. Processes. -->
    <section class="section section--surface">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'People. Systems. Processes.',
                    'headline' => 'Technology does not exist in isolation.',
                ]); ?>

                <div class="prose">
                    <p>A secure Microsoft tenant can still be undermined by a bad offboarding process.</p>
                    <p>An automation can be technically impressive and still solve the wrong problem.</p>
                    <p>An expensive piece of software can make operations worse if nobody owns it.</p>
                    <p>icoSTL looks at technology in the context of the people and processes surrounding it.</p>
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
                    'headline' => 'Charlie Pepin',
                ]); ?>

                <div>
                    <div class="prose">
                        <p>Charlie's professional background crosses technology, operations, marketing, communications, security/governance, and entrepreneurship.</p>
                        <p>His corporate experience includes Microsoft 365 global administration, IT operations, security and governance work, Zoho administration, web operations, and support for a distributed workforce.</p>
                        <p>At Pack3000, he served as Microsoft 365 Global Administrator, managed day-to-day IT operations and user support, and was responsible for technology access and organizational security requirements. That work also included access controls, company-wide 2FA, security and governance policies, Zoho CRM/Mail/Campaigns administration, and web/digital operations.</p>
                        <p>The objective is not simply to know a platform. It is to understand how technology affects the business operating around it.</p>
                    </div>

                    <p class="founder__closing">
                        People. Systems. Processes.
                        <span>Understand all three. Improve all three.</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Local -->
    <section class="section section--bordered">
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
    'eyebrow'  => 'Be ready before you need to be.',
    'headline' => 'What do you want to be ready for?',
    'ctas'     => [
        ['label' => 'Get in Touch', 'href' => '/contact.php', 'style' => 'primary'],
        ['label' => 'Explore the Microsoft 365 Assessment', 'href' => '/microsoft-365-assessment.php', 'style' => 'ghost'],
    ],
]);

require __DIR__ . '/includes/footer.php';
