<?php
declare(strict_types=1);

/**
 * XML sitemap.
 *
 * Served at /sitemap.xml via the rewrite in .htaccess, and directly at
 * /sitemap.php as a fallback.
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

header('Content-Type: application/xml; charset=UTF-8');

/** path => [changefreq, priority] */
$pages = [
    '/'                             => ['weekly',  '1.0'],
    '/services.php'                 => ['monthly', '0.9'],
    '/microsoft-365-assessment.php' => ['monthly', '0.9'],
    '/security.php'                 => ['monthly', '0.8'],
    '/automation.php'               => ['monthly', '0.8'],
    '/ai-readiness.php'             => ['monthly', '0.8'],
    '/advisory.php'                 => ['monthly', '0.8'],
    '/about.php'                    => ['monthly', '0.7'],
    '/insights.php'                 => ['weekly',  '0.6'],
    '/contact.php'                  => ['monthly', '0.7'],
    '/privacy.php'                  => ['yearly',  '0.2'],
    '/terms.php'                    => ['yearly',  '0.2'],
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

foreach ($pages as $path => [$changefreq, $priority]) {
    echo "    <url>\n";
    echo '        <loc>' . htmlspecialchars(url($path), ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>\n";
    // Omit lastmod: deployment file timestamps do not track content changes.
    echo '        <changefreq>' . $changefreq . "</changefreq>\n";
    echo '        <priority>' . $priority . "</priority>\n";
    echo "    </url>\n";
}

echo '</urlset>' . "\n";
