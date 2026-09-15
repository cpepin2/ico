<?php
/**
 * Full-width closing call to action.
 *
 * @var string      $eyebrow
 * @var string      $headline
 * @var string|null $body
 * @var array       $ctas
 */
$body = $body ?? null;
$ctas = $ctas ?? [];
?>
<section class="cta-band">
    <div class="container">
        <div class="cta-band__content">
            <p class="eyebrow"><?= e($eyebrow) ?></p>
            <h2 class="cta-band__headline"><?= e($headline) ?></h2>
            <span class="accent-rule" aria-hidden="true"></span>
<?php if ($body !== null): ?>
            <p class="cta-band__body"><?= e($body) ?></p>
<?php endif; ?>
<?php if ($ctas !== []): ?>
            <div class="button-group">
<?php foreach ($ctas as $cta): ?>
                <a class="btn btn--<?= e($cta['style'] ?? 'primary') ?>" href="<?= e($cta['href']) ?>"><?= e($cta['label']) ?></a>
<?php endforeach; ?>
            </div>
<?php endif; ?>
        </div>
    </div>
</section>
