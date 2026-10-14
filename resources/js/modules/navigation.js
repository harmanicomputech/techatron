/* Header state, services mega menu and the mobile menu */

export const nav = { lenis: null };

function initHeader() {
    const header = document.querySelector('[data-header]');
    if (!header) return;

    let lastY = window.scrollY;
    const update = () => {
        const y = window.scrollY;
        header.setAttribute('data-scrolled', String(y > 20));

        const menuOpen = document.body.getAttribute('data-menu-open') === 'true';
        const megaOpen = header.querySelector('[data-mega-panel][data-open="true"]');
        const hide = y > 400 && y > lastY + 4 && !menuOpen && !megaOpen && !header.contains(document.activeElement);
        if (hide) header.setAttribute('data-hidden', 'true');
        else if (y < lastY - 4 || y <= 400) header.setAttribute('data-hidden', 'false');
        lastY = y;
    };

    update();
    window.addEventListener('scroll', update, { passive: true });
    header.addEventListener('focusin', () => header.setAttribute('data-hidden', 'false'));
}

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

        item.addEventListener('pointerenter', (e) => {
            if (e.pointerType !== 'mouse') return;
            clearTimeout(closeTimer);
            setOpen(true);
        });
        item.addEventListener('pointerleave', (e) => {
            if (e.pointerType !== 'mouse') return;
            closeTimer = setTimeout(() => setOpen(false), 200);
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
        if (nav.lenis) open ? nav.lenis.stop() : nav.lenis.start();
    };

    menu.inert = true;
    menu.setAttribute('data-lenis-prevent', '');
    toggle.addEventListener('click', () => setOpen(toggle.getAttribute('aria-expanded') !== 'true'));

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
            setOpen(false);
            toggle.focus();
        }
    });

    window.matchMedia('(min-width: 1081px)').addEventListener('change', (e) => {
        if (e.matches) setOpen(false);
    });
}

export function initNavigation() {
    initHeader();
    initMegaMenu();
    initMobileNav();
}
