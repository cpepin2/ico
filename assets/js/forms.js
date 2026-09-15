/**
 * icoSTL — contact form enhancements.
 *
 * Progressive only. Every rule enforced here is enforced again server-side;
 * nothing below is a security control.
 */
(function () {
    'use strict';

    var form = document.querySelector('[data-contact-form]');

    if (!form) {
        return;
    }

    // Stamp the render time so the server can reject submissions that arrive
    // implausibly fast. Bots that post the form directly leave this at zero.
    var timestamp = form.querySelector('[name="form_started"]');
    if (timestamp && !timestamp.value) {
        timestamp.value = String(Math.floor(Date.now() / 1000));
    }

    // Live character count for the message field.
    var message = form.querySelector('#message');
    var counter = form.querySelector('[data-char-count]');

    if (message && counter) {
        var limit = parseInt(message.getAttribute('maxlength') || '4000', 10);

        var updateCount = function () {
            var remaining = limit - message.value.length;
            counter.textContent = remaining.toLocaleString() + ' characters remaining';
        };

        message.addEventListener('input', updateCount);
        updateCount();
    }

    // Prevent a double submit without blocking the native POST.
    form.addEventListener('submit', function () {
        var submit = form.querySelector('[type="submit"]');

        if (!submit || !form.checkValidity()) {
            return;
        }

        submit.setAttribute('aria-disabled', 'true');
        submit.dataset.originalText = submit.textContent;
        submit.textContent = 'Sending…';

        // Re-enable if the browser restores the page from bfcache.
        window.setTimeout(function () {
            submit.removeAttribute('aria-disabled');
            if (submit.dataset.originalText) {
                submit.textContent = submit.dataset.originalText;
            }
        }, 8000);
    });

    // Move focus to the error summary so screen reader users hear it.
    var errorSummary = document.querySelector('[data-error-summary]');
    if (errorSummary) {
        errorSummary.focus();
    }
}());
