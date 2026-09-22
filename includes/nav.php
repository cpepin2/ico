<?php
declare(strict_types=1);

if (!defined('ICOSTL')) {
    http_response_code(403);
    exit('Direct access is not permitted.');
}

$navLinks = [
    'Services' => '/services.php',
    'About'    => '/about.php',
    'Insights' => '/insights.php',
];
?>
    <header class="site-header" data-site-header>
        <div class="site-header__inner">
            <a class="site-header__brand" href="/" aria-label="icoSTL — home">
                <span class="wordmark">
                    <span class="wordmark__mark" aria-hidden="true"></span>
                    <span class="wordmark__text">ico<span class="wordmark__stl">STL</span></span>
                </span>
                <span class="wordmark__tagline">Ready, in case of.</span>
            </a>

            <button
                class="nav-toggle"
                type="button"
                aria-expanded="false"
                aria-controls="primary-nav"
                data-nav-toggle
            >
                <span class="nav-toggle__bars" aria-hidden="true">
                    <span></span><span></span><span></span>
                </span>
                <span class="nav-toggle__label">Menu</span>
            </button>

            <nav class="site-nav" id="primary-nav" aria-label="Primary">
                <ul class="site-nav__list">
<?php foreach ($navLinks as $label => $path): ?>
                    <li>
                        <a
                            class="site-nav__link"
                            href="<?= e($path) ?>"
                            <?= is_current($path) ? 'aria-current="page"' : '' ?>
                        ><?= e($label) ?></a>
                    </li>
<?php endforeach; ?>
                    <li class="site-nav__cta">
                        <a class="btn btn--primary btn--sm" href="/contact.php">Schedule a Consultation</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
