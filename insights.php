<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

/**
 * Insights articles.
 *
 * Add entries here as articles are published. Each entry needs:
 *   title, summary, topic, date (Y-m-d), href
 *
 * The page renders an empty state while this list is empty, so nothing has to
 * change structurally when the first article ships.
 */
$insights = [];

$page = [
    'title'       => 'Insights | Practical Technology Writing | icoSTL',
    'description' => 'Practical writing on Microsoft 365 security, business automation, AI readiness, and technology decisions for small and mid-sized businesses.',
    'path'        => '/insights.php',
    'breadcrumbs' => ['Home' => '/', 'Insights' => '/insights.php'],
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'  => 'Practical insights for real-world readiness.',
    'headline' => 'Writing about what actually matters.',
    'body'     => 'Notes on Microsoft 365 security, automation, AI readiness, and the technology decisions businesses face as they grow.',
    'compact'  => true,
]);
?>

    <section class="section">
        <div class="container">
<?php if ($insights === []): ?>
            <div class="insights-empty">
                <h2 class="insights-empty__title">Insights are on the way.</h2>
                <p class="insights-empty__body">
                    We are preparing practical writing on Microsoft 365 security, automation,
                    and AI readiness. In the meantime, the fastest way to get a clear answer
                    about your own environment is a conversation.
                </p>
                <div class="button-group">
                    <a class="btn btn--primary" href="/contact.php">Get in Touch</a>
                </div>
            </div>
<?php else: ?>
            <div class="card-grid card-grid--3">
<?php foreach ($insights as $insight): ?>
                <article class="insight-card">
                    <p class="insight-card__meta">
                        <?= e($insight['topic']) ?> &middot;
                        <time datetime="<?= e($insight['date']) ?>"><?= e(date('F j, Y', strtotime($insight['date']))) ?></time>
                    </p>
                    <h2 class="insight-card__title"><?= e($insight['title']) ?></h2>
                    <p class="insight-card__body"><?= e($insight['summary']) ?></p>
                    <a class="link-arrow" href="<?= e($insight['href']) ?>">
                        Read<span class="link-arrow__glyph" aria-hidden="true">&rarr;</span>
                    </a>
                </article>
<?php endforeach; ?>
            </div>
<?php endif; ?>
        </div>
    </section>

<?php
partial('cta-section', [
    'eyebrow'  => 'Be ready before you need to be.',
    'headline' => 'Have a question about your own environment?',
    'body'     => 'A 20-minute conversation is usually faster than reading around the problem.',
    'ctas'     => [
        ['label' => 'Schedule a Discovery Call', 'href' => '/contact.php', 'style' => 'primary'],
    ],
]);

require __DIR__ . '/includes/footer.php';
