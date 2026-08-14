/*
 * Sonnac Lanka Enterprises — scroll/entrance motion.
 * Annotate markup with data-motion attributes; no per-page JS needed.
 *   data-motion="hero"          -> fades/rises in on page load, staggered
 *   data-motion="reveal"        -> fades/rises in once scrolled into view
 *   data-motion="split-reveal"  -> headline splits into words, staggers in on load/scroll
 *   data-motion-group + child [data-motion="grid-item"] -> staggered grid reveal on scroll
 *   data-motion="parallax" data-parallax-speed="0.3" -> background layer drifts on scroll
 *   data-motion="counter" data-count-to="120" [data-count-suffix="+"] -> number ticks up on scroll into view
 *   data-motion="pin-reveal" -> pins section briefly while its content animates in (use sparingly, max 1-2 per page)
 */
document.addEventListener('DOMContentLoaded', function () {
    if (typeof gsap === 'undefined') return;

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
    }

    if (reduceMotion) {
        // Counters still need their final value set even with motion off.
        document.querySelectorAll('[data-motion="counter"]').forEach(function (el) {
            var target = parseFloat(el.getAttribute('data-count-to') || '0');
            el.textContent = target + (el.getAttribute('data-count-suffix') || '');
        });
        return;
    }

    var heroEls = document.querySelectorAll('[data-motion="hero"]');
    if (heroEls.length) {
        gsap.from(heroEls, {
            opacity: 0,
            y: 24,
            duration: 0.6,
            stagger: 0.08,
            ease: 'power2.out'
        });
    }

    document.querySelectorAll('[data-motion="reveal"]').forEach(function (el) {
        gsap.from(el, {
            opacity: 0,
            y: 24,
            duration: 0.5,
            ease: 'power1.out',
            scrollTrigger: {
                trigger: el,
                start: 'top 88%',
                toggleActions: 'play none none reverse'
            }
        });
    });

    document.querySelectorAll('[data-motion-group]').forEach(function (group) {
        var items = group.querySelectorAll('[data-motion="grid-item"]');
        if (!items.length) return;
        gsap.from(items, {
            opacity: 0,
            y: 20,
            scale: 0.94,
            duration: 0.5,
            stagger: { each: 0.07, from: 'start' },
            ease: 'back.out(1.4)',
            scrollTrigger: {
                trigger: group,
                start: 'top 85%',
                toggleActions: 'play none none reverse'
            }
        });
    });

    // Word-level headline stagger (no paid SplitText plugin needed).
    // Prefers pre-wrapped <span class="split-word"> children (preserves any
    // inline styling/highlight spans inside them); falls back to auto-wrapping
    // plain text nodes only when no manual .split-word spans are present.
    document.querySelectorAll('[data-motion="split-reveal"]').forEach(function (el) {
        if (el.dataset.splitDone) return;
        if (!el.querySelector('.split-word')) {
            var words = el.textContent.trim().split(/\s+/);
            el.innerHTML = words.map(function (w) {
                return '<span class="split-word" style="display:inline-block;will-change:transform,opacity;">' + w + '</span>';
            }).join(' ');
        }
        el.dataset.splitDone = '1';
        var wordEls = el.querySelectorAll('.split-word');
        var trigger = el.hasAttribute('data-motion-onload') ? null : {
            trigger: el,
            start: 'top 85%',
            toggleActions: 'play none none reverse'
        };
        gsap.from(wordEls, {
            opacity: 0,
            y: 26,
            rotateX: -35,
            duration: 0.55,
            stagger: 0.045,
            ease: 'expo.out',
            scrollTrigger: trigger
        });
    });

    // Parallax drift on background/decorative layers only
    document.querySelectorAll('[data-motion="parallax"]').forEach(function (el) {
        var speed = parseFloat(el.getAttribute('data-parallax-speed') || '0.2');
        gsap.to(el, {
            yPercent: speed * 100,
            ease: 'none',
            scrollTrigger: {
                trigger: el.closest('section') || el.parentElement,
                start: 'top bottom',
                end: 'bottom top',
                scrub: 0.6
            }
        });
    });

    // Animated number counters
    document.querySelectorAll('[data-motion="counter"]').forEach(function (el) {
        var target = parseFloat(el.getAttribute('data-count-to') || '0');
        var suffix = el.getAttribute('data-count-suffix') || '';
        var counter = { val: 0 };
        gsap.to(counter, {
            val: target,
            duration: 1.6,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: el,
                start: 'top 90%',
                toggleActions: 'play none none none'
            },
            onUpdate: function () {
                el.textContent = Math.round(counter.val) + suffix;
            }
        });
    });

    // Pin-and-reveal — cap usage per page (excessive pinning fights native scroll feel)
    document.querySelectorAll('[data-motion="pin-reveal"]').forEach(function (section) {
        var targets = section.querySelectorAll('[data-pin-item]');
        if (!targets.length) return;
        gsap.timeline({
            scrollTrigger: {
                trigger: section,
                start: 'top top+=80',
                end: '+=60%',
                scrub: 1,
                pin: true,
                pinSpacing: true
            }
        }).from(targets, {
            opacity: 0,
            y: 40,
            stagger: 0.15,
            ease: 'none'
        });
    });
});
