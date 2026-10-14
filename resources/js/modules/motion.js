/*
 * Motion: smooth scrolling, intro, split-text headings, reveals, parallax,
 * pinned horizontal services, stacking process cards, tilt, magnetic buttons
 * and the custom cursor. Skipped entirely for reduced-motion visitors, apart
 * from the scroll progress bar and timeline state.
 */

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { SplitText } from 'gsap/SplitText';
import Lenis from 'lenis';
import { reduceMotion, finePointer } from './env.js';
import { nav } from './navigation.js';

gsap.registerPlugin(ScrollTrigger, SplitText);

const $$ = (selector, scope = document) => [...scope.querySelectorAll(selector)];

/* Smooth scrolling, driven by GSAP's ticker so ScrollTrigger stays in sync */
function initSmoothScroll() {
    const lenis = new Lenis({ lerp: 0.11, anchors: { offset: -80 }, autoRaf: false });
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => lenis.raf(time * 1000));
    gsap.ticker.lagSmoothing(0);
    nav.lenis = lenis;
}

function initProgress() {
    const bar = document.querySelector('[data-progress]');
    if (!bar) return;
    gsap.to(bar, { scaleX: 1, ease: 'none', scrollTrigger: { start: 0, end: 'max', scrub: 0.3 } });
}

/* Hero entrance */
function initIntro() {
    const hero = document.querySelector('.hero');
    if (!hero) return;

    const tl = gsap.timeline({ defaults: { ease: 'expo.out' } });
    tl.from('[data-intro="line"]', { yPercent: 115, duration: 1.3, stagger: 0.12 })
        .from('[data-intro="fade"]', { y: 30, autoAlpha: 0, duration: 1, stagger: 0.08 }, 0.35)
        .from('[data-intro="orb"]', { scale: 0.6, autoAlpha: 0, duration: 1.6 }, 0.1)
        .from('[data-intro="browser"]', { y: 80, rotateX: -18, autoAlpha: 0, duration: 1.4 }, 0.3)
        .from('[data-intro="phone"]', { y: 120, autoAlpha: 0, duration: 1.4 }, 0.45)
        .from('[data-intro="card"]', { scale: 0.7, autoAlpha: 0, duration: 1, stagger: 0.12, ease: 'back.out(1.6)' }, 0.7);
}

/* Rotating specialty word in the hero */
function initRotator() {
    const rotator = document.querySelector('[data-rotator]');
    if (!rotator) return;

    const words = $$('.rotator__word', rotator);
    let index = 0;

    setInterval(() => {
        if (document.hidden) return;
        const current = words[index];
        index = (index + 1) % words.length;
        current.classList.remove('is-active');
        current.classList.add('is-leaving');
        words[index].classList.add('is-active');
        setTimeout(() => current.classList.remove('is-leaving'), 800);
    }, 2600);
}

/* Pointer parallax for the hero scene layers */
function initSceneParallax() {
    const scene = document.querySelector('[data-scene]');
    if (!scene || !finePointer) return;

    const layers = $$('[data-depth]', scene).map((el) => ({
        depth: parseFloat(el.dataset.depth),
        x: gsap.quickTo(el, 'x', { duration: 1.2, ease: 'power3' }),
        y: gsap.quickTo(el, 'y', { duration: 1.2, ease: 'power3' }),
    }));

    window.addEventListener('pointermove', (e) => {
        const dx = e.clientX / innerWidth - 0.5;
        const dy = e.clientY / innerHeight - 0.5;
        layers.forEach((l) => {
            l.x(dx * l.depth * -40);
            l.y(dy * l.depth * -30);
        });
    });

    // The scene drifts up and apart as the hero scrolls away
    gsap.to(scene, {
        yPercent: -12,
        ease: 'none',
        scrollTrigger: { trigger: '.hero', start: 'top top', end: 'bottom top', scrub: true },
    });
}

/* Elements that move at a different speed to the page */
function initParallax() {
    $$('[data-parallax]').forEach((el) => {
        const speed = parseFloat(el.dataset.parallax) || 0.2;
        gsap.to(el, {
            yPercent: speed * -100,
            ease: 'none',
            scrollTrigger: { trigger: el.closest('section') || el, start: 'top bottom', end: 'bottom top', scrub: true },
        });
    });
}

/* Headings rise line by line as they enter */
function initSplitHeadings() {
    $$('[data-split]').forEach((el) => {
        SplitText.create(el, {
            type: 'lines,words',
            mask: 'lines',
            linesClass: 'split-line',
            autoSplit: true,
            onSplit(self) {
                return gsap.from(self.lines, {
                    yPercent: 110,
                    duration: 1.2,
                    stagger: 0.1,
                    ease: 'expo.out',
                    scrollTrigger: { trigger: el, start: 'top 88%', once: true },
                });
            },
        });
    });
}

/* Fade and rise on enter, batched so neighbours stagger */
function initReveals() {
    const items = $$('[data-reveal]');
    if (!items.length) return;

    gsap.set(items, { autoAlpha: 0, y: 40 });
    ScrollTrigger.batch(items, {
        start: 'top 90%',
        once: true,
        onEnter: (batch) =>
            gsap.to(batch, { autoAlpha: 1, y: 0, duration: 1.1, stagger: 0.09, ease: 'expo.out', clearProps: 'transform' }),
    });
}

/* Statement: words light up as you read */
function initScrubText() {
    $$('[data-scrub]').forEach((el) => {
        const split = SplitText.create(el, { type: 'words', wordsClass: 'word' });
        gsap.to(split.words, {
            opacity: 1,
            stagger: 0.1,
            ease: 'none',
            scrollTrigger: { trigger: el, start: 'top 80%', end: 'bottom 45%', scrub: true },
        });
    });
}

/* Services: pinned horizontal scroll on large screens, swipe elsewhere */
function initHorizontal() {
    const section = document.querySelector('[data-hscroll]');
    if (!section) return;

    const viewport = section.querySelector('[data-hscroll-viewport]');
    const track = section.querySelector('[data-hscroll-track]');
    const progress = section.querySelector('[data-hscroll-progress]');

    viewport.addEventListener(
        'scroll',
        () => progress?.style.setProperty('--p', viewport.scrollLeft / (viewport.scrollWidth - viewport.clientWidth || 1)),
        { passive: true },
    );

    gsap.matchMedia().add('(min-width: 1024px) and (min-height: 700px)', () => {
        section.classList.add('is-pinned');
        const distance = () => Math.max(0, track.scrollWidth - window.innerWidth);

        gsap.to(track, {
            x: () => -distance(),
            ease: 'none',
            scrollTrigger: {
                trigger: section,
                start: 'center center',
                end: () => `+=${distance()}`,
                pin: true,
                scrub: 0.8,
                invalidateOnRefresh: true,
                onUpdate: (self) => progress?.style.setProperty('--p', self.progress.toFixed(3)),
            },
        });

        return () => section.classList.remove('is-pinned');
    });
}

/* Process cards shrink back as the next one stacks on top */
function initStack() {
    const cards = $$('[data-stack] .stack-card');
    cards.slice(0, -1).forEach((card, i) => {
        gsap.to(card, {
            scale: 0.94,
            ease: 'none',
            scrollTrigger: { trigger: cards[i + 1], start: 'top 85%', end: 'top 25%', scrub: true },
        });
    });
}

/* Draw chart lines when they come into view */
function initDraw() {
    $$('[data-draw] .line--a, [data-draw] .line--b').forEach((path) => {
        const length = path.getTotalLength();
        gsap.fromTo(
            path,
            { strokeDasharray: length, strokeDashoffset: length },
            { strokeDashoffset: 0, duration: 2.2, ease: 'power2.inOut', scrollTrigger: { trigger: path, start: 'top 85%', once: true } },
        );
    });
}

/* Footer wordmark letters rise in */
function initFooter() {
    const word = document.querySelector('[data-footer-word]');
    if (!word) return;
    gsap.from(word.children, {
        yPercent: 60,
        opacity: 0,
        stagger: 0.04,
        ease: 'none',
        scrollTrigger: { trigger: word, start: 'top bottom', end: 'bottom bottom', scrub: true },
    });
}

/* 3D tilt and spotlight following the pointer */
function initTilt() {
    if (!finePointer) return;

    $$('[data-tilt], [data-spotlight]').forEach((el) => {
        const tilt = el.hasAttribute('data-tilt');
        el.addEventListener('pointermove', (e) => {
            const r = el.getBoundingClientRect();
            const px = (e.clientX - r.left) / r.width;
            const py = (e.clientY - r.top) / r.height;
            el.style.setProperty('--mx', `${px * 100}%`);
            el.style.setProperty('--my', `${py * 100}%`);
            if (tilt) {
                el.style.setProperty('--rx', `${(px - 0.5) * 8}deg`);
                el.style.setProperty('--ry', `${(0.5 - py) * 8}deg`);
            }
        });
        el.addEventListener('pointerleave', () => {
            el.style.setProperty('--rx', '0deg');
            el.style.setProperty('--ry', '0deg');
        });
    });
}

/* Buttons lean towards the pointer */
function initMagnetic() {
    if (!finePointer) return;

    $$('[data-magnetic]').forEach((el) => {
        const x = gsap.quickTo(el, 'x', { duration: 0.6, ease: 'power3' });
        const y = gsap.quickTo(el, 'y', { duration: 0.6, ease: 'power3' });
        el.addEventListener('pointermove', (e) => {
            const r = el.getBoundingClientRect();
            x((e.clientX - r.left - r.width / 2) * 0.3);
            y((e.clientY - r.top - r.height / 2) * 0.4);
        });
        el.addEventListener('pointerleave', () => {
            gsap.to(el, { x: 0, y: 0, duration: 0.9, ease: 'elastic.out(1, 0.4)' });
        });
    });
}

/* A soft ring that follows the pointer and labels interactive cards */
function initCursor() {
    const cursor = document.querySelector('[data-cursor-el]');
    if (!cursor || !finePointer) return;

    document.documentElement.classList.add('has-cursor');
    const ring = cursor.querySelector('.cursor__ring');
    const dot = cursor.querySelector('.cursor__dot');
    const label = cursor.querySelector('.cursor__label');
    const ringX = gsap.quickTo(ring, 'x', { duration: 0.5, ease: 'power3' });
    const ringY = gsap.quickTo(ring, 'y', { duration: 0.5, ease: 'power3' });
    const dotX = gsap.quickTo(dot, 'x', { duration: 0.1 });
    const dotY = gsap.quickTo(dot, 'y', { duration: 0.1 });

    window.addEventListener('pointermove', (e) => {
        cursor.classList.remove('is-hidden');
        ringX(e.clientX);
        ringY(e.clientY);
        dotX(e.clientX);
        dotY(e.clientY);
    });

    document.addEventListener('pointerover', (e) => {
        const labelled = e.target.closest('[data-cursor]:not([data-cursor="hover"])');
        const interactive = e.target.closest('a, button, label, [data-cursor], input, select, textarea');
        const text = labelled?.dataset.cursor;

        cursor.classList.toggle('is-label', Boolean(text));
        cursor.classList.toggle('is-hover', !text && Boolean(interactive));
        if (text) label.textContent = text;
    });

    document.addEventListener('pointerleave', () => cursor.classList.add('is-hidden'));
    document.addEventListener('pointerenter', () => cursor.classList.remove('is-hidden'));
}

/* Service-page timeline fills as you scroll past it */
function initTimeline() {
    const timeline = document.querySelector('[data-timeline]');
    if (!timeline) return;

    const steps = $$('.step', timeline);
    const track = timeline.querySelector('.timeline__track span');

    if (reduceMotion) {
        steps.forEach((s) => s.classList.add('is-active'));
        track?.style.setProperty('--progress', 1);
        return;
    }

    ScrollTrigger.create({
        trigger: timeline,
        start: 'top 80%',
        end: 'bottom 50%',
        scrub: true,
        onUpdate(self) {
            track?.style.setProperty('--progress', self.progress.toFixed(3));
            steps.forEach((step, i) => step.classList.toggle('is-active', self.progress >= i / steps.length));
        },
    });
}

export function initMotion() {
    initProgress();
    initTimeline();

    if (reduceMotion) return;

    initSmoothScroll();
    initIntro();
    initRotator();
    initSceneParallax();
    initParallax();
    initSplitHeadings();
    initReveals();
    initScrubText();
    initHorizontal();
    initStack();
    initDraw();
    initFooter();
    initTilt();
    initMagnetic();
    initCursor();

    // Fonts change line breaks and heights; re-measure once they are ready.
    document.fonts?.ready.then(() => ScrollTrigger.refresh());
}
