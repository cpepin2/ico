<?php
/**
 * The four "In case of..." brand pillars as linked cards.
 *
 * @var bool $with_ctas
 */
$with_ctas = $with_ctas ?? true;

$pillars = [
    [
        'icon'  => 'secure',
        'label' => 'Secure',
        'case'  => 'In case of risk.',
        'body'  => 'Know who has access. Strengthen critical systems. Reduce avoidable exposure before a problem forces the issue.',
        'cta_label' => 'Explore Security',
        'cta_href'  => '/security.php',
    ],
    [
        'icon'  => 'advise',
        'label' => 'Advise',
        'case'  => 'In case of change.',
        'body'  => 'Make better technology decisions when employees, systems, vendors, locations, or business requirements change.',
        'cta_label' => 'Explore Advisory',
        'cta_href'  => '/advisory.php',
    ],
    [
        'icon'  => 'automate',
        'label' => 'Automate',
        'case'  => 'In case of growth.',
        'body'  => 'Reduce repetitive work and build processes that scale without adding unnecessary complexity.',
        'cta_label' => 'Explore Automation',
        'cta_href'  => '/automation.php',
    ],
    [
        'icon'  => 'prepare',
        'label' => 'Prepare',
        'case'  => 'In case of opportunity.',
        'body'  => 'Prepare your systems, permissions, data, and processes before adopting AI or other new technology.',
        'cta_label' => 'Explore Readiness',
        'cta_href'  => '/ai-readiness.php',
    ],
];
?>
<div class="card-grid card-grid--4">
<?php foreach ($pillars as $pillar):
    if (!$with_ctas) {
        unset($pillar['cta_label'], $pillar['cta_href']);
    }
    partial('service-card', $pillar);
endforeach; ?>
</div>
