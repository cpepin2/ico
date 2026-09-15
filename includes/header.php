<?php
declare(strict_types=1);

if (!defined('ICOSTL')) {
    require_once __DIR__ . '/config.php';
}

require_once INCLUDES_PATH . '/functions.php';
require_once INCLUDES_PATH . '/seo.php';

send_security_headers();

/** @var array $page Set by the including page before this file is required. */
$page = $page ?? [];

$schemaGraphs = array_merge(
    [schema_organization(), schema_website()],
    $page['schema'] ?? []
);

if (!empty($page['breadcrumbs'])) {
    $schemaGraphs[] = schema_breadcrumbs($page['breadcrumbs']);
}

if (!empty($page['faq'])) {
    $schemaGraphs[] = schema_faq($page['faq']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#000000">

<?php render_meta($page); ?>

    <link rel="icon" href="<?= e(asset('logos/favicon.svg')) ?>" type="image/svg+xml">
    <link rel="apple-touch-icon" href="<?= e(asset('logos/apple-touch-icon.png')) ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Assistant:wght@400;600;800&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Assistant:wght@400;600;800&display=swap">

    <link rel="stylesheet" href="<?= e(asset('css/reset.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/variables.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/base.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/layout.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/components.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/pages.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/responsive.css')) ?>">

<?php render_schema($schemaGraphs); ?>
</head>
<body<?= isset($page['body_class']) ? ' class="' . e($page['body_class']) . '"' : '' ?>>
    <a class="skip-link" href="#main">Skip to main content</a>

<?php require INCLUDES_PATH . '/nav.php'; ?>

    <main id="main">
