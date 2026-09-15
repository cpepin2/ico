<?php
/**
 * Eyebrow + headline block that opens a section.
 *
 * @var string      $eyebrow
 * @var string      $headline
 * @var string|null $body
 * @var int         $level   Heading level (default 2)
 */
$body  = $body ?? null;
$level = $level ?? 2;
$tag   = 'h' . max(2, min(4, $level));
?>
<div class="section-heading">
    <p class="eyebrow"><?= e($eyebrow) ?></p>
    <<?= $tag ?> class="section-heading__title"><?= e($headline) ?></<?= $tag ?>>
    <span class="accent-rule" aria-hidden="true"></span>
<?php if ($body !== null): ?>
    <div class="section-heading__body prose">
<?php foreach (preg_split('/\n{2,}/', trim($body)) as $paragraph): ?>
        <p><?= nl2br(e(trim($paragraph))) ?></p>
<?php endforeach; ?>
    </div>
<?php endif; ?>
</div>
