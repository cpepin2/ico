<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$page = [
    'title'       => 'Microsoft 365 Copilot & AI Readiness | icoSTL',
    'description' => 'Prepare permissions, governance, and data access before deploying Microsoft 365 Copilot or other AI tools. AI readiness consulting from icoSTL.',
    'path'        => '/ai-readiness.php',
    'breadcrumbs' => ['Home' => '/', 'Services' => '/services.php', 'AI & Readiness' => '/ai-readiness.php'],
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'  => 'In case of opportunity.',
    'headline' => 'Prepare before you deploy.',
    'body'     => 'AI can create real productivity gains. It can also expose weak permissions and unclear policies that already existed.',
    'ctas'     => [
        ['label' => 'Assess AI Readiness', 'href' => '/contact.php', 'style' => 'primary'],
    ],
]);

partial('service-body', [
    'intro_eyebrow'  => 'Readiness first.',
    'intro_headline' => 'AI reflects the environment you already have.',
    'intro' => [
        'AI can create real productivity gains. It can also expose weak permissions, inconsistent governance, poor data access practices, and unclear internal policies that already existed.',
        'icoSTL helps organizations prepare for Microsoft 365 Copilot and other AI tools by reviewing the systems and processes around them before broad deployment.',
        'A tool that surfaces information faster is only an improvement if the right people can reach the right information.',
    ],
    'areas_label'    => 'Areas',
    'areas_headline' => 'What readiness covers.',
    'areas' => [
        'Microsoft 365 Copilot readiness',
        'Permission review',
        'External sharing',
        'Oversharing',
        'AI-use policy',
        'Governance',
        'Purview capabilities',
        'Data-access preparation',
        'Rollout planning',
        'Adoption strategy',
    ],
    'approach_headline' => 'How readiness work runs.',
    'approach' => [
        ['Look at access first.', 'Before any rollout, we review who can currently reach what across SharePoint, OneDrive, and Teams.'],
        ['Set the rules.', 'A short, readable AI-use policy that staff can actually follow beats a long one nobody reads.'],
        ['Roll out in stages.', 'A limited first group surfaces problems while they are still small.'],
    ],
]);

partial('cta-section', [
    'eyebrow'  => 'Be ready before you need to be.',
    'headline' => 'Considering Copilot?',
    'body'     => 'The work that makes an AI rollout successful is mostly permissions, governance, and data hygiene—and it is worth doing regardless.',
    'ctas'     => [
        ['label' => 'Assess AI Readiness', 'href' => '/contact.php', 'style' => 'primary'],
        ['label' => 'Explore the Microsoft 365 Assessment', 'href' => '/microsoft-365-assessment.php', 'style' => 'ghost'],
    ],
]);

require __DIR__ . '/includes/footer.php';
