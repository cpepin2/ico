<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$page = [
    'title'       => 'Thank You | icoSTL',
    'description' => 'Your message has been sent. icoSTL will be in touch shortly.',
    'path'        => '/thank-you.php',
    'robots'      => 'noindex, follow',
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'  => 'Message received.',
    'headline' => 'Thank you — we will be in touch.',
    'body'     => 'Your message has been sent. We typically respond within one business day.',
    'compact'  => true,
]);
?>

    <section class="section">
        <div class="container">
            <div class="split">
                <?php partial('section-heading', [
                    'eyebrow'  => 'What happens next',
                    'headline' => 'A short, practical conversation.',
                ]); ?>

                <div class="prose">
                    <p>We will read what you sent and reply with either a direct answer or a few questions.</p>
                    <p>If a discovery call makes sense, it is a 20-minute conversation about what is happening in your business—not a sales presentation.</p>
                    <p>If your question is urgent, you can also reach us at <a href="mailto:<?= e(CONTACT_PUBLIC_EMAIL) ?>"><?= e(CONTACT_PUBLIC_EMAIL) ?></a>.</p>
                </div>
            </div>

            <div class="button-group">
                <a class="btn btn--ghost" href="/">Back to Home</a>
                <a class="btn btn--ghost" href="/microsoft-365-assessment.php">Explore the Assessment</a>
            </div>
        </div>
    </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
