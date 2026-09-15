<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$page = [
    'title'       => 'Business Process Automation Consulting | icoSTL',
    'description' => 'Reduce repetitive work and build processes that scale. Power Automate, Zoho, CRM workflows, and practical automation from icoSTL.',
    'path'        => '/automation.php',
    'breadcrumbs' => ['Home' => '/', 'Services' => '/services.php', 'Automation' => '/automation.php'],
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'  => 'In case of growth.',
    'headline' => "Don't scale unnecessary work.",
    'body'     => 'Growth creates more work unless the systems behind the business improve with it.',
    'ctas'     => [
        ['label' => 'Discuss an Automation Opportunity', 'href' => '/contact.php', 'style' => 'primary'],
    ],
]);

partial('service-body', [
    'intro_eyebrow'  => 'Automate what repeats.',
    'intro_headline' => 'Build processes that scale with the business.',
    'intro' => [
        'icoSTL helps identify repetitive processes, disconnected systems, duplicate work, and avoidable administrative effort—then designs practical automation around the way your business actually operates.',
        'The goal is not to automate everything. It is to remove the work that consumes time without producing value, and to leave the rest clear enough that people can do it well.',
    ],
    'areas_label'    => 'Areas',
    'areas_headline' => 'Where automation usually helps.',
    'areas' => [
        'Microsoft Power Automate',
        'Zoho CRM',
        'Zoho Mail',
        'Zoho Campaigns',
        'CRM automation',
        'Forms',
        'Approvals',
        'Notifications',
        'Onboarding workflows',
        'Reporting',
        'Data movement',
        'Integrations',
        'AI-assisted workflows',
    ],
    'approach_headline' => 'How automation work runs.',
    'approach' => [
        ['Map the real process.', 'We document how the work happens today, including the steps nobody wrote down.'],
        ['Automate the right part.', 'A process that is broken does not get better by running faster. We fix the sequence before automating it.'],
        ['Leave it maintainable.', 'You get documentation and a clear owner, so the automation survives staff changes.'],
    ],
]);

partial('cta-section', [
    'eyebrow'  => 'Be ready before you need to be.',
    'headline' => 'Where is the work piling up?',
    'body'     => 'If a process takes longer every quarter, or depends on one person remembering the steps, that is usually a good place to start.',
    'ctas'     => [
        ['label' => 'Discuss an Automation Opportunity', 'href' => '/contact.php', 'style' => 'primary'],
        ['label' => 'See All Services', 'href' => '/services.php', 'style' => 'ghost'],
    ],
]);

require __DIR__ . '/includes/footer.php';
