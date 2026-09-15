<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$page = [
    'title'       => 'Technology Advisory for Small Businesses | icoSTL',
    'description' => 'Practical technology guidance for leadership teams that need experienced input without creating a full-time executive role.',
    'path'        => '/advisory.php',
    'breadcrumbs' => ['Home' => '/', 'Services' => '/services.php', 'Advisory' => '/advisory.php'],
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'  => 'In case of change.',
    'headline' => 'Make technology decisions with someone on your side.',
    'body'     => 'Experienced input for leadership teams, without immediately creating another executive role.',
    'ctas'     => [
        ['label' => 'Talk About Technology Strategy', 'href' => '/contact.php', 'style' => 'primary'],
    ],
]);

partial('service-body', [
    'intro_eyebrow'  => 'Independent guidance.',
    'intro_headline' => 'Too important to manage informally.',
    'intro' => [
        'Small businesses often reach a point where technology decisions become too important to manage informally—but a full-time technology executive still does not make sense.',
        'icoSTL provides practical technology guidance for leadership teams that need experienced input without immediately creating another executive role.',
        'That often means helping leadership understand what questions to ask a vendor, what a proposal actually commits them to, and which decisions can wait.',
    ],
    'areas_label'    => 'Areas',
    'areas_headline' => 'Where advisory helps.',
    'areas' => [
        'Technology strategy',
        'Systems review',
        'Vendor evaluation',
        'Software selection',
        'Security priorities',
        'Budget planning',
        'Automation roadmap',
        'AI strategy',
        'Fractional technology leadership',
    ],
    'approach_headline' => 'How advisory work runs.',
    'approach' => [
        ['Regular, not constant.', 'A recurring conversation at a cadence that fits the business, rather than an open-ended retainer.'],
        ['Independent of vendors.', 'We are not reselling the software we evaluate, so the recommendation follows the requirement.'],
        ['Decisions, not documents.', 'The output is a decision you can act on, with the reasoning written down.'],
    ],
]);

partial('cta-section', [
    'eyebrow'  => 'Be ready before you need to be.',
    'headline' => 'Who owns technology strategy at your company?',
    'body'     => 'If the honest answer is "nobody, really", that is worth a conversation.',
    'ctas'     => [
        ['label' => 'Talk About Technology Strategy', 'href' => '/contact.php', 'style' => 'primary'],
        ['label' => 'See All Services', 'href' => '/services.php', 'style' => 'ghost'],
    ],
]);

require __DIR__ . '/includes/footer.php';
