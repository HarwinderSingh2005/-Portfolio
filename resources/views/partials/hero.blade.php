{{-- Hero: black-and-white luxury layout. Glass orbit of real skills from the database,
     layered halo and rings, pulsing core, mouse tilt, hover to pause. Pure CSS + small script. --}}
@php
    $roles = $profile->rotating_roles ?? [];
    $categoryLabels = config('portfolio.skill_categories', []);
    $orbitSkills = collect($skillGroups ?? [])->flatten(1)->take(6)->values();
    $accents = ['#22D3EE', '#6366F1', '#E879F9', '#FB7185', '#FACC15', '#A3E635'];
@endphp

<style>
    .hero-orbit-shell {
        container-type: inline-size;
    }

    /* Mouse tilt, driven by --hero-px and --hero-py set in the script below */
    .hero-tilt {
        transform: perspective(1400px) rotateX(calc(var(--hero-py, 0) * -7deg)) rotateY(calc(var(--hero-px, 0) * 9deg));
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        transform-style: preserve-3d;
    }

    /* Soft colour halo behind the orbit */
    .hero-halo {
        background: conic-gradient(from 0deg, rgba(34,211,238,.55), rgba(99,102,241,.5), rgba(232,121,249,.5), rgba(251,113,133,.45), rgba(250,204,21,.4), rgba(163,230,53,.45), rgba(34,211,238,.55));
        filter: blur(38px);
        opacity: 0.5;
        animation: hero-spin 26s linear infinite;
    }

    /* Bright white sweep arcs on the rings */
    .hero-arc {
        background: conic-gradient(from 0deg, transparent 0deg 240deg, rgba(255,255,255,.95) 300deg, transparent 340deg);
        -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 2px), #000 calc(100% - 1px));
        mask: radial-gradient(farthest-side, transparent calc(100% - 2px), #000 calc(100% - 1px));
        animation: hero-spin 7s linear infinite;
    }

    .hero-arc-2 {
        background: conic-gradient(from 0deg, transparent 0deg 200deg, rgba(34,211,238,.9) 250deg, transparent 290deg);
        -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 2px), #000 calc(100% - 1px));
        mask: radial-gradient(farthest-side, transparent calc(100% - 2px), #000 calc(100% - 1px));
        animation: hero-spin-rev 12s linear infinite;
    }

    .hero-ring-slow {
        animation: hero-spin-rev 60s linear infinite;
    }

    /* Glossy black core */
    .hero-core {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.22), rgba(255,255,255,.02) 45%), #050505;
        animation: hero-core-pulse 4.5s ease-in-out infinite;
    }

    /* Glass badge with a light sweep on hover */
    .hero-glass {
        background: linear-gradient(135deg, rgba(255,255,255,.14), rgba(255,255,255,.02) 60%), rgba(10,10,10,.82);
    }

    .hero-glass::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(110deg, transparent 30%, rgba(255,255,255,.16) 50%, transparent 70%);
        transform: translateX(-120%);
        transition: transform 0.9s ease;
        pointer-events: none;
    }

    .group:hover .hero-glass::after {
        transform: translateX(120%);
    }

    .hero-dot-ping {
        animation: hero-ping 2.4s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    .hero-badge-in {
        animation: hero-badge-in 0.9s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .hero-enter {
        animation: hero-fade-up 0.9s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    .hero-orbit {
        animation: hero-spin 42s linear infinite;
    }

    .hero-orbit-counter {
        animation: hero-counter 42s linear infinite;
    }

    /* Pause the orbit while the mouse is over it so badges are easy to read */
    .hero-orbit-shell:hover .hero-orbit,
    .hero-orbit-shell:hover .hero-orbit-counter {
        animation-play-state: paused;
    }

    @keyframes hero-spin {
        to { transform: rotate(360deg); }
    }

    @keyframes hero-spin-rev {
        to { transform: rotate(-360deg); }
    }

    @keyframes hero-counter {
        from { transform: translate(-50%, -50%) rotate(0deg); }
        to { transform: translate(-50%, -50%) rotate(-360deg); }
    }

    @keyframes hero-badge-in {
        from { opacity: 0; transform: scale(0.6) translateY(10px); }
        to { opacity: 1; transform: none; }
    }

    @keyframes hero-core-pulse {
        0%, 100% { box-shadow: 0 0 0 1px rgba(255,255,255,.14), 0 0 60px rgba(99,102,241,.22); }
        50% { box-shadow: 0 0 0 1px rgba(255,255,255,.28), 0 0 90px rgba(34,211,238,.3); }
    }

    @keyframes hero-ping {
        0% { transform: scale(1); opacity: 0.7; }
        100% { transform: scale(2.6); opacity: 0; }
    }

    @keyframes hero-fade-up {
        from { opacity: 0; transform: translateY(24px); }
        to { opacity: 1; transform: none; }
    }

    @media (prefers-reduced-motion: reduce) {
        .hero-enter,
        .hero-halo,
        .hero-arc,
        .hero-arc-2,
        .hero-ring-slow,
        .hero-core,
        .hero-orbit,
        .hero-orbit-counter,
        .hero-dot-ping,
        .hero-badge-in {
            animation: none !important;
        }

        .hero-badge-in {
            opacity: 1;
        }

        .hero-tilt {
            transform: none;
        }
    }
</style>

<section id="home" class="relative flex min-h-[100svh] flex-col justify-center overflow-hidden bg-transparent pb-20 pt-28 sm:pb-24">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-r from-black/80 via-black/55 to-transparent lg:from-black/85 lg:via-black/45"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-black/75 to-transparent"></div>

    <div class="relative z-10 mx-auto grid w-full max-w-[1400px] grid-cols-1 items-center gap-10 px-5 sm:px-7 lg:grid-cols-12 lg:gap-8 lg:px-10">

        {{-- Text column --}}
        <div class="max-w-3xl lg:col-span-7">
            @if ($profile->hero_kicker)
                <p class="hero-enter mb-6 inline-flex items-center gap-2.5 rounded-full border border-white/15 bg-black/55 px-4 py-1.5 text-xs font-medium tracking-wide text-[#D4D4D4] backdrop-blur md:text-sm">
                    <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                    {{ $profile->hero_kicker }}
                </p>
            @endif

            <h1 class="hero-enter mb-5 font-display text-5xl font-bold leading-[1.02] tracking-tight text-white sm:text-6xl lg:text-7xl xl:text-8xl"
                style="text-wrap: balance; animation-delay: 0.1s;">
                {{ $profile->hero_headline }}
            </h1>

            <div class="hero-enter mb-6 flex flex-wrap items-baseline gap-x-3 gap-y-1"
                style="animation-delay: 0.2s;"
                x-data="{
                    i: 0,
                    count: {{ count($roles) }},
                    init() {
                        if (this.count > 1 && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                            setInterval(() => this.i = (this.i + 1) % this.count, 2800);
                        }
                    }
                }"
                x-init="init()">
                <span class="font-display text-xl font-semibold text-white/90 md:text-2xl lg:text-3xl">{{ $profile->hero_subtitle }}</span>
                @if (count($roles))
                    <span aria-hidden="true" class="text-xl text-white/35 md:text-2xl">/</span>
                    <span class="inline-grid font-display text-xl font-semibold text-white md:text-2xl lg:text-3xl" aria-live="polite">
                        @foreach ($roles as $index => $role)
                            <span class="col-start-1 row-start-1 whitespace-nowrap transition-all duration-500 ease-out"
                                :class="i === {{ $index }} ? 'translate-y-0 opacity-100' : 'translate-y-2 opacity-0'">{{ $role }}</span>
                        @endforeach
                    </span>
                @endif
            </div>

            <p class="hero-enter mb-9 max-w-xl text-base leading-relaxed text-[#A3A3A3] md:text-lg lg:text-xl" style="animation-delay: 0.3s;">
                {{ $profile->hero_description }}
            </p>

            <div class="hero-enter flex flex-wrap items-center gap-3" style="animation-delay: 0.4s;">
                <a href="#projects" class="group inline-flex shrink-0 items-center gap-2.5 rounded-lg bg-white px-6 py-3.5 text-sm font-semibold text-black shadow-[0_0_24px_rgba(255,255,255,0.12)] transition-all hover:-translate-y-0.5 hover:bg-[#E5E5E5] hover:shadow-[0_0_34px_rgba(255,255,255,0.2)] md:text-base">
                    <span>Explore My Work</span>
                    <x-icon name="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1" />
                </a>
                <a href="{{ route('resume.download') }}" class="inline-flex shrink-0 items-center gap-2.5 rounded-lg border border-white/20 bg-black/35 px-6 py-3.5 text-sm font-medium text-white transition hover:bg-white/5 md:text-base">
                    <x-icon name="download" class="h-4 w-4" />
                    <span>Download Resume</span>
                </a>
                <a href="#contact" class="inline-flex shrink-0 items-center gap-2 rounded-lg px-4 py-3.5 text-sm font-medium text-[#A3A3A3] transition hover:text-white md:text-base">
                    <x-icon name="mail" class="h-4 w-4" />
                    <span>Let's Talk</span>
                </a>
            </div>
        </div>

        {{-- Orbit column --}}
        <div class="lg:col-span-5">
            <div class="hero-orbit-shell relative mx-auto aspect-square w-full max-w-[520px]">
                <div class="hero-tilt absolute inset-0">

                    {{-- Background rings and light --}}
                    <div aria-hidden="true" class="hero-halo absolute inset-[4%] rounded-full"></div>
                    <div aria-hidden="true" class="hero-ring-slow absolute inset-[6%] rounded-full border border-dashed border-white/15"></div>
                    <div aria-hidden="true" class="absolute inset-[16%] rounded-full border border-white/10"></div>
                    <div aria-hidden="true" class="hero-arc absolute inset-[16%] rounded-full"></div>
                    <div aria-hidden="true" class="hero-arc-2 absolute inset-[26%] rounded-full"></div>
                    <div aria-hidden="true" class="absolute inset-[34%] rounded-full border border-white/5"></div>

                    {{-- Glossy core --}}
                    <div aria-hidden="true" class="hero-core absolute left-1/2 top-1/2 flex h-[24cqw] w-[24cqw] -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full border border-white/20">
                        <span class="font-mono text-[6cqw] font-medium tracking-tight text-white">&lt;/&gt;</span>
                    </div>

                    {{-- Orbiting skill badges from the database --}}
                    @if ($orbitSkills->isNotEmpty())
                        <div class="hero-orbit absolute inset-0">
                            @foreach ($orbitSkills as $skill)
                                @php
                                    $angle = $loop->index * (360 / max($orbitSkills->count(), 1));
                                    $color = $accents[$loop->index % count($accents)];
                                    $categoryLabel = $categoryLabels[$skill->category] ?? '';
                                @endphp

                                <div class="absolute left-1/2 top-1/2 h-0 w-0"
                                    style="transform: rotate({{ $angle }}deg) translateX(38cqw) rotate(-{{ $angle }}deg);">
                                    <div class="hero-orbit-counter absolute left-0 top-0" style="transform: translate(-50%, -50%);">
                                        <div class="hero-badge-in group" style="animation-delay: {{ 0.5 + $loop->index * 0.08 }}s;">
                                            <div class="hero-glass relative flex max-w-[44cqw] items-center gap-3 overflow-hidden rounded-2xl border border-white/15 px-3.5 py-2.5 shadow-[0_18px_40px_rgba(0,0,0,0.6)] backdrop-blur-xl transition duration-300 group-hover:border-white/35 group-hover:shadow-[0_0_30px_rgba(255,255,255,0.12)]">
                                                <span class="relative flex h-2.5 w-2.5 shrink-0">
                                                    <span class="hero-dot-ping absolute inline-flex h-full w-full rounded-full" style="background-color: {{ $color }};"></span>
                                                    <span class="relative inline-flex h-2.5 w-2.5 rounded-full" style="background-color: {{ $color }}; box-shadow: 0 0 12px {{ $color }};"></span>
                                                </span>
                                                <span class="min-w-0">
                                                    <span class="block truncate text-xs font-semibold text-white sm:text-sm">{{ $skill->name }}</span>
                                                    @if ($categoryLabel)
                                                        <span class="block truncate text-[10px] uppercase tracking-wider text-[#737373]">{{ $categoryLabel }}</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <a href="#about" aria-label="Scroll to About section" class="absolute bottom-7 left-1/2 z-10 hidden -translate-x-1/2 items-center gap-2 text-xs font-medium tracking-wide text-[#A3A3A3] transition hover:text-white sm:inline-flex">
        <span>Scroll to explore</span>
        <x-icon name="arrow-down" class="h-4 w-4 animate-bounce" />
    </a>
</section>

<script>
    (function () {
        const shell = document.querySelector('.hero-orbit-shell');
        const tilt = shell && shell.querySelector('.hero-tilt');
        if (!shell || !tilt) return;
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        shell.addEventListener('pointermove', (e) => {
            if (e.pointerType !== 'mouse') return;
            const rect = shell.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;
            tilt.style.setProperty('--hero-px', x.toFixed(3));
            tilt.style.setProperty('--hero-py', y.toFixed(3));
        });

        shell.addEventListener('pointerleave', () => {
            tilt.style.setProperty('--hero-px', '0');
            tilt.style.setProperty('--hero-py', '0');
        });
    })();
</script>