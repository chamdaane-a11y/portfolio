/* =====================================================
   ENHANCE.JS — Interactivité premium
   - Fond aurora + particules (canvas)
   - Curseur personnalisé magnétique
   - Barre de progression de scroll
   - Reveal au scroll (IntersectionObserver)
   - Effet machine à écrire (hero)
   - Barres de compétences animées
   - Tilt 3D + glow suiveur sur les cartes
   - Ripple sur les boutons
   Respecte prefers-reduced-motion.
===================================================== */
(function () {
    'use strict';

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const finePointer  = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

    /* ---------- helper ---------- */
    const $  = (s, c = document) => c.querySelector(s);
    const $$ = (s, c = document) => Array.from(c.querySelectorAll(s));

    document.addEventListener('DOMContentLoaded', init);

    function init() {
        buildBackground();
        buildScrollProgress();
        buildCursor();
        setupReveal();
        setupTyping();
        setupSkillBars();
        setupTilt();
        setupRipple();
        setupCarousel();
    }

    /* =====================================================
       FOND : aurora blobs + particules canvas
    ===================================================== */
    function buildBackground() {
        if (reduceMotion) return;

        // Aurora blobs
        ['b1', 'b2', 'b3'].forEach(cls => {
            const blob = document.createElement('div');
            blob.className = 'aurora-blob ' + cls;
            document.body.appendChild(blob);
        });

        // Canvas particules
        const canvas = document.createElement('canvas');
        canvas.id = 'fx-particles';
        document.body.appendChild(canvas);
        const ctx = canvas.getContext('2d');

        let w, h, particles;
        const COUNT = Math.min(70, Math.floor(window.innerWidth / 22));
        const mouse = { x: -9999, y: -9999 };

        function resize() {
            w = canvas.width  = window.innerWidth;
            h = canvas.height = window.innerHeight;
            particles = Array.from({ length: COUNT }, () => ({
                x: Math.random() * w,
                y: Math.random() * h,
                vx: (Math.random() - 0.5) * 0.4,
                vy: (Math.random() - 0.5) * 0.4,
                r: Math.random() * 1.8 + 0.6
            }));
        }
        resize();
        window.addEventListener('resize', resize);
        window.addEventListener('mousemove', e => { mouse.x = e.clientX; mouse.y = e.clientY; });

        function tick() {
            ctx.clearRect(0, 0, w, h);

            for (let i = 0; i < particles.length; i++) {
                const p = particles[i];
                p.x += p.vx; p.y += p.vy;
                if (p.x < 0 || p.x > w) p.vx *= -1;
                if (p.y < 0 || p.y > h) p.vy *= -1;

                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(89, 193, 255, 0.55)';
                ctx.fill();

                // liens entre particules proches
                for (let j = i + 1; j < particles.length; j++) {
                    const q = particles[j];
                    const dx = p.x - q.x, dy = p.y - q.y;
                    const dist = dx * dx + dy * dy;
                    if (dist < 13000) {
                        ctx.beginPath();
                        ctx.moveTo(p.x, p.y);
                        ctx.lineTo(q.x, q.y);
                        ctx.strokeStyle = 'rgba(89, 193, 255,' + (0.12 * (1 - dist / 13000)) + ')';
                        ctx.lineWidth = 1;
                        ctx.stroke();
                    }
                }
                // lien vers la souris
                const mdx = p.x - mouse.x, mdy = p.y - mouse.y;
                const mdist = mdx * mdx + mdy * mdy;
                if (mdist < 22000) {
                    ctx.beginPath();
                    ctx.moveTo(p.x, p.y);
                    ctx.lineTo(mouse.x, mouse.y);
                    ctx.strokeStyle = 'rgba(123, 107, 255,' + (0.22 * (1 - mdist / 22000)) + ')';
                    ctx.lineWidth = 1;
                    ctx.stroke();
                }
            }
            requestAnimationFrame(tick);
        }
        tick();
    }

    /* =====================================================
       BARRE DE PROGRESSION SCROLL
    ===================================================== */
    function buildScrollProgress() {
        const bar = document.createElement('div');
        bar.id = 'scroll-progress';
        document.body.appendChild(bar);

        const update = () => {
            const st = document.documentElement.scrollTop || document.body.scrollTop;
            const sh = (document.documentElement.scrollHeight || document.body.scrollHeight) - window.innerHeight;
            bar.style.width = (sh > 0 ? (st / sh) * 100 : 0) + '%';
        };
        window.addEventListener('scroll', update, { passive: true });
        update();
    }

    /* =====================================================
       CURSEUR PERSONNALISÉ
    ===================================================== */
    function buildCursor() {
        if (!finePointer || reduceMotion) return;

        document.body.classList.add('custom-cursor');
        const dot  = document.createElement('div'); dot.id  = 'cursor-dot';
        const ring = document.createElement('div'); ring.id = 'cursor-ring';
        document.body.appendChild(dot);
        document.body.appendChild(ring);

        let mx = 0, my = 0, rx = 0, ry = 0;
        window.addEventListener('mousemove', e => {
            mx = e.clientX; my = e.clientY;
            dot.style.transform = `translate(${mx}px, ${my}px) translate(-50%, -50%)`;
        });

        (function follow() {
            rx += (mx - rx) * 0.18;
            ry += (my - ry) * 0.18;
            ring.style.transform = `translate(${rx}px, ${ry}px) translate(-50%, -50%)`;
            requestAnimationFrame(follow);
        })();

        const hoverSel = 'a, button, input, textarea, select, .skill-card, .project-card, .social-link';
        document.addEventListener('mouseover', e => {
            if (e.target.closest(hoverSel)) ring.classList.add('hovering');
        });
        document.addEventListener('mouseout', e => {
            if (e.target.closest(hoverSel)) ring.classList.remove('hovering');
        });
    }

    /* =====================================================
       REVEAL AU SCROLL
    ===================================================== */
    function setupReveal() {
        const els = $$('.reveal');
        if (!els.length) return;

        if (reduceMotion || !('IntersectionObserver' in window)) {
            els.forEach(el => el.classList.add('in-view'));
            return;
        }
        const io = new IntersectionObserver((entries) => {
            entries.forEach(en => {
                if (en.isIntersecting) {
                    en.target.classList.add('in-view');
                    io.unobserve(en.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

        els.forEach(el => io.observe(el));
    }

    /* =====================================================
       EFFET MACHINE À ÉCRIRE
       <span class="type-target" data-words="A|B|C"></span>
    ===================================================== */
    function setupTyping() {
        const el = $('.type-target');
        if (!el) return;
        const words = (el.dataset.words || el.textContent).split('|').map(s => s.trim()).filter(Boolean);
        if (!words.length) return;

        if (reduceMotion) { el.textContent = words[0]; el.classList.remove('type-target'); return; }

        el.textContent = '';
        let wi = 0, ci = 0, deleting = false;

        function step() {
            const word = words[wi];
            el.textContent = word.slice(0, ci);

            if (!deleting && ci < word.length) {
                ci++;
                setTimeout(step, 80);
            } else if (!deleting && ci === word.length) {
                deleting = true;
                setTimeout(step, words.length > 1 ? 1600 : 100000);
            } else if (deleting && ci > 0) {
                ci--;
                setTimeout(step, 40);
            } else {
                deleting = false;
                wi = (wi + 1) % words.length;
                setTimeout(step, 250);
            }
        }
        step();
    }

    /* =====================================================
       BARRES DE COMPÉTENCES
    ===================================================== */
    function setupSkillBars() {
        const bars = $$('.skill-bar > span');
        if (!bars.length) return;

        const fill = (span) => {
            const pct = span.parentElement.dataset.level || span.dataset.level || '70';
            span.style.width = Math.max(0, Math.min(100, parseInt(pct, 10))) + '%';
        };

        if (reduceMotion || !('IntersectionObserver' in window)) {
            bars.forEach(fill);
            return;
        }
        const io = new IntersectionObserver((entries) => {
            entries.forEach(en => {
                if (en.isIntersecting) { fill(en.target); io.unobserve(en.target); }
            });
        }, { threshold: 0.4 });
        bars.forEach(b => io.observe(b));
    }

    /* =====================================================
       TILT 3D + GLOW SUIVEUR (cartes)
    ===================================================== */
    function setupTilt() {
        if (!finePointer || reduceMotion) return;
        // Les cartes projet du carrousel sont pilotées par setupCarousel → on les exclut
        const cards = $$('.skill-card');

        cards.forEach(card => {
            card.addEventListener('mousemove', e => {
                const r = card.getBoundingClientRect();
                const px = (e.clientX - r.left) / r.width;
                const py = (e.clientY - r.top) / r.height;
                const rotX = (0.5 - py) * 8;
                const rotY = (px - 0.5) * 8;
                card.style.transform =
                    `translateY(-6px) perspective(800px) rotateX(${rotX}deg) rotateY(${rotY}deg)`;
                card.style.setProperty('--mx', (px * 100) + '%');
                card.style.setProperty('--my', (py * 100) + '%');
            });
            card.addEventListener('mouseleave', () => { card.style.transform = ''; });
        });
    }

    /* =====================================================
       RIPPLE BOUTONS
    ===================================================== */
    function setupRipple() {
        document.addEventListener('click', e => {
            const btn = e.target.closest('.btn, .btn-submit, .btn-switch');
            if (!btn) return;
            const r = btn.getBoundingClientRect();
            const size = Math.max(r.width, r.height);
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - r.left - size / 2) + 'px';
            ripple.style.top  = (e.clientY - r.top  - size / 2) + 'px';
            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 650);
        });
    }

    /* =====================================================
       CARROUSEL 3D (coverflow)
    ===================================================== */
    function setupCarousel() {
        const root = $('.carousel-3d');
        if (!root) return;
        const cards = $$('.project-card', root);
        const n = cards.length;
        if (!n) return;

        const prevBtn  = $('.car-prev', root);
        const nextBtn  = $('.car-next', root);
        const dotsWrap = $('.car-dots', root);
        let active = 0;

        // Construit les points
        if (dotsWrap) {
            cards.forEach((_, i) => {
                const d = document.createElement('button');
                d.type = 'button';
                d.setAttribute('aria-label', 'Aller au projet ' + (i + 1));
                d.addEventListener('click', () => go(i));
                dotsWrap.appendChild(d);
            });
        }
        const dots = dotsWrap ? $$('button', dotsWrap) : [];

        function render() {
            cards.forEach((card, i) => {
                let offset = i - active;
                if (offset >  n / 2) offset -= n;   // wrap circulaire
                if (offset < -n / 2) offset += n;

                const abs  = Math.abs(offset);
                const sign = Math.sign(offset);
                let tx, scale, rot, op, z;

                if (offset === 0)      { tx = 0;          scale = 1;    rot = 0;          op = 1;    z = 30; }
                else if (abs === 1)    { tx = sign * 60;  scale = 0.8;  rot = -sign * 34; op = 0.6;  z = 20; }
                else if (abs === 2)    { tx = sign * 104; scale = 0.66; rot = -sign * 42; op = 0.3;  z = 10; }
                else                   { tx = sign * 128; scale = 0.5;  rot = -sign * 48; op = 0;    z = 0;  }

                card.style.transform =
                    `translateX(${tx}%) translateY(-50%) scale(${scale}) rotateY(${rot}deg)`;
                card.style.opacity = op;
                card.style.zIndex = z;
                card.style.pointerEvents = abs <= 2 ? 'auto' : 'none';
                card.classList.toggle('is-active', offset === 0);
            });
            dots.forEach((d, i) => d.classList.toggle('active', i === active));
        }

        function go(i)  { active = (i % n + n) % n; render(); }
        function next() { go(active + 1); }
        function prev() { go(active - 1); }

        if (nextBtn) nextBtn.addEventListener('click', () => { next(); kick(); });
        if (prevBtn) prevBtn.addEventListener('click', () => { prev(); kick(); });

        // Clic sur une carte latérale → la mettre au centre (sans suivre le lien)
        cards.forEach((card, i) => {
            card.addEventListener('click', e => {
                if (i !== active) { e.preventDefault(); go(i); kick(); }
            });
        });

        // Navigation clavier (← →) hors champ de saisie
        document.addEventListener('keydown', e => {
            if (/^(INPUT|TEXTAREA|SELECT)$/.test(document.activeElement.tagName)) return;
            if (e.key === 'ArrowLeft')  { prev(); kick(); }
            if (e.key === 'ArrowRight') { next(); kick(); }
        });

        // Glisser / swipe
        let startX = null;
        const stage = $('.carousel-stage', root);
        stage.addEventListener('pointerdown', e => { startX = e.clientX; });
        stage.addEventListener('pointerup', e => {
            if (startX === null) return;
            const dx = e.clientX - startX;
            if (Math.abs(dx) > 45) { dx < 0 ? next() : prev(); kick(); }
            startX = null;
        });

        // Lecture automatique
        let timer = null;
        const delay = parseInt(root.dataset.autoplay, 10);
        function play() { if (delay && !reduceMotion) timer = setInterval(next, delay); }
        function stop() { if (timer) { clearInterval(timer); timer = null; } }
        function kick() { stop(); play(); }   // relance le minuteur après une interaction
        root.addEventListener('mouseenter', stop);
        root.addEventListener('mouseleave', play);

        render();
        play();
    }
})();
