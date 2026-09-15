<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

start_secure_session();

// Pull any validation state left by the handler, then clear it so a refresh
// shows a clean form.
$flash  = $_SESSION['contact_flash'] ?? ['errors' => [], 'input' => []];
unset($_SESSION['contact_flash']);

$errors = is_array($flash['errors'] ?? null) ? $flash['errors'] : [];
$old    = is_array($flash['input'] ?? null) ? $flash['input'] : [];

/** Previously submitted value for a field, or an empty string. */
function old(array $old, string $key): string
{
    return is_string($old[$key] ?? null) ? $old[$key] : '';
}

$serviceOptions = [
    'microsoft-365-assessment' => 'Microsoft 365 Assessment',
    'security'                 => 'Security',
    'automation'               => 'Automation',
    'ai-copilot'               => 'AI / Copilot',
    'advisory'                 => 'Technology Advisory',
    'not-sure'                 => 'Not Sure Yet',
];

$employeeOptions = [
    '1-10'   => '1–10',
    '11-50'  => '11–50',
    '51-100' => '51–100',
    '100+'   => 'More than 100',
];

$page = [
    'title'       => 'Contact icoSTL | Start the Conversation',
    'description' => 'Tell us what is happening with your technology. icoSTL provides practical consulting for businesses in St. Louis and remotely.',
    'path'        => '/contact.php',
    'breadcrumbs' => ['Home' => '/', 'Contact' => '/contact.php'],
    'scripts'     => ['forms'],
];

require __DIR__ . '/includes/header.php';

partial('page-hero', [
    'eyebrow'  => 'Get in touch',
    'headline' => 'What do you want to be ready for?',
    'body'     => 'You do not need to know exactly which icoSTL service you need. Tell us what\'s happening.',
    'compact'  => true,
]);
?>

    <section class="section">
        <div class="container">
            <div class="contact-layout">
                <div>
                    <h2 class="eyebrow">For example</h2>
                    <ul class="example-list">
<?php
$examples = [
    "We're not sure our Microsoft 365 environment is secure.",
    'Employee onboarding and offboarding are inconsistent.',
    'We have too many manual processes.',
    "Our CRM isn't working the way we need it to.",
    "We're considering Microsoft 365 Copilot.",
    'Nobody really owns our technology strategy.',
    'We want a second opinion on our current environment.',
];
foreach ($examples as $example): ?>
                        <li><?= e($example) ?></li>
<?php endforeach; ?>
                    </ul>
                </div>

                <div id="contact-form">
<?php if (!empty($errors['form'])): ?>
                    <div class="alert alert--error" role="alert" tabindex="-1" data-error-summary>
                        <p class="alert__title">We could not send your message</p>
                        <p><?= e($errors['form']) ?></p>
                    </div>
<?php elseif ($errors !== []): ?>
                    <div class="alert alert--error" role="alert" tabindex="-1" data-error-summary>
                        <p class="alert__title">Please check the following</p>
                        <ul>
<?php foreach ($errors as $field => $message): ?>
                            <li><a href="#<?= e($field) ?>"><?= e($message) ?></a></li>
<?php endforeach; ?>
                        </ul>
                    </div>
<?php endif; ?>

                    <form class="form u-mt-lg" action="/includes/form-handler.php" method="post" novalidate data-contact-form>
                        <?= csrf_field() ?>
                        <input type="hidden" name="form_started" value="<?= e((string) time()) ?>">

                        <!-- Honeypot: hidden from people, visible to automated submitters. -->
                        <div class="form__honeypot" aria-hidden="true">
                            <label for="website">Website</label>
                            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="form__row">
                            <div class="field<?= isset($errors['name']) ? ' field--error' : '' ?>">
                                <label class="field__label" for="name">Name</label>
                                <input
                                    class="field__control"
                                    type="text"
                                    id="name"
                                    name="name"
                                    autocomplete="name"
                                    maxlength="100"
                                    required
                                    value="<?= e(old($old, 'name')) ?>"
                                    <?= isset($errors['name']) ? 'aria-invalid="true" aria-describedby="name-error"' : '' ?>
                                >
<?php if (isset($errors['name'])): ?>
                                <p class="field__error" id="name-error"><?= e($errors['name']) ?></p>
<?php endif; ?>
                            </div>

                            <div class="field<?= isset($errors['company']) ? ' field--error' : '' ?>">
                                <label class="field__label" for="company">Company</label>
                                <input
                                    class="field__control"
                                    type="text"
                                    id="company"
                                    name="company"
                                    autocomplete="organization"
                                    maxlength="120"
                                    required
                                    value="<?= e(old($old, 'company')) ?>"
                                    <?= isset($errors['company']) ? 'aria-invalid="true" aria-describedby="company-error"' : '' ?>
                                >
<?php if (isset($errors['company'])): ?>
                                <p class="field__error" id="company-error"><?= e($errors['company']) ?></p>
<?php endif; ?>
                            </div>
                        </div>

                        <div class="form__row">
                            <div class="field<?= isset($errors['email']) ? ' field--error' : '' ?>">
                                <label class="field__label" for="email">Business email</label>
                                <input
                                    class="field__control"
                                    type="email"
                                    id="email"
                                    name="email"
                                    autocomplete="email"
                                    maxlength="180"
                                    required
                                    value="<?= e(old($old, 'email')) ?>"
                                    <?= isset($errors['email']) ? 'aria-invalid="true" aria-describedby="email-error"' : '' ?>
                                >
<?php if (isset($errors['email'])): ?>
                                <p class="field__error" id="email-error"><?= e($errors['email']) ?></p>
<?php endif; ?>
                            </div>

                            <div class="field<?= isset($errors['phone']) ? ' field--error' : '' ?>">
                                <label class="field__label" for="phone">
                                    Phone <span class="field__optional">(optional)</span>
                                </label>
                                <input
                                    class="field__control"
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    autocomplete="tel"
                                    maxlength="40"
                                    value="<?= e(old($old, 'phone')) ?>"
                                    <?= isset($errors['phone']) ? 'aria-invalid="true" aria-describedby="phone-error"' : '' ?>
                                >
<?php if (isset($errors['phone'])): ?>
                                <p class="field__error" id="phone-error"><?= e($errors['phone']) ?></p>
<?php endif; ?>
                            </div>
                        </div>

                        <div class="form__row">
                            <div class="field<?= isset($errors['employees']) ? ' field--error' : '' ?>">
                                <label class="field__label" for="employees">Number of employees</label>
                                <select
                                    class="field__control"
                                    id="employees"
                                    name="employees"
                                    required
                                    <?= isset($errors['employees']) ? 'aria-invalid="true" aria-describedby="employees-error"' : '' ?>
                                >
                                    <option value="">Select a range</option>
<?php foreach ($employeeOptions as $value => $label): ?>
                                    <option value="<?= e($value) ?>"<?= old($old, 'employees') === $value ? ' selected' : '' ?>><?= e($label) ?></option>
<?php endforeach; ?>
                                </select>
<?php if (isset($errors['employees'])): ?>
                                <p class="field__error" id="employees-error"><?= e($errors['employees']) ?></p>
<?php endif; ?>
                            </div>

                            <div class="field<?= isset($errors['service']) ? ' field--error' : '' ?>">
                                <label class="field__label" for="service">Service interest</label>
                                <select
                                    class="field__control"
                                    id="service"
                                    name="service"
                                    required
                                    <?= isset($errors['service']) ? 'aria-invalid="true" aria-describedby="service-error"' : '' ?>
                                >
                                    <option value="">Select a service</option>
<?php foreach ($serviceOptions as $value => $label): ?>
                                    <option value="<?= e($value) ?>"<?= old($old, 'service') === $value ? ' selected' : '' ?>><?= e($label) ?></option>
<?php endforeach; ?>
                                </select>
<?php if (isset($errors['service'])): ?>
                                <p class="field__error" id="service-error"><?= e($errors['service']) ?></p>
<?php endif; ?>
                            </div>
                        </div>

                        <div class="field<?= isset($errors['message']) ? ' field--error' : '' ?>">
                            <label class="field__label" for="message">Tell us what's going on</label>
                            <textarea
                                class="field__control"
                                id="message"
                                name="message"
                                maxlength="4000"
                                required
                                aria-describedby="message-hint<?= isset($errors['message']) ? ' message-error' : '' ?>"
                                <?= isset($errors['message']) ? 'aria-invalid="true"' : '' ?>
                            ><?= e(old($old, 'message')) ?></textarea>
                            <p class="field__hint" id="message-hint" data-char-count>A short description is enough to start.</p>
<?php if (isset($errors['message'])): ?>
                            <p class="field__error" id="message-error"><?= e($errors['message']) ?></p>
<?php endif; ?>
                        </div>

                        <div>
                            <button class="btn btn--primary" type="submit">Start the Conversation</button>
                        </div>

                        <p class="note">
                            Submitting this form does not create a client relationship. Please do not submit
                            passwords, credentials, or sensitive information.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
