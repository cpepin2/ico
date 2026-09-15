<?php
/**
 * FAQ list. Uses native <details> so it works without JavaScript.
 *
 * @var array $faqs [['question' => ..., 'answer' => ...], ...]
 */
$faqs = $faqs ?? [];
?>
<div class="faq">
<?php foreach ($faqs as $index => $faq): ?>
    <details class="faq__item"<?= $index === 0 ? ' open' : '' ?>>
        <summary class="faq__question">
            <span><?= e($faq['question']) ?></span>
            <span class="faq__marker" aria-hidden="true"></span>
        </summary>
        <div class="faq__answer prose">
            <p><?= e($faq['answer']) ?></p>
        </div>
    </details>
<?php endforeach; ?>
</div>
