import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const motionOk = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const toggle = document.querySelector('[data-nav-toggle]');
    const nav = document.getElementById('site-nav');
    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            const open = nav.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggle.textContent = open ? 'Close' : 'Menu';
        });
    }

    const catRoot = document.querySelector('[data-cat-select]');
    if (catRoot) {
        const catBtn = catRoot.querySelector('[data-cat-toggle]');
        const catMenu = catRoot.querySelector('[data-cat-menu]');
        const catLabel = catRoot.querySelector('[data-cat-label]');
        const catInput = catRoot.querySelector('[data-cat-input]');
        const searchBar = catRoot.closest('.search-cat');

        const setCatOpen = (open) => {
            catRoot.classList.toggle('is-open', open);
            searchBar?.classList.toggle('is-picking', open);
            catBtn?.setAttribute('aria-expanded', open ? 'true' : 'false');
        };

        catBtn?.addEventListener('click', (event) => {
            event.preventDefault();
            setCatOpen(!catRoot.classList.contains('is-open'));
        });

        catMenu?.querySelectorAll('[data-value]').forEach((option) => {
            option.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();
                const value = option.getAttribute('data-value') ?? '';
                if (catInput) {
                    catInput.value = value;
                }
                if (catLabel) {
                    catLabel.textContent = option.textContent.trim();
                }
                catMenu.querySelectorAll('[data-value]').forEach((item) => item.classList.remove('is-active'));
                option.classList.add('is-active');
                setCatOpen(false);
                searchBar?.requestSubmit();
            });
        });

        document.addEventListener('click', (event) => {
            if (!catRoot.contains(event.target)) {
                setCatOpen(false);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                setCatOpen(false);
            }
        });
    }

    const markReveal = (el, index = 0) => {
        el.classList.add('reveal');
        el.style.setProperty('--stagger', String(Math.min(index, 12)));
    };

    document.querySelectorAll('.cat-row, .product-grid, .s3-grid4, .s3-popgrid, .mid-banners, .s3-feats, .footer-perks, .s3-relgrid').forEach((group) => {
        [...group.children].forEach((child, index) => markReveal(child, index));
    });

    document.querySelectorAll('.section-head, .hero-grid, .s3-auth-form, .s3-gallery, .s3-promo, .s3-pcard, .s3-infocard, .s3-paycard, .s3-summary, .s3-sidebox, .subscribe, .s3-feat, .banner, .promo-side').forEach((el, index) => {
        if (!el.classList.contains('reveal')) {
            markReveal(el, index % 6);
        }
    });

    const revealNodes = document.querySelectorAll('.reveal');
    revealNodes.forEach((node) => {
        const box = node.getBoundingClientRect();
        if (box.top < window.innerHeight * 0.92) {
            node.classList.add('is-in');
        }
    });

    if (motionOk && 'IntersectionObserver' in window) {
        document.documentElement.classList.add('has-motion');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-in');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
        revealNodes.forEach((node) => {
            if (!node.classList.contains('is-in')) {
                observer.observe(node);
            }
        });
    } else {
        revealNodes.forEach((node) => node.classList.add('is-in'));
    }

    const root = document.querySelector('[data-hero]');
    if (!root) {
        return;
    }

    const slides = [...root.querySelectorAll('.hero-slide')];
    if (slides.length < 2) {
        return;
    }

    let index = slides.findIndex((slide) => slide.classList.contains('is-active'));
    if (index < 0) {
        index = 0;
        slides[0].classList.add('is-active');
    }

    const show = (next) => {
        slides[index].classList.remove('is-active');
        index = (next + slides.length) % slides.length;
        slides[index].classList.add('is-active');
    };

    root.querySelector('[data-hero-prev]')?.addEventListener('click', () => show(index - 1));
    root.querySelector('[data-hero-next]')?.addEventListener('click', () => show(index + 1));
    setInterval(() => show(index + 1), 5000);
});
