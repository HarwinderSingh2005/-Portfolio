import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

/* 3D tilt effect on cards (mouse only). */
document.querySelectorAll('[data-tilt]').forEach((card) => {
    const maxTilt = Number(card.dataset.tilt) || 4;

    card.addEventListener('pointermove', (e) => {
        if (e.pointerType !== 'mouse') return;
        const rect = card.getBoundingClientRect();
        const x = (e.clientX - rect.left) / rect.width - 0.5;
        const y = (e.clientY - rect.top) / rect.height - 0.5;
        card.style.transform = `perspective(900px) rotateX(${(-y * maxTilt * 2).toFixed(2)}deg) rotateY(${(x * maxTilt * 2).toFixed(2)}deg)`;
    });

    card.addEventListener('pointerleave', () => {
        card.style.transform = 'perspective(900px) rotateX(0deg) rotateY(0deg)';
    });
});

/* Fade sections in when they scroll into view. */
const revealObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    },
    { threshold: 0.12 },
);
document.querySelectorAll('[data-reveal]').forEach((el) => revealObserver.observe(el));

/* Highlight the navbar link of the section currently on screen. */
const navLinks = document.querySelectorAll('[data-nav]');
const sectionObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            navLinks.forEach((link) => {
                link.dataset.active = String(link.dataset.nav === entry.target.id);
            });
        });
    },
    { rootMargin: '-40% 0px -55% 0px' },
);
['about', 'skills', 'projects', 'experience', 'services'].forEach((id) => {
    const section = document.getElementById(id);
    if (section) sectionObserver.observe(section);
});
