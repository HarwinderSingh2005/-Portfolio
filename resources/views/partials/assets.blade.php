{{-- Site assets: fonts, Tailwind (browser CDN), Alpine.js, and a live WebGL "rich aurora"
     background using all accent colours at a balanced brightness. No build step needed. --}}
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Outfit:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<style type="text/tailwindcss">
    @theme {
        --accent-cyan: #22D3EE;
        --accent-indigo: #6366F1;
        --accent-fuchsia: #E879F9;
        --accent-rose: #FB7185;
        --accent-amber: #FACC15;
        --accent-lime: #A3E635;
        --font-display: "Outfit", ui-sans-serif, system-ui, sans-serif;
        --font-sans: "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif;
        --font-mono: "JetBrains Mono", ui-monospace, monospace;
    }

    @layer base {
        html {
            background: #000000;
            color: #ffffff;
            font-family: var(--font-sans);
        }

        body {
            overflow-x: hidden;
            background: #000000;
            color: #ffffff;
        }

        h1, h2, h3, h4 {
            font-family: var(--font-display);
            letter-spacing: -0.025em;
        }
    }
</style>

<style>
    html {
        scroll-behavior: smooth;
        background: #000000;
    }

    body.site-body {
        position: relative;
        min-height: 100vh;
        isolation: isolate;
        background: #000000;
    }

    /* Live background canvas (created by the script below if it is missing) */
    #bg-canvas {
        position: fixed;
        inset: 0;
        z-index: -10;
        display: block;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    /* Film grain on top of the background */
    .grain-overlay {
        position: fixed;
        inset: 0;
        z-index: -9;
        pointer-events: none;
        opacity: 0.06;
        mix-blend-mode: overlay;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 180 180' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.7'/%3E%3C/svg%3E");
        background-size: 180px 180px;
        animation: grain-shift 0.3s steps(2) infinite;
    }

    @keyframes grain-shift {
        0% { transform: translate(0, 0); }
        25% { transform: translate(-2%, 1%); }
        50% { transform: translate(1%, -2%); }
        75% { transform: translate(2%, 2%); }
        100% { transform: translate(-1%, 2%); }
    }

    /* Edge vignette so the content stays readable */
    body.site-body::after {
        position: fixed;
        inset: 0;
        z-index: -8;
        content: "";
        pointer-events: none;
        background:
            linear-gradient(to bottom, rgba(0, 0, 0, 0.45), transparent 30%),
            radial-gradient(ellipse at center, transparent 42%, rgba(0, 0, 0, 0.6) 100%);
    }

    /* CSS fallback when WebGL is not available: colour blobs drifting in blur */
    body.site-body.bg-fallback::before {
        position: fixed;
        inset: -20%;
        z-index: -10;
        content: "";
        pointer-events: none;
        background:
            radial-gradient(ellipse 45% 35% at 25% 35%, color-mix(in srgb, var(--accent-cyan) 28%, transparent), transparent 70%),
            radial-gradient(ellipse 40% 30% at 75% 30%, color-mix(in srgb, var(--accent-fuchsia) 26%, transparent), transparent 70%),
            radial-gradient(ellipse 45% 35% at 55% 80%, color-mix(in srgb, var(--accent-amber) 22%, transparent), transparent 70%),
            #000000;
        filter: blur(48px);
        animation: fallback-aurora 24s ease-in-out infinite alternate;
    }

    body.site-body.bg-fallback #bg-canvas {
        display: none;
    }

    @keyframes fallback-aurora {
        0% { transform: translate3d(-3%, -2%, 0) scale(1); }
        50% { transform: translate3d(3%, 2%, 0) scale(1.08); }
        100% { transform: translate3d(-2%, 3%, 0) scale(1.03); }
    }

    section[id] {
        scroll-margin-top: 84px;
        background-color: transparent;
    }

    [x-cloak] {
        display: none !important;
    }

    :focus-visible {
        outline: 2px solid #ffffff !important;
        outline-offset: 3px !important;
    }

    [data-reveal] {
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.7s ease, transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
    }

    [data-reveal].is-visible {
        opacity: 1;
        transform: none;
    }

    .scroll-progress {
        background: linear-gradient(90deg, var(--accent-cyan), var(--accent-fuchsia));
    }

    .about-code-accent {
        background: linear-gradient(100deg, var(--accent-cyan), var(--accent-indigo), var(--accent-fuchsia));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #000000;
    }

    ::-webkit-scrollbar-thumb {
        border-radius: 9999px;
        background: #404040;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #737373;
    }

    @media (prefers-reduced-motion: reduce) {
        html {
            scroll-behavior: auto !important;
        }

        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            scroll-behavior: auto !important;
            transition-duration: 0.01ms !important;
        }

        [data-reveal] {
            opacity: 1;
            transform: none;
        }

        .grain-overlay {
            animation: none !important;
        }
    }
</style>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

        // Make sure the background layers exist, even if the layout did not add them.
        document.body.classList.add('site-body');

        let canvas = document.getElementById('bg-canvas');
        if (!canvas) {
            canvas = document.createElement('canvas');
            canvas.id = 'bg-canvas';
            canvas.setAttribute('aria-hidden', 'true');
            document.body.prepend(canvas);
        }

        if (!document.querySelector('.grain-overlay')) {
            const grain = document.createElement('div');
            grain.className = 'grain-overlay';
            grain.setAttribute('aria-hidden', 'true');
            document.body.prepend(grain);
        }

        initializeBackground(canvas, reduceMotion);

        // 3D tilt on cards (mouse only)
        document.querySelectorAll('[data-tilt]').forEach((card) => {
            const maxTilt = Number(card.dataset.tilt) || 4;

            card.addEventListener('pointermove', (event) => {
                if (event.pointerType !== 'mouse' || reduceMotion.matches) return;
                const rect = card.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width - 0.5;
                const y = (event.clientY - rect.top) / rect.height - 0.5;
                card.style.transform = `perspective(900px) rotateX(${(-y * maxTilt * 2).toFixed(2)}deg) rotateY(${(x * maxTilt * 2).toFixed(2)}deg)`;
            });

            card.addEventListener('pointerleave', () => {
                card.style.transform = '';
            });
        });

        if ('IntersectionObserver' in window) {
            // Scroll reveal
            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });
            document.querySelectorAll('[data-reveal]').forEach((element) => revealObserver.observe(element));

            // Active nav link (kept for pages that still use data-nav)
            const navLinks = document.querySelectorAll('[data-nav]');
            const ids = [...new Set([...navLinks].map((link) => link.dataset.nav))];
            const sectionObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    navLinks.forEach((link) => {
                        link.dataset.active = String(link.dataset.nav === entry.target.id);
                    });
                });
            }, { rootMargin: '-40% 0px -55% 0px' });

            ids.forEach((id) => {
                const section = document.getElementById(id);
                if (section) sectionObserver.observe(section);
            });
        } else {
            document.querySelectorAll('[data-reveal]').forEach((element) => element.classList.add('is-visible'));
        }

        // Scroll progress bar (used when an element with id="scroll-progress" exists)
        const progress = document.getElementById('scroll-progress');
        if (progress) {
            let scrollFrame = 0;
            const updateProgress = () => {
                if (scrollFrame) return;
                scrollFrame = requestAnimationFrame(() => {
                    const maxScroll = document.documentElement.scrollHeight - window.innerHeight;
                    const amount = maxScroll > 0 ? (window.scrollY / maxScroll) * 100 : 0;
                    progress.style.width = `${amount}%`;
                    scrollFrame = 0;
                });
            };
            window.addEventListener('scroll', updateProgress, { passive: true });
            window.addEventListener('resize', updateProgress);
            updateProgress();
        }
    });

    function initializeBackground(canvas, reduceMotion) {
        const body = document.body;
        let gl = null;

        try {
            gl = canvas.getContext('webgl', { alpha: false, antialias: false, powerPreference: 'low-power' });
        } catch (error) {
            gl = null;
        }

        if (!gl) {
            body.classList.add('bg-fallback');
            return;
        }

        const vertexSource = `
            attribute vec2 a_position;
            varying vec2 v_uv;
            void main() {
                v_uv = a_position * 0.5 + 0.5;
                gl_Position = vec4(a_position, 0.0, 1.0);
            }
        `;

        const fragmentSource = `
            #ifdef GL_FRAGMENT_PRECISION_HIGH
            precision highp float;
            #else
            precision mediump float;
            #endif

            varying vec2 v_uv;
            uniform vec2 u_resolution;
            uniform vec2 u_mouse;
            uniform float u_time;

            float hash(vec2 p) {
                return fract(sin(dot(p, vec2(127.1, 311.7))) * 43758.5453123);
            }

            float valueNoise(vec2 p) {
                vec2 i = floor(p);
                vec2 f = fract(p);
                vec2 u = f * f * (3.0 - 2.0 * f);
                float a = hash(i);
                float b = hash(i + vec2(1.0, 0.0));
                float c = hash(i + vec2(0.0, 1.0));
                float d = hash(i + vec2(1.0, 1.0));
                return mix(mix(a, b, u.x), mix(c, d, u.x), u.y);
            }

            float fbm(vec2 p) {
                float value = 0.0;
                float amp = 0.5;
                for (int i = 0; i < 4; i++) {
                    value += amp * valueNoise(p);
                    p = p * 2.02 + vec2(3.1, 1.7);
                    amp *= 0.5;
                }
                return value;
            }

            // Balanced accent tones: all colours, medium brightness
            vec3 accent(int index) {
                if (index == 0) return vec3(0.12, 0.58, 0.66); // cyan
                if (index == 1) return vec3(0.30, 0.32, 0.84); // indigo
                if (index == 2) return vec3(0.66, 0.26, 0.76); // fuchsia
                if (index == 3) return vec3(0.74, 0.30, 0.40); // rose
                if (index == 4) return vec3(0.78, 0.56, 0.16); // amber
                return vec3(0.46, 0.70, 0.22);                 // lime
            }

            // Smooth looping colour cycle through all six accents
            vec3 cycle(float t) {
                float x = fract(t) * 6.0;
                int i = int(floor(x));
                float f = fract(x);
                int next = int(mod(float(i) + 1.0, 6.0));
                return mix(accent(i), accent(next), f);
            }

            void main() {
                float aspect = u_resolution.x / max(u_resolution.y, 1.0);
                vec2 p = vec2((v_uv.x - 0.5) * aspect, v_uv.y - 0.5) * 2.0;
                vec2 m = vec2((u_mouse.x - 0.5) * aspect, u_mouse.y - 0.5) * 2.0;
                float t = u_time * 0.05;

                // Mouse gently pushes the flow and adds a soft glow
                vec2 d = p - m;
                float influence = exp(-dot(d, d) * 0.9);
                vec2 q = p - d * influence * 0.2;

                // Domain warping gives the slow liquid marble look
                vec2 w1 = vec2(
                    fbm(q + vec2(0.0, t)),
                    fbm(q + vec2(5.2, 1.3 - t))
                );
                vec2 w2 = vec2(
                    fbm(q + 1.9 * w1 + vec2(1.7, 9.2) + vec2(t * 0.8, 0.0)),
                    fbm(q + 1.9 * w1 + vec2(8.3, 2.8) - vec2(0.0, t * 0.6))
                );
                float f = fbm(q + 2.1 * w2);

                float tone = clamp((f - 0.22) * 1.7, 0.0, 1.0);
                vec3 base = cycle(tone * 0.6 + w1.x * 0.3 + u_time * 0.01);
                float body = smoothstep(0.1, 0.9, tone);

                // Main colour body at a balanced brightness (max about 0.62)
                vec3 color = base * (0.30 + 0.70 * body) * 0.62;

                // Subtle soft vein along one band of the field
                float vein = exp(-pow((f - 0.5) * 10.0, 2.0));
                color += cycle(f * 0.8 + 0.3) * vein * 0.12;

                // Gentle glow near the mouse
                color += base * influence * 0.12;

                // Darker top (navbar and headline contrast) and soft edge falloff
                color *= mix(1.0, 0.5, smoothstep(0.2, 1.0, v_uv.y));
                color *= smoothstep(2.4, 0.5, length(p));

                gl_FragColor = vec4(clamp(color, 0.0, 1.0), 1.0);
            }
        `;

        function compileShader(type, source) {
            const shader = gl.createShader(type);
            gl.shaderSource(shader, source);
            gl.compileShader(shader);
            if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
                const message = gl.getShaderInfoLog(shader);
                gl.deleteShader(shader);
                throw new Error(message || 'Unable to compile background shader.');
            }
            return shader;
        }

        let program;
        try {
            const vertex = compileShader(gl.VERTEX_SHADER, vertexSource);
            const fragment = compileShader(gl.FRAGMENT_SHADER, fragmentSource);
            program = gl.createProgram();
            gl.attachShader(program, vertex);
            gl.attachShader(program, fragment);
            gl.linkProgram(program);
            gl.deleteShader(vertex);
            gl.deleteShader(fragment);

            if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
                throw new Error(gl.getProgramInfoLog(program) || 'Unable to link background shader.');
            }
        } catch (error) {
            body.classList.add('bg-fallback');
            console.warn('WebGL background failed; using the CSS fallback.', error);
            return;
        }

        const buffer = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, buffer);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([
            -1, -1, 1, -1, -1, 1,
            -1, 1, 1, -1, 1, 1,
        ]), gl.STATIC_DRAW);
        gl.useProgram(program);

        const position = gl.getAttribLocation(program, 'a_position');
        gl.enableVertexAttribArray(position);
        gl.vertexAttribPointer(position, 2, gl.FLOAT, false, 0, 0);

        const resolutionLocation = gl.getUniformLocation(program, 'u_resolution');
        const mouseLocation = gl.getUniformLocation(program, 'u_mouse');
        const timeLocation = gl.getUniformLocation(program, 'u_time');
        const targetMouse = { x: 0.5, y: 0.5 };
        const currentMouse = { x: 0.5, y: 0.5 };
        let frame = 0;
        let visible = true;
        let startedAt = performance.now();

        const resize = () => {
            const ratio = Math.min(window.devicePixelRatio || 1, 1.5);
            const scale = Math.max(0.5, Math.min(0.75, ratio * 0.48));
            const width = Math.max(1, Math.floor(window.innerWidth * ratio * scale));
            const height = Math.max(1, Math.floor(window.innerHeight * ratio * scale));
            if (canvas.width === width && canvas.height === height) return;
            canvas.width = width;
            canvas.height = height;
            gl.viewport(0, 0, width, height);
            gl.uniform2f(resolutionLocation, width, height);
            if (reduceMotion.matches) draw(performance.now());
        };

        const draw = (now) => {
            currentMouse.x += (targetMouse.x - currentMouse.x) * 0.035;
            currentMouse.y += (targetMouse.y - currentMouse.y) * 0.035;
            gl.uniform2f(mouseLocation, currentMouse.x, currentMouse.y);
            gl.uniform1f(timeLocation, reduceMotion.matches ? 0 : (now - startedAt) / 1000);
            gl.drawArrays(gl.TRIANGLES, 0, 6);
        };

        const render = (now) => {
            frame = 0;
            if (!visible || document.hidden || reduceMotion.matches) return;
            draw(now);
            frame = requestAnimationFrame(render);
        };

        const syncAnimation = () => {
            const shouldAnimate = visible && !document.hidden && !reduceMotion.matches;
            if (shouldAnimate && !frame) {
                startedAt = performance.now();
                frame = requestAnimationFrame(render);
            } else if (!shouldAnimate && frame) {
                cancelAnimationFrame(frame);
                frame = 0;
            }
            if (reduceMotion.matches) draw(performance.now());
        };

        canvas.addEventListener('webglcontextlost', (event) => {
            event.preventDefault();
            if (frame) cancelAnimationFrame(frame);
            frame = 0;
            body.classList.add('bg-fallback');
        });

        window.addEventListener('pointermove', (event) => {
            if (event.pointerType !== 'mouse') return;
            targetMouse.x = Math.min(1, Math.max(0, event.clientX / window.innerWidth));
            targetMouse.y = 1 - Math.min(1, Math.max(0, event.clientY / window.innerHeight));
        }, { passive: true });

        window.addEventListener('resize', resize, { passive: true });
        document.addEventListener('visibilitychange', syncAnimation);
        if (reduceMotion.addEventListener) {
            reduceMotion.addEventListener('change', syncAnimation);
        }

        if ('IntersectionObserver' in window) {
            new IntersectionObserver(([entry]) => {
                visible = entry.isIntersecting;
                syncAnimation();
            }).observe(canvas);
        }

        resize();
        syncAnimation();
    }
</script>