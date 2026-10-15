/*
 * Hero build studio: accessible tabs (Website, Mobile app, Software,
 * Campaign) that also cycle on their own. Each switch replays the typing,
 * the preview build and the status bar. Cycling pauses on hover or focus,
 * when the hero is off screen or the tab is hidden, and never runs for
 * reduced-motion visitors.
 */

import { reduceMotion } from './env.js';

const CYCLE_MS = 7000;

export function initStudio() {
    const studio = document.querySelector('[data-studio]');
    if (!studio) return;

    const tabs = [...studio.querySelectorAll('[role="tab"]')];
    const panels = tabs.map((tab) => document.getElementById(tab.getAttribute('aria-controls')));
    let index = Math.max(0, tabs.findIndex((t) => t.getAttribute('aria-selected') === 'true'));
    let timer = null;
    let remaining = CYCLE_MS;
    let startedAt = 0;
    let hovering = false;
    let visible = true;
    let stopped = reduceMotion; // a visitor choosing a tab stops the auto-cycle

    // Restart CSS animations by removing a class, forcing a reflow, adding it back
    const replay = (el, cls) => {
        el.classList.remove(cls);
        void el.offsetWidth;
        el.classList.add(cls);
    };

    const show = (next, { focus = false } = {}) => {
        index = (next + tabs.length) % tabs.length;
        tabs.forEach((tab, i) => {
            const on = i === index;
            tab.setAttribute('aria-selected', String(on));
            tab.tabIndex = on ? 0 : -1;
            panels[i].hidden = !on;
            panels[i].classList.toggle('is-active', on);
        });
        replay(panels[index], 'is-active');
        replay(studio, 'is-running');
        if (focus) tabs[index].focus();
        tabs[index].scrollIntoView({ block: 'nearest', inline: 'nearest' });
    };

    const schedule = (ms) => {
        clearTimeout(timer);
        if (stopped || hovering || !visible || document.hidden) return;
        startedAt = performance.now();
        remaining = ms;
        studio.classList.remove('is-paused');
        timer = setTimeout(() => {
            show(index + 1);
            if (!stopped) {
                replay(studio, 'is-cycling');
                schedule(CYCLE_MS);
            }
        }, ms);
    };

    const pause = () => {
        if (stopped) return;
        clearTimeout(timer);
        remaining = Math.max(400, remaining - (performance.now() - startedAt));
        studio.classList.add('is-paused');
    };

    const resume = () => {
        if (!stopped && !hovering && visible && !document.hidden) schedule(remaining);
    };

    const stop = () => {
        stopped = true;
        clearTimeout(timer);
        studio.classList.remove('is-cycling', 'is-paused');
    };

    tabs.forEach((tab, i) => {
        tab.addEventListener('click', () => {
            stop();
            show(i);
        });
        tab.addEventListener('keydown', (e) => {
            const step = { ArrowRight: 1, ArrowDown: 1, ArrowLeft: -1, ArrowUp: -1 }[e.key];
            if (step) {
                e.preventDefault();
                stop();
                show(i + step, { focus: true });
            } else if (e.key === 'Home' || e.key === 'End') {
                e.preventDefault();
                stop();
                show(e.key === 'Home' ? 0 : tabs.length - 1, { focus: true });
            }
        });
    });

    studio.addEventListener('pointerenter', () => {
        hovering = true;
        pause();
    });
    studio.addEventListener('pointerleave', () => {
        hovering = false;
        resume();
    });
    studio.addEventListener('focusin', () => {
        hovering = true;
        pause();
    });
    studio.addEventListener('focusout', (e) => {
        if (studio.contains(e.relatedTarget)) return;
        hovering = false;
        resume();
    });

    new IntersectionObserver(([entry]) => {
        visible = entry.isIntersecting;
        visible ? resume() : pause();
    }).observe(studio);

    document.addEventListener('visibilitychange', () => (document.hidden ? pause() : resume()));

    if (!stopped) {
        studio.classList.add('is-cycling');
        schedule(CYCLE_MS);
    }
}
