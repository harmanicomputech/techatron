import { reduceMotion } from './env.js';

const root = document.documentElement;
const STORAGE_KEY = 'theme';

function current() {
    return root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
}

function apply(theme) {
    if (theme === 'dark') {
        root.setAttribute('data-theme', 'dark');
    } else {
        root.removeAttribute('data-theme');
    }

    try {
        localStorage.setItem(STORAGE_KEY, theme);
    } catch {
        // Storage unavailable (private mode); the choice lasts for this page only.
    }

    document.querySelector('meta[name="theme-color"]')?.setAttribute('content', theme === 'dark' ? '#282828' : '#ffffff');
    syncToggles();
}

function syncToggles() {
    const dark = current() === 'dark';
    document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
        btn.setAttribute('aria-pressed', String(dark));
        btn.setAttribute('aria-label', dark ? 'Switch to light mode' : 'Switch to dark mode');
    });
}

/* Circular reveal from the button, using the View Transitions API where available */
function toggle(event) {
    const next = current() === 'dark' ? 'light' : 'dark';

    if (!document.startViewTransition || reduceMotion) {
        apply(next);
        return;
    }

    const rect = event.currentTarget.getBoundingClientRect();
    const x = rect.left + rect.width / 2;
    const y = rect.top + rect.height / 2;
    const radius = Math.hypot(Math.max(x, innerWidth - x), Math.max(y, innerHeight - y));

    root.classList.add('theme-switching');
    const transition = document.startViewTransition(() => apply(next));

    transition.ready.then(() => {
        root.animate(
            { clipPath: [`circle(0px at ${x}px ${y}px)`, `circle(${radius}px at ${x}px ${y}px)`] },
            { duration: 700, easing: 'cubic-bezier(0.65, 0, 0.35, 1)', pseudoElement: '::view-transition-new(root)' },
        );
    });
    transition.finished.finally(() => root.classList.remove('theme-switching'));
}

export function initTheme() {
    syncToggles();
    document.querySelectorAll('[data-theme-toggle]').forEach((btn) => btn.addEventListener('click', toggle));
}
