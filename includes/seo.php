<?php
declare(strict_types=1);

if (!defined('ICOSTL')) {
    http_response_code(403);
    exit('Direct access is not permitted.');
}

/**
 * Render the <head> metadata for a page.
 *
 * $page keys: title, description, path, og_image, robots, breadcrumbs, faq, schema
 */
function render_meta(array $page): void
{
    $title       = $page['title'] ?? SITE_NAME;
    $description = $page['description'] ?? '';
    $canonical   = url($page['path'] ?? current_path());
    $ogImage     = url($page['og_image'] ?? '/assets/images/og-default.png');
    $robots      = $page['robots'] ?? 'index, follow';

    echo '    <title>' . e($title) . "</title>\n";
    echo '    <meta name="description" content="' . e($description) . "\">\n";
    echo '    <meta name="robots" content="' . e($robots) . "\">\n";
    echo '    <link rel="canonical" href="' . e($canonical) . "\">\n\n";

    foreach (['google-site-verification' => GOOGLE_SITE_VERIFICATION, 'msvalidate.01' => BING_SITE_VERIFICATION] as $name => $token) {
        if ($token !== '') {
            echo '    <meta name="' . $name . '" content="' . e($token) . "\">\n";
        }
    }

    // Open Graph
    echo '    <meta property="og:type" content="website">' . "\n";
    echo '    <meta property="og:site_name" content="' . e(SITE_NAME) . "\">\n";
    echo '    <meta property="og:title" content="' . e($title) . "\">\n";
    echo '    <meta property="og:description" content="' . e($description) . "\">\n";
    echo '    <meta property="og:url" content="' . e($canonical) . "\">\n";
    echo '    <meta property="og:image" content="' . e($ogImage) . "\">\n";
    echo '    <meta property="og:locale" content="en_US">' . "\n\n";

    // Twitter
    echo '    <meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '    <meta name="twitter:title" content="' . e($title) . "\">\n";
    echo '    <meta name="twitter:description" content="' . e($description) . "\">\n";
    echo '    <meta name="twitter:image" content="' . e($ogImage) . "\">\n";
}

/**
 * Organization + WebSite schema. Emitted on every page.
 */
function schema_organization(): array
{
    return [
        '@context'    => 'https://schema.org',
        '@type'       => 'ProfessionalService',
        '@id'         => url('/#organization'),
        'name'        => SITE_NAME,
        'slogan'      => SITE_TAGLINE,
        'description' => 'Practical technology consulting for businesses that want stronger systems, better security, smarter automation, and a clearer path forward.',
        'url'         => url('/'),
        'email'       => CONTACT_PUBLIC_EMAIL,
        'areaServed'  => [
            ['@type' => 'City',  'name' => 'St. Louis'],
            ['@type' => 'State', 'name' => 'Missouri'],
            ['@type' => 'Country', 'name' => 'United States'],
        ],
        'address' => [
            '@type'           => 'PostalAddress',
            'addressLocality' => SITE_LOCALITY,
            'addressRegion'   => SITE_REGION,
            'addressCountry'  => SITE_COUNTRY,
        ],
        'knowsAbout' => [
            'Microsoft 365 security',
            'Microsoft 365 Copilot readiness',
            'Business process automation',
            'Technology advisory',
            'Identity and access management',
        ],
    ];
}

function schema_website(): array
{
    return [
        '@context' => 'https://schema.org',
        '@type'    => 'WebSite',
        '@id'      => url('/#website'),
        'name'     => SITE_NAME,
        'url'      => url('/'),
        'publisher' => ['@id' => url('/#organization')],
    ];
}

/**
 * Breadcrumb schema from a [label => path] list.
 */
function schema_breadcrumbs(array $crumbs): array
{
    $items = [];
    $position = 1;

    foreach ($crumbs as $label => $path) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => $label,
            'item'     => url($path),
        ];
    }

    return [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    ];
}

/**
 * FAQPage schema from a list of ['question' => ..., 'answer' => ...].
 */
function schema_faq(array $faqs): array
{
    $items = array_map(static fn (array $faq): array => [
        '@type'          => 'Question',
        'name'           => $faq['question'],
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text'  => $faq['answer'],
        ],
    ], $faqs);

    return [
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => $items,
    ];
}

/**
 * Output one or more schema graphs as JSON-LD.
 */
function render_schema(array $graphs): void
{
    foreach ($graphs as $graph) {
        if (!is_array($graph) || $graph === []) {
            continue;
        }

        $json = json_encode(
            $graph,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
            | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        );

        if ($json === false) {
            continue;
        }

        // JSON_HEX_TAG prevents a literal </script> from closing the HTML tag.

        echo '    <script type="application/ld+json">' . $json . "</script>\n";
    }
}
