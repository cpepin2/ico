<?php
/**
 * Inline outline icon. Decorative by default — callers mark the wrapper
 * aria-hidden, so no title element is emitted.
 *
 * @var string $name
 */
$icons = [
    'secure' => '<path d="M12 3 4 6v6c0 5 3.4 8.3 8 9 4.6-.7 8-4 8-9V6l-8-3Z"/><circle cx="12" cy="12" r="2.5" fill="currentColor" stroke="none"/>',
    'advise' => '<circle cx="9" cy="8" r="3"/><path d="M3 20a6 6 0 0 1 12 0"/><circle cx="17" cy="9" r="2.5"/><path d="M15.5 20a5.5 5.5 0 0 1 5.5-5"/>',
    'automate' => '<path d="M4 20V11"/><path d="M10 20V5"/><path d="M16 20v-7"/><rect x="19" y="8" width="3" height="3" fill="currentColor" stroke="none"/>',
    'prepare' => '<rect x="3.5" y="3.5" width="17" height="17" rx="1.5"/><rect x="9" y="9" width="6" height="6" fill="currentColor" stroke="none"/>',
    'check' => '<path d="m4 12.5 5 5L20 6.5"/>',
    'arrow' => '<path d="M4 12h16"/><path d="m14 6 6 6-6 6"/>',
];

$paths = $icons[$name] ?? '';
?>
<svg class="icon icon--<?= e($name) ?>" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" focusable="false" aria-hidden="true"><?= $paths ?></svg>
