{{-- Motion layer: scroll reveals, hero word-by-word title, hero parallax,
     magnetic buttons, card cursor spotlight and press feedback.
     Uses the Web Animations API only (no extra library). Respects reduced motion. --}}
<style>
    .mo-hidden {
        opacity: 0;
    }

    .mo-word {
        display: inline-block;
        will-change: transform, opacity;
    }

    .mo-btn {
        will-change: translate;
    }

    .mo-spot {
        position: relative;
        isolation: isolate;
    }

    /* Soft light that follows the cursor across a card */
    .mo-spot::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: -1;
        border-radius: inherit;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.4s ease;
        background: radial-gradient(360px circle at var(--mo-x, 50%) var(--mo-y, 50%), rgba(255, 255, 255, 0.09), transparent 60%);
    }

    .mo-spot:hover::before {
        opacity: 1;
    }

    @media (prefers-reduced-motion: reduce) {
        .mo-spot::before {
            display: none;
        }
    }
</style>

<script>
    (function () {
        const run = () => {
            const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const fine = window.matchMedia('(pointer: fine)').matches;
            const ease = 'cubic-bezier(0.16, 1, 0.3, 1)';

            // Nothing moves for people who turned off motion. Content stays visible.
            if (reduce) return;

            const escapeHtml = (text) => text.replace(/[&<>"']/g, (c) => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;',
            }[c]));

            // 1. Hero headline: split into words and rise one by one
            const headline = document.querySelector('#home h1');
            if (headline) {
                const text = headline.textContent.trim();
                headline.setAttribute('aria-label', text);
                headline.innerHTML = text
                    .split(/\s+/)
                    .map((word) => `<span class="mo-word" aria-hidden="true">${escapeHtml(word)}</span>`)
                    .join(' ');

                headline.querySelectorAll('.mo-word').forEach((word, i) => {
                    word.animate(
                        [
                            { opacity: 0, translate: '0 0.6em' },
                            { opacity: 1, translate: '0 0' },
                        ],
                        { duration: 900, delay: 150 + i * 90, easing: ease, fill: 'backwards' }
                    );
                });
            }

            // 2. Scroll reveals: each section's headings, text, cards and list items rise in with a stagger
            document.querySelectorAll('main > section:not(#home)').forEach((section) => {
                const found = [...section.querySelectorAll('h2, h3, p, article, li, [data-tilt], a.inline-flex')]
                    .filter((el) => !el.closest('[role="dialog"]'));

                // Keep only the outermost elements, so nested items do not animate twice
                const items = found.filter((el) => !found.some((other) => other !== el && other.contains(el)));
                if (!items.length) return;

                items.forEach((el) => el.classList.add('mo-hidden'));

                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) return;

                        items.forEach((el, i) => {
                            el.classList.remove('mo-hidden');
                            el.animate(
                                [
                                    { opacity: 0, translate: '0 28px' },
                                    { opacity: 1, translate: '0 0' },
                                ],
                                { duration: 820, delay: Math.min(i, 14) * 70, easing: ease, fill: 'backwards' }
                            );
                        });

                        obs.unobserve(entry.target);
                    });
                }, { threshold: 0.12 });

                observer.observe(section);
            });

            // 3. Hero: the orbit drifts and fades as you scroll away, the text moves slightly the other way
            const hero = document.getElementById('home');
            const orbit = hero ? hero.querySelector('.hero-orbit-shell') : null;
            const copy = hero ? hero.querySelector('.lg\\:col-span-7') : null;

            if (hero && (orbit || copy)) {
                let ticking = false;

                const updateParallax = () => {
                    const rect = hero.getBoundingClientRect();
                    const progress = Math.min(Math.max(-rect.top / rect.height, 0), 1);

                    if (orbit) {
                        orbit.style.translate = `0 ${(progress * 120).toFixed(1)}px`;
                        orbit.style.opacity = String(1 - progress * 0.7);
                    }

                    if (copy) {
                        copy.style.translate = `0 ${(progress * -50).toFixed(1)}px`;
                    }

                    ticking = false;
                };

                window.addEventListener('scroll', () => {
                    if (!ticking) {
                        ticking = true;
                        requestAnimationFrame(updateParallax);
                    }
                }, { passive: true });

                updateParallax();
            }

            // 4. Magnetic buttons and press feedback (mouse only)
            if (fine) {
                document.querySelectorAll('main a.inline-flex, main button[type="submit"]').forEach((el) => {
                    el.classList.add('mo-btn');

                    el.addEventListener('pointermove', (event) => {
                        const rect = el.getBoundingClientRect();
                        const x = event.clientX - rect.left - rect.width / 2;
                        const y = event.clientY - rect.top - rect.height / 2;
                        el.style.translate = `${(x * 0.18).toFixed(1)}px ${(y * 0.18).toFixed(1)}px`;
                    });

                    el.addEventListener('pointerleave', () => {
                        el.style.translate = '';
                    });

                    el.addEventListener('pointerdown', () => {
                        el.animate(
                            [{ scale: '1' }, { scale: '0.96' }, { scale: '1' }],
                            { duration: 280, easing: ease }
                        );
                    });
                });
            }

            // 5. Cursor spotlight on cards (mouse only)
            if (fine) {
                document.querySelectorAll('main > section:not(#home) article, main > section:not(#home) [data-tilt]').forEach((card) => {
                    card.classList.add('mo-spot');

                    card.addEventListener('pointermove', (event) => {
                        const rect = card.getBoundingClientRect();
                        card.style.setProperty('--mo-x', `${event.clientX - rect.left}px`);
                        card.style.setProperty('--mo-y', `${event.clientY - rect.top}px`);
                    });
                });
            }
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', run);
        } else {
            run();
        }
    })();
</script>