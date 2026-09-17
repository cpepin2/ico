<?php
/**
 * Illustrative diagrams for "What This Looks Like in Practice".
 *
 * These are schematic representations of the kind of output an engagement
 * produces — deliberately not screenshots, and carrying no client data or
 * invented findings. Each is captioned in the surrounding markup, and the
 * SVG carries an aria-label describing what it depicts.
 *
 * @var string $name
 */

$rows = [
    // label, filled severity squares (of 3)
    'findings' => [
        ['Administrative access', 3],
        ['MFA coverage', 2],
        ['External sharing', 2],
        ['Legacy authentication', 1],
    ],
];

ob_start();

switch ($name) {

    // ---- Security review: review areas with a severity scale -------------
    case 'security':
        ?>
        <svg class="viz" viewBox="0 0 400 240" role="img"
             aria-label="A review panel listing areas such as administrative access, MFA coverage, external sharing and legacy authentication, each with a three-point priority scale.">
            <rect x="0.5" y="0.5" width="399" height="239" rx="3" fill="var(--viz-surface)" stroke="var(--viz-line)"/>
            <text x="24" y="34" class="viz-label">REVIEW AREAS</text>
            <text x="376" y="34" class="viz-label" text-anchor="end">PRIORITY</text>
            <line x1="0" y1="52" x2="400" y2="52" stroke="var(--viz-line)"/>
            <?php $y = 84; foreach ($rows['findings'] as [$label, $level]): ?>
            <text x="24" y="<?= $y ?>" class="viz-text"><?= e($label) ?></text>
            <?php for ($i = 0; $i < 3; $i++):
                $x = 316 + ($i * 22);
                $on = $i < $level; ?>
            <rect x="<?= $x ?>" y="<?= $y - 11 ?>" width="12" height="12"
                  fill="<?= $on ? ($level === 3 ? 'var(--viz-accent)' : 'var(--viz-ink)') : 'none' ?>"
                  stroke="<?= $on ? 'none' : 'var(--viz-line)' ?>"/>
            <?php endfor; ?>
            <line x1="24" y1="<?= $y + 20 ?>" x2="376" y2="<?= $y + 20 ?>" stroke="var(--viz-line)"/>
            <?php $y += 40; endforeach; ?>
        </svg>
        <?php
        break;

    // ---- Automation: a workflow replacing manual steps --------------------
    case 'automation':
        ?>
        <svg class="viz" viewBox="0 0 400 240" role="img"
             aria-label="A workflow diagram: a submitted form triggers a check, which routes to either an approval or a notification, and the outcome is recorded.">
            <rect x="0.5" y="0.5" width="399" height="239" rx="3" fill="var(--viz-surface)" stroke="var(--viz-line)"/>
            <text x="24" y="34" class="viz-label">AUTOMATED WORKFLOW</text>
            <line x1="0" y1="52" x2="400" y2="52" stroke="var(--viz-line)"/>

            <rect x="24" y="86" width="92" height="40" fill="var(--viz-ink)"/>
            <text x="70" y="111" class="viz-text viz-text--invert" text-anchor="middle">Request</text>

            <line x1="116" y1="106" x2="152" y2="106" stroke="var(--viz-ink)" stroke-width="2"/>
            <path d="m146 100 8 6-8 6" fill="none" stroke="var(--viz-ink)" stroke-width="2"/>

            <rect x="154" y="86" width="84" height="40" fill="none" stroke="var(--viz-accent)" stroke-width="2"/>
            <text x="196" y="111" class="viz-text" text-anchor="middle">Check</text>

            <line x1="238" y1="106" x2="274" y2="106" stroke="var(--viz-ink)" stroke-width="2"/>
            <path d="m268 100 8 6-8 6" fill="none" stroke="var(--viz-ink)" stroke-width="2"/>
            <rect x="276" y="86" width="100" height="40" fill="none" stroke="var(--viz-line)"/>
            <text x="326" y="111" class="viz-text" text-anchor="middle">Approve</text>

            <path d="M196 126v40h80" fill="none" stroke="var(--viz-line)" stroke-width="2"/>
            <path d="m270 160 8 6-8 6" fill="none" stroke="var(--viz-line)" stroke-width="2"/>
            <rect x="276" y="146" width="100" height="40" fill="none" stroke="var(--viz-line)"/>
            <text x="326" y="171" class="viz-text" text-anchor="middle">Notify</text>

            <text x="24" y="210" class="viz-caption">Manual steps removed at each stage</text>
        </svg>
        <?php
        break;

    // ---- Planning: a prioritised roadmap ----------------------------------
    case 'planning':
        ?>
        <svg class="viz" viewBox="0 0 400 240" role="img"
             aria-label="A roadmap with three phases — now, next and later — shown as bars of decreasing urgency across a timeline.">
            <rect x="0.5" y="0.5" width="399" height="239" rx="3" fill="var(--viz-surface)" stroke="var(--viz-line)"/>
            <text x="24" y="34" class="viz-label">PRIORITISED ROADMAP</text>
            <line x1="0" y1="52" x2="400" y2="52" stroke="var(--viz-line)"/>

            <text x="24" y="90" class="viz-text">Now</text>
            <rect x="96" y="76" width="150" height="20" fill="var(--viz-accent)"/>

            <text x="24" y="136" class="viz-text">Next</text>
            <rect x="96" y="122" width="210" height="20" fill="var(--viz-ink)"/>

            <text x="24" y="182" class="viz-text">Later</text>
            <rect x="96" y="168" width="264" height="20" fill="none" stroke="var(--viz-line)"/>

            <line x1="96" y1="206" x2="376" y2="206" stroke="var(--viz-line)"/>
            <text x="96" y="226" class="viz-caption">30 days</text>
            <text x="376" y="226" class="viz-caption" text-anchor="end">Ongoing</text>
        </svg>
        <?php
        break;

    // ---- Visibility: who can reach what -----------------------------------
    case 'visibility':
        $groups  = ['Staff', 'Managers', 'Admins', 'Guests'];
        $access  = [
            [1, 0, 0],
            [1, 1, 0],
            [1, 1, 1],
            [2, 0, 0],   // 2 = flagged
        ];
        ?>
        <svg class="viz" viewBox="0 0 400 240" role="img"
             aria-label="An access grid showing which groups — staff, managers, administrators and guests — can reach files, systems and administrative settings, with guest access flagged for review.">
            <rect x="0.5" y="0.5" width="399" height="239" rx="3" fill="var(--viz-surface)" stroke="var(--viz-line)"/>
            <text x="24" y="34" class="viz-label">WHO CAN REACH WHAT</text>
            <line x1="0" y1="52" x2="400" y2="52" stroke="var(--viz-line)"/>

            <text x="204" y="76" class="viz-caption" text-anchor="middle">Files</text>
            <text x="280" y="76" class="viz-caption" text-anchor="middle">Systems</text>
            <text x="356" y="76" class="viz-caption" text-anchor="middle">Admin</text>

            <?php $y = 104; foreach ($groups as $i => $group): ?>
            <text x="24" y="<?= $y + 4 ?>" class="viz-text"><?= e($group) ?></text>
            <?php foreach ($access[$i] as $j => $state):
                $cx = 204 + ($j * 76); ?>
            <?php if ($state === 1): ?>
            <rect x="<?= $cx - 8 ?>" y="<?= $y - 8 ?>" width="16" height="16" fill="var(--viz-ink)"/>
            <?php elseif ($state === 2): ?>
            <rect x="<?= $cx - 8 ?>" y="<?= $y - 8 ?>" width="16" height="16" fill="var(--viz-accent)"/>
            <?php else: ?>
            <rect x="<?= $cx - 8 ?>" y="<?= $y - 8 ?>" width="16" height="16" fill="none" stroke="var(--viz-line)"/>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php $y += 34; endforeach; ?>

            <line x1="24" y1="222" x2="376" y2="222" stroke="var(--viz-line)"/>
            <text x="24" y="236" class="viz-caption">Flagged for review</text>
            <rect x="146" y="227" width="9" height="9" fill="var(--viz-accent)"/>
        </svg>
        <?php
        break;
}

echo ob_get_clean();
