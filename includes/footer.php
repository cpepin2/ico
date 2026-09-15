<?php
declare(strict_types=1);

if (!defined('ICOSTL')) {
    http_response_code(403);
    exit('Direct access is not permitted.');
}

$footerColumns = [
    'Services' => [
        'Microsoft 365 Assessment' => '/microsoft-365-assessment.php',
        'Security'                 => '/security.php',
        'Automation'               => '/automation.php',
        'AI & Readiness'           => '/ai-readiness.php',
        'Advisory'                 => '/advisory.php',
    ],
    'Company' => [
        'About'    => '/about.php',
        'Insights' => '/insights.php',
        'Contact'  => '/contact.php',
    ],
    'Legal' => [
        'Privacy' => '/privacy.php',
        'Terms'   => '/terms.php',
    ],
];
?>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="site-footer__top">
                <div class="site-footer__brand">
                    <span class="wordmark wordmark--reverse">
                        <span class="wordmark__mark" aria-hidden="true"></span>
                        <span class="wordmark__text">ico<span class="wordmark__stl">STL</span></span>
                    </span>
                    <p class="site-footer__tagline">Ready, in case of.</p>
                    <p class="eyebrow eyebrow--muted">Technology / Security / Automation</p>
                </div>

                <nav class="site-footer__nav" aria-label="Footer">
<?php foreach ($footerColumns as $heading => $links): ?>
                    <div class="site-footer__col">
                        <h2 class="site-footer__heading"><?= e($heading) ?></h2>
                        <ul>
<?php foreach ($links as $label => $path): ?>
                            <li><a href="<?= e($path) ?>"><?= e($label) ?></a></li>
<?php endforeach; ?>
                        </ul>
                    </div>
<?php endforeach; ?>
                </nav>
            </div>

            <div class="site-footer__bottom">
                <p class="site-footer__location">
                    St. Louis, Missouri<br>
                    <span class="site-footer__muted">Remote consulting available</span>
                </p>
                <p class="site-footer__copy">
                    &copy; <?= date('Y') ?> icoSTL. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script src="<?= e(asset('js/main.js')) ?>" defer></script>
<?php if (!empty($page['scripts']) && in_array('forms', $page['scripts'], true)): ?>
    <script src="<?= e(asset('js/forms.js')) ?>" defer></script>
<?php endif; ?>
</body>
</html>
