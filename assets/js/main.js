/**
 * icoSTL — global behaviour.
 *
 * Kept deliberately small: the site works without JavaScript, and this only
 * upgrades the mobile navigation.
 */
(function () {
    'use strict';

    var toggle = document.querySelector('[data-nav-toggle]');
    var nav = document.getElementById('primary-nav');

    if (!toggle || !nav) {
        return;
    }

    var MOBILE_QUERY = window.matchMedia('(max-width: 860px)');

    function setExpanded(isOpen) {
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        nav.classList.toggle('is-open', isOpen);
    }

    function isOpen() {
        return toggle.getAttribute('aria-expanded') === 'true';
    }

    toggle.addEventListener('click', function () {
        setExpanded(!isOpen());
    });

    // Escape closes the drawer and returns focus to the trigger.
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && isOpen()) {
            setExpanded(false);
            toggle.focus();
        }
    });

    // Following a link inside the drawer should close it.
    nav.addEventListener('click', function (event) {
        if (event.target.closest('a') && isOpen()) {
            setExpanded(false);
        }
    });

    // Leaving the mobile breakpoint resets state so the desktop nav is never
    // left in a half-open condition.
    function handleBreakpointChange(event) {
        if (!event.matches) {
            setExpanded(false);
        }
    }

    if (typeof MOBILE_QUERY.addEventListener === 'function') {
        MOBILE_QUERY.addEventListener('change', handleBreakpointChange);
    } else if (typeof MOBILE_QUERY.addListener === 'function') {
        MOBILE_QUERY.addListener(handleBreakpointChange);
    }
}());
