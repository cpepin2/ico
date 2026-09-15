<?php
/**
 * Shared body for the four capability pages (Security, Advisory, Automation,
 * AI Readiness). Each page supplies its own content; the structure is common.
 *
 * @var array $intro    Paragraphs of introductory copy.
 * @var array $areas    Capability items.
 * @var string $areas_label
 * @var array $approach [[title, body], ...]
 * @var array $cta
 */
$approach = $approach ?? [];
?>
    <section class="section">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => $intro_eyebrow,
                    'headline' => $intro_headline,
                ]); ?>

                <div class="prose">
<?php foreach ($intro as $paragraph): ?>
                    <p><?= e($paragraph) ?></p>
<?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="section section--dark">
        <div class="container">
            <?php partial('section-heading', [
                'eyebrow'  => $areas_label,
                'headline' => $areas_headline,
            ]); ?>

            <ul class="scope-list">
<?php foreach ($areas as $area): ?>
                <li><?php partial('icon', ['name' => 'check']); ?><span><?= e($area) ?></span></li>
<?php endforeach; ?>
            </ul>
        </div>
    </section>

<?php if ($approach !== []): ?>
    <section class="section">
        <div class="container">
            <?php partial('section-heading', [
                'eyebrow'  => 'How the work runs',
                'headline' => $approach_headline ?? 'What engagement looks like.',
            ]); ?>

            <div class="card-grid card-grid--3">
<?php foreach ($approach as [$title, $body]): ?>
                <div class="value-block">
                    <h3 class="value-block__title"><?= e($title) ?></h3>
                    <p class="value-block__body"><?= e($body) ?></p>
                </div>
<?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
