<?php
/**
 * Two-column list of capability items under a heading.
 *
 * @var string      $label
 * @var string      $case
 * @var string      $items
 * @var string|null $intro
 */
$intro = $intro ?? null;
?>
<div class="capability">
    <div class="capability__header">
        <h3 class="capability__label"><?= e($label) ?></h3>
        <p class="capability__case"><?= e($case) ?></p>
        <span class="accent-rule" aria-hidden="true"></span>
<?php if ($intro !== null): ?>
        <p class="capability__intro"><?= e($intro) ?></p>
<?php endif; ?>
    </div>
    <ul class="capability__list">
<?php foreach ($items as $item): ?>
        <li><?= e($item) ?></li>
<?php endforeach; ?>
    </ul>
</div>
