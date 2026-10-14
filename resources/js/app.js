/*
 * Progressive enhancement only: every page works without JavaScript.
 */

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

document.documentElement.classList.replace('no-js', 'js');

/* Header: border once the page scrolls */
function initHeader() {
    const header = document.querySelector('[data-header]');
    if (!header) return;

    const update = () => header.setAttribute('data-scrolled', String(window.scrollY > 8));
    update();
    window.addEventListener('scroll', update, { passive: true });
}

/* Services mega menu: click or keyboard to open, Escape or outside click to close */
function initMegaMenu() {
    document.querySelectorAll('[data-mega]').forEach((item) => {
        const trigger = item.querySelector('[data-mega-trigger]');
        const panel = item.querySelector('[data-mega-panel]');
        let closeTimer;

        const setOpen = (open) => {
            trigger.setAttribute('aria-expanded', String(open));
            panel.setAttribute('data-open', String(open));
        };

        trigger.addEventListener('click', () => setOpen(trigger.getAttribute('aria-expanded') !== 'true'));

        // Hover intent on pointer devices
        item.addEventListener('pointerenter', (e) => {
            if (e.pointerType !== 'mouse') return;
            clearTimeout(closeTimer);
            setOpen(true);
        });
        item.addEventListener('pointerleave', (e) => {
            if (e.pointerType !== 'mouse') return;
            closeTimer = setTimeout(() => setOpen(false), 180);
        });

        item.addEventListener('focusout', (e) => {
            if (!item.contains(e.relatedTarget)) setOpen(false);
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && trigger.getAttribute('aria-expanded') === 'true') {
                setOpen(false);
                trigger.focus();
            }
        });

        document.addEventListener('click', (e) => {
            if (!item.contains(e.target)) setOpen(false);
        });
    });
}

/* Mobile navigation */
function initMobileNav() {
    const toggle = document.querySelector('[data-menu-toggle]');
    const menu = document.getElementById(toggle?.getAttribute('aria-controls'));
    if (!toggle || !menu) return;

    const setOpen = (open) => {
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        menu.setAttribute('data-open', String(open));
        menu.inert = !open;
        document.body.setAttribute('data-menu-open', String(open));
    };

    menu.inert = true;
    toggle.addEventListener('click', () => setOpen(toggle.getAttribute('aria-expanded') !== 'true'));

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
            setOpen(false);
            toggle.focus();
        }
    });

    window.matchMedia('(min-width: 961px)').addEventListener('change', (e) => {
        if (e.matches) setOpen(false);
    });
}

/* Reveal on scroll */
function initReveal() {
    const items = document.querySelectorAll('[data-reveal]');
    if (!items.length) return;

    if (reduceMotion || !('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.08 },
    );

    items.forEach((el) => observer.observe(el));
}

/* Service explorer: accessible tabs (WAI-ARIA tabs pattern) */
function initExplorer() {
    document.querySelectorAll('[data-explorer]').forEach((explorer) => {
        const tabs = [...explorer.querySelectorAll('[role="tab"]')];
        const panels = tabs.map((tab) => document.getElementById(tab.getAttribute('aria-controls')));

        const select = (index, focus = false) => {
            tabs.forEach((tab, i) => {
                const selected = i === index;
                tab.setAttribute('aria-selected', String(selected));
                tab.tabIndex = selected ? 0 : -1;
                panels[i].hidden = !selected;
            });
            if (focus) tabs[index].focus();
            tabs[index].scrollIntoView({ block: 'nearest', inline: 'nearest', behavior: reduceMotion ? 'auto' : 'smooth' });
        };

        tabs.forEach((tab, i) => {
            tab.addEventListener('click', () => select(i));
            tab.addEventListener('keydown', (e) => {
                const keys = { ArrowDown: 1, ArrowRight: 1, ArrowUp: -1, ArrowLeft: -1 };
                if (e.key in keys) {
                    e.preventDefault();
                    select((i + keys[e.key] + tabs.length) % tabs.length, true);
                } else if (e.key === 'Home') {
                    e.preventDefault();
                    select(0, true);
                } else if (e.key === 'End') {
                    e.preventDefault();
                    select(tabs.length - 1, true);
                }
            });
        });

        explorer.classList.add('is-enhanced');
        panels.forEach((panel) => panel.setAttribute('role', 'tabpanel'));
        const initial = Math.max(0, tabs.findIndex((t) => t.getAttribute('aria-selected') === 'true'));
        tabs.forEach((tab, i) => {
            tab.tabIndex = i === initial ? 0 : -1;
            panels[i].hidden = i !== initial;
        });
    });
}

/* Approach timeline: track fills and markers light up as the section scrolls */
function initTimeline() {
    const timeline = document.querySelector('[data-timeline]');
    if (!timeline) return;

    const steps = [...timeline.querySelectorAll('.step')];
    const track = timeline.querySelector('.timeline__track span');

    if (reduceMotion) {
        steps.forEach((s) => s.classList.add('is-active'));
        track?.style.setProperty('--progress', 1);
        return;
    }

    let ticking = false;
    const update = () => {
        ticking = false;
        const rect = timeline.getBoundingClientRect();
        const vh = window.innerHeight;
        const progress = Math.min(1, Math.max(0, (vh * 0.85 - rect.top) / (rect.height + vh * 0.35)));
        track?.style.setProperty('--progress', progress.toFixed(3));
        steps.forEach((step, i) => step.classList.toggle('is-active', progress >= i / steps.length));
    };

    window.addEventListener(
        'scroll',
        () => {
            if (!ticking) {
                ticking = true;
                requestAnimationFrame(update);
            }
        },
        { passive: true },
    );
    update();
}

/* Hero deployment log: lines appear in sequence, then loop */
function initLog() {
    const log = document.querySelector('[data-log]');
    if (!log) return;

    const lines = [...log.querySelectorAll('li')];

    if (reduceMotion) {
        lines.forEach((l) => l.classList.add('is-shown'));
        return;
    }

    let i = 0;
    const step = () => {
        if (document.hidden) return setTimeout(step, 1000);
        if (i < lines.length) {
            lines[i++].classList.add('is-shown');
            setTimeout(step, 650);
        } else {
            setTimeout(() => {
                lines.forEach((l) => l.classList.remove('is-shown'));
                i = 0;
                setTimeout(step, 600);
            }, 4200);
        }
    };
    setTimeout(step, 500);
}

/* Enquiry form: inline validation messages and a submitting state */
function initForms() {
    document.querySelectorAll('form[data-enquiry]').forEach((form) => {
        const submit = form.querySelector('[type="submit"]');

        const messageFor = (field) => {
            const v = field.validity;
            if (v.valueMissing) return field.dataset.required || 'This field is required.';
            if (v.typeMismatch && field.type === 'email') return 'That email address does not look right.';
            if (v.tooShort) return `Please write at least ${field.minLength} characters.`;
            if (v.patternMismatch) return field.dataset.pattern || 'Please check this value.';
            return field.validationMessage;
        };

        const show = (field) => {
            const error = document.getElementById(`${field.id}-error`);
            if (!error) return;
            const valid = field.checkValidity();
            field.setAttribute('aria-invalid', String(!valid));
            error.textContent = valid ? '' : messageFor(field);
            error.hidden = valid;
        };

        form.noValidate = true;
        const fields = [...form.querySelectorAll('input[id], textarea[id], select[id]')];

        fields.forEach((field) => {
            field.addEventListener('blur', () => {
                if (field.value || field.getAttribute('aria-invalid') === 'true') show(field);
            });
            field.addEventListener('input', () => {
                if (field.getAttribute('aria-invalid') === 'true') show(field);
            });
            field.addEventListener('change', () => {
                if (field.type === 'checkbox') show(field);
            });
        });

        form.addEventListener('submit', (e) => {
            const invalid = fields.filter((f) => !f.checkValidity());
            if (invalid.length) {
                e.preventDefault();
                invalid.forEach(show);
                invalid[0].focus();
                return;
            }
            submit.setAttribute('data-loading', 'true');
            submit.setAttribute('aria-disabled', 'true');
        });
    });
}

/* Move focus to server-rendered confirmation or error summaries */
function initAutofocus() {
    const el = document.querySelector('[data-autofocus]');
    if (el) el.focus({ preventScroll: false });
}

/* Undo the submitting state if the page is restored from the back/forward cache */
window.addEventListener('pageshow', (e) => {
    if (e.persisted) {
        document.querySelectorAll('[data-loading]').forEach((b) => b.removeAttribute('data-loading'));
    }
});

initHeader();
initMegaMenu();
initMobileNav();
initReveal();
initExplorer();
initTimeline();
initLog();
initForms();
initAutofocus();
