<?php
/**
 * "In case of..." service card.
 *
 * @var string      $label
 * @var string      $case
 * @var string      $body
 * @var string|null $cta_label
 * @var string|null $cta_href
 * @var string|null $icon      Icon key rendered from the sprite
 */
$cta_label = $cta_label ?? null;
$cta_href  = $cta_href ?? null;
$icon      = $icon ?? null;
?>
<article class="service-card">
<?php if ($icon !== null): ?>
    <span class="service-card__icon" aria-hidden="true"><?php partial('icon', ['name' => $icon]); ?></span>
<?php endif; ?>
    <h3 class="service-card__label"><?= e($label) ?></h3>
    <p class="service-card__case"><?= e($case) ?></p>
    <p class="service-card__body"><?= e($body) ?></p>
<?php if ($cta_label !== null && $cta_href !== null): ?>
    <a class="link-arrow" href="<?= e($cta_href) ?>">
        <?= e($cta_label) ?><span class="link-arrow__glyph" aria-hidden="true">&rarr;</span>
    </a>
<?php endif; ?>
</article>
