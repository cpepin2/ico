<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

http_response_code(404);

$page = [
    'title'       => 'Page Not Found | icoSTL',
    'description' => 'The page you were looking for could not be found.',
    'path'        => '/404.php',
    'robots'      => 'noindex, follow',
];

require __DIR__ . '/includes/header.php';
?>

    <section class="section">
        <div class="container">
            <div class="error-page">
                <p class="eyebrow">In case of a wrong turn.</p>
                <p class="error-page__code">404</p>
                <h1>This page isn't here.</h1>
                <span class="accent-rule" aria-hidden="true"></span>
                <p class="text-lead">The address may have changed, or the link may be out of date.</p>

                <div class="error-page__links">
                    <a class="link-arrow" href="/">Home<span class="link-arrow__glyph" aria-hidden="true">&rarr;</span></a>
                    <a class="link-arrow" href="/services.php">Services<span class="link-arrow__glyph" aria-hidden="true">&rarr;</span></a>
                    <a class="link-arrow" href="/microsoft-365-assessment.php">Microsoft 365 Assessment<span class="link-arrow__glyph" aria-hidden="true">&rarr;</span></a>
                    <a class="link-arrow" href="/contact.php">Contact<span class="link-arrow__glyph" aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
        </div>
    </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
