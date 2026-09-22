<?php
/**
 * Page hero.
 *
 * @var string|null $eyebrow    Small label above the headline. Omit on pages
 *                              that should lead with the plain-English headline.
 * @var string      $headline
 * @var string|null $body
 * @var array       $ctas       [['label' =>, 'href' =>, 'style' => primary|secondary|ghost], ...]
 * @var string|null $descriptor
 * @var string      $variant    'dark' (default) or 'light'
 * @var bool        $compact
 */
$variant    = $variant ?? 'dark';
$compact    = $compact ?? false;
$ctas       = $ctas ?? [];
$eyebrow    = $eyebrow ?? null;
$body       = $body ?? null;
$descriptor = $descriptor ?? null;
?>
<section class="hero hero--<?= e($variant) ?><?= $compact ? ' hero--compact' : '' ?>">
    <div class="container">
        <div class="hero__content">
<?php if ($eyebrow !== null): ?>
            <p class="eyebrow"><?= e($eyebrow) ?></p>
<?php endif; ?>
            <h1 class="hero__headline"><?= e($headline) ?></h1>
            <span class="accent-rule" aria-hidden="true"></span>
<?php if ($body !== null): ?>
            <p class="hero__body"><?= e($body) ?></p>
<?php endif; ?>
<?php if ($ctas !== []): ?>
            <div class="button-group">
<?php foreach ($ctas as $cta): ?>
                <a class="btn btn--<?= e($cta['style'] ?? 'primary') ?>" href="<?= e($cta['href']) ?>"><?= e($cta['label']) ?></a>
<?php endforeach; ?>
            </div>
<?php endif; ?>
<?php if ($descriptor !== null): ?>
            <p class="hero__descriptor"><?= e($descriptor) ?></p>
<?php endif; ?>
        </div>
    </div>
</section>
