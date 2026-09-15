<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }

// Fixed fixtures keep local secrets and deployment overrides out of tests.
define('ICOSTL', true);
define('ROOT_PATH', dirname(__DIR__));
define('INCLUDES_PATH', ROOT_PATH . '/includes');
define('SITE_NAME', 'icoSTL');
define('SITE_TAGLINE', 'Ready, in case of.');
define('SITE_DESCRIPTOR', 'Technology / Security / Automation');
define('SITE_URL', 'https://www.icostl.com');
define('SITE_LOCALITY', 'St. Louis');
define('SITE_REGION', 'MO');
define('SITE_COUNTRY', 'US');
define('CONTACT_PUBLIC_EMAIL', 'hello@icostl.com');
define('GOOGLE_SITE_VERIFICATION', 'test-"<&');
define('BING_SITE_VERIFICATION', 'test-bing');
// Page rendering runs in separate processes below using the real defaults.
require INCLUDES_PATH . '/functions.php';
require INCLUDES_PATH . '/seo.php';
function check(bool $condition, string $message): void {
    if (!$condition) { throw new RuntimeException($message); }
}
$payload = ['text' => '</ScRiPt><script>alert("x")</script> & café \' quoted'];
ob_start(); render_schema([$payload, [], null]); $html = ob_get_clean();
check(substr_count($html, '<script ') === 1 && substr_count($html, '</script>') === 1, 'Script boundary escaped');
preg_match('~<script[^>]*>(.*?)</script>~s', $html, $match);
check(json_decode($match[1], true, 512, JSON_THROW_ON_ERROR) === $payload, 'JSON-LD round trip');
ob_start(); render_meta(['path' => '/']); $meta = ob_get_clean();
$doc = new DOMDocument(); @$doc->loadHTML($meta);
$xp = new DOMXPath($doc);
check($xp->evaluate('string(//meta[@name="google-site-verification"]/@content)') === GOOGLE_SITE_VERIFICATION, 'Google verification escaping');
check($xp->evaluate('string(//meta[@name="msvalidate.01"]/@content)') === BING_SITE_VERIFICATION, 'Bing verification tag');

// Run the real pages in fresh PHP processes. Refuse local overrides to avoid
// inspecting private settings; run this suite in a clean checkout.
check(!file_exists(INCLUDES_PATH . '/config.local.php'), 'Run in a clean checkout without config.local.php');
function render_file(string $file): string {
    $command = [PHP_BINARY, '-d', 'display_errors=stderr', ROOT_PATH . '/' . $file];
    $process = proc_open($command, [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
    $out = stream_get_contents($pipes[1]); $err = stream_get_contents($pipes[2]);
    fclose($pipes[1]); fclose($pipes[2]);
    check(proc_close($process) === 0 && $err === '', 'Render failed: ' . $file);
    return $out;
}
$xml = simplexml_load_string(render_file('sitemap.php'));
check($xml !== false, 'Valid XML sitemap');
$locations = [];
foreach ($xml->url as $entry) { $locations[] = (string) $entry->loc; }
check(count($locations) === 12 && count(array_unique($locations)) === 12, '12 unique sitemap URLs');
check(!str_contains(render_file('sitemap.php'), '<lastmod>'), 'No deployment timestamps');
$robots = file_get_contents(ROOT_PATH . '/robots.txt');
check(str_contains($robots, 'Sitemap: ' . SITE_URL . '/sitemap.xml'), 'Robots sitemap origin');
check(!preg_match('~Disallow:\s*/thank-you\.php~', $robots), 'Noindex page crawlable');
foreach (glob(ROOT_PATH . '/*.php') as $file) {
    $name = basename($file);
    if ($name === 'sitemap.php') { continue; }
    $html = render_file($name);
    $doc = new DOMDocument(); @$doc->loadHTML($html); $xp = new DOMXPath($doc);
    $canonical = $xp->evaluate('string(//link[@rel="canonical"]/@href)');
    $noindex = str_contains($xp->evaluate('string(//meta[@name="robots"]/@content)'), 'noindex');
    check($noindex || in_array($canonical, $locations, true), 'Sitemap covers ' . $name);
    check(!$noindex || !in_array($canonical, $locations, true), 'Noindex excluded: ' . $name);
    check($xp->query('//meta[@name="google-site-verification" or @name="msvalidate.01"]')->length === 0, 'Empty tokens omitted');
    foreach ($xp->query('//script[@type="application/ld+json"]') as $script) {
        json_decode($script->textContent, true, 512, JSON_THROW_ON_ERROR);
    }
    foreach ($xp->query('//*[@href or @src or @action]') as $node) {
        foreach (['href', 'src', 'action'] as $attr) {
            $value = $node->getAttribute($attr);
            if (!str_starts_with($value, '/') || str_starts_with($value, '//')) { continue; }
            $path = parse_url($value, PHP_URL_PATH);
            check($path === '/' || is_file(ROOT_PATH . $path), 'Broken internal target on ' . $name . ': ' . $path);
            $fragment = parse_url($value, PHP_URL_FRAGMENT);
            if ($fragment && ($path === '/' ? 'index.php' : ltrim($path, '/')) === $name) {
                check($doc->getElementById($fragment) !== null, 'Missing fragment on ' . $name);
            }
        }
    }
}
echo "PASS: JSON-LD safety, verification tags, sitemap coverage, canonical URLs and rendered internal targets.\n";
