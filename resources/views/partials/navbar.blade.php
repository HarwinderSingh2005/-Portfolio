{{-- Navbar: monogram logo with a rotating gradient ring, sliding active pill,
     glass effect on scroll, animated mobile drawer. Uses Alpine.js and x-icon. --}}
@php
    $navLinks = [
        ['id' => 'about', 'label' => 'About'],
        ['id' => 'skills', 'label' => 'Skills'],
        ['id' => 'projects', 'label' => 'Projects'],
        ['id' => 'experience', 'label' => 'Experience'],
        ['id' => 'services', 'label' => 'Services'],
    ];

    $nameParts = collect(explode(' ', trim($profile->full_name ?? 'Portfolio')))->filter();
    $initials = strtoupper(
        $nameParts->count() > 1
            ? substr($nameParts->first(), 0, 1).substr($nameParts->last(), 0, 1)
            : substr($nameParts->first() ?? 'P', 0, 2)
    );
@endphp

<style>
    /* Monogram: rotating gradient ring around a black core */
    .nav-logo-ring {
        background: conic-gradient(from 0deg, #22D3EE, #6366F1, #E879F9, #FB7185, #FACC15, #A3E635, #22D3EE);
        animation: nav-logo-spin 6s linear infinite;
    }

    .nav-logo-core {
        background: radial-gradient(circle at 30% 25%, rgba(255,255,255,.18), rgba(255,255,255,0) 55%), #000;
    }

    .group:hover .nav-logo-ring {
        animation-duration: 1.6s;
    }

    @keyframes nav-logo-spin {
        to { transform: rotate(360deg); }
    }

    /* Sliding pill that follows the active link */
    .nav-pill {
        position: absolute;
        top: 4px;
        bottom: 4px;
        left: 0;
        border-radius: 9999px;
        background: #ffffff;
        box-shadow: 0 0 24px rgba(255,255,255,0.25);
        transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1), width 0.45s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease;
        opacity: 0;
        pointer-events: none;
    }

    .nav-links-track {
        position: relative;
    }

    .nav-link {
        position: relative;
        z-index: 1;
        transition: color 0.3s ease;
    }

    .nav-link[data-active="true"] {
        color: #000000 !important;
    }

    .nav-link[data-active="true"]::after {
        content: "";
        position: absolute;
        right: 0.55rem;
        top: 0.45rem;
        width: 0.3rem;
        height: 0.3rem;
        border-radius: 9999px;
        background: #22D3EE;
        box-shadow: 0 0 8px #22D3EE;
    }

    /* CTA shine sweep on hover */
    .nav-cta {
        position: relative;
        overflow: hidden;
    }

    .nav-cta::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(110deg, transparent 30%, rgba(255,255,255,0.45) 50%, transparent 70%);
        transform: translateX(-120%);
        transition: transform 0.7s ease;
    }

    .nav-cta:hover::before {
        transform: translateX(120%);
    }

    @media (prefers-reduced-motion: reduce) {
        .nav-logo-ring {
            animation: none !important;
        }

        .nav-pill {
            transition: none !important;
        }
    }
</style>

<header
    x-data="{
        open: false,
        scrolled: false,
        pill: { x: 0, w: 0, on: false },

        movePill(link) {
            if (!link) { this.pill.on = false; return; }
            this.pill = { x: link.offsetLeft, w: link.offsetWidth, on: true };
        },

        syncPill() {
            const active = this.$refs.desktop.querySelector('[data-active=\'true\']');
            this.movePill(active);
        }
    }"
    x-init="
        $watch('open', value => document.body.style.overflow = value ? 'hidden' : '');
        $nextTick(() => syncPill());
        new MutationObserver(() => syncPill()).observe($refs.desktop, { attributes: true, subtree: true, attributeFilter: ['data-active'] });
    "
    @scroll.window="scrolled = window.scrollY > 24"
    @keydown.escape.window="open = false"
    @resize.window="if (window.innerWidth >= 768) open = false; syncPill()"
    class="fixed inset-x-0 top-0 z-50 border-b border-transparent transition-all duration-300"
    :class="scrolled ? 'border-white/10 bg-black/75 shadow-[0_12px_40px_rgba(0,0,0,0.5)] backdrop-blur-2xl' : 'bg-transparent'"
>
    <div class="mx-auto flex h-[76px] w-full max-w-[1400px] items-center justify-between gap-5 px-5 sm:px-7 lg:px-10">

        {{-- Logo --}}
        <a href="#home" @click="open = false" class="group flex shrink-0 items-center gap-3">
            <span class="relative flex h-11 w-11 items-center justify-center">
                <span class="nav-logo-ring absolute inset-0 rounded-2xl"></span>
                <span class="nav-logo-core absolute inset-[2px] flex items-center justify-center rounded-[14px]">
                    <span class="font-display text-sm font-bold tracking-wide text-white">{{ $initials }}</span>
                </span>
            </span>
            <span class="hidden flex-col leading-tight sm:flex">
                <span class="font-display text-base font-semibold tracking-tight text-white transition-colors group-hover:text-[#22D3EE]">{{ $profile->full_name }}</span>
                <span class="text-[11px] uppercase tracking-[0.18em] text-[#737373]">{{ $profile->primary_title }}</span>
            </span>
        </a>

        {{-- Desktop links with sliding pill --}}
        <nav aria-label="Primary navigation" class="hidden md:block">
            <div x-ref="desktop" class="nav-links-track flex items-center gap-1 rounded-full border border-white/10 bg-black/65 p-1.5 backdrop-blur-xl">
                <span class="nav-pill" :style="`transform: translateX(${pill.x}px); width: ${pill.w}px; opacity: ${pill.on ? 1 : 0};`"></span>

                <a href="#home" data-nav="home" class="nav-link rounded-full px-4 py-2 text-sm font-medium text-[#A3A3A3] transition hover:text-white">Home</a>
                @foreach ($navLinks as $link)
                    <a href="#{{ $link['id'] }}" data-nav="{{ $link['id'] }}" class="nav-link rounded-full px-4 py-2 text-sm font-medium text-[#A3A3A3] transition hover:text-white">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </nav>

        {{-- CTA and mobile toggle --}}
        <div class="flex shrink-0 items-center gap-3">
            <a href="#contact" class="nav-cta hidden items-center gap-2 rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-black shadow-[0_0_24px_rgba(255,255,255,0.12)] transition hover:bg-[#E5E5E5] hover:shadow-[0_0_32px_rgba(255,255,255,0.2)] md:inline-flex">
                <span class="relative">Let's Talk</span>
                <x-icon name="arrow-right" class="relative h-4 w-4" hover="none" />
            </a>
            <button type="button" @click="open = !open" :aria-expanded="open.toString()" aria-controls="mobile-menu" aria-label="Toggle navigation menu"
                class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-white/20 bg-black/70 text-white transition hover:bg-white/5 md:hidden">
                <x-icon name="menu" class="h-5 w-5" x-show="!open" hover="none" />
                <x-icon name="x" class="h-5 w-5" x-show="open" x-cloak hover="none" />
            </button>
        </div>
    </div>

    {{-- Scroll progress bar (updated by the script in assets.blade.php) --}}
    <div id="scroll-progress" aria-hidden="true" class="scroll-progress absolute bottom-0 left-0 h-[2px] w-0"></div>

    {{-- Mobile backdrop --}}
    <div x-show="open" x-cloak x-transition.opacity @click="open = false"
        class="fixed inset-x-0 bottom-0 top-[76px] bg-black/65 backdrop-blur-sm md:hidden"></div>

    {{-- Mobile drawer --}}
    <div id="mobile-menu" x-show="open" x-cloak
        x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="opacity-0 -translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-3"
        class="border-b border-white/10 bg-black/95 px-5 pb-6 pt-3 backdrop-blur-2xl md:hidden">
        <nav aria-label="Mobile navigation" class="flex flex-col gap-1">
            <a href="#home" data-nav="home" @click="open = false" class="nav-link rounded-xl px-4 py-3.5 text-base font-medium text-[#A3A3A3] transition hover:bg-white/5 hover:text-white">Home</a>
            @foreach ($navLinks as $link)
                <a href="#{{ $link['id'] }}" data-nav="{{ $link['id'] }}" @click="open = false" class="nav-link rounded-xl px-4 py-3.5 text-base font-medium text-[#A3A3A3] transition hover:bg-white/5 hover:text-white">
                    {{ $link['label'] }}
                </a>
            @endforeach
            <a href="#process" data-nav="process" @click="open = false" class="nav-link rounded-xl px-4 py-3.5 text-base font-medium text-[#A3A3A3] transition hover:bg-white/5 hover:text-white">Process</a>
            <a href="#contact" data-nav="contact" @click="open = false" class="nav-link rounded-xl px-4 py-3.5 text-base font-medium text-[#A3A3A3] transition hover:bg-white/5 hover:text-white">Contact</a>
            <a href="#contact" @click="open = false" class="nav-cta mt-3 inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-3.5 text-base font-semibold text-black transition hover:bg-[#E5E5E5]">
                <span class="relative">Let's Talk</span>
                <x-icon name="arrow-right" class="relative h-4 w-4" hover="none" />
            </a>
        </nav>

        <div class="mt-5 flex items-center justify-between border-t border-white/10 pt-4 text-sm">
            <a href="mailto:{{ $profile->email }}" class="truncate text-[#A3A3A3] hover:text-white">{{ $profile->email }}</a>
            <div class="flex shrink-0 items-center gap-2">
                <a href="{{ $profile->github }}" target="_blank" rel="noopener noreferrer" aria-label="GitHub" class="rounded-lg p-2 text-[#A3A3A3] hover:bg-white/5 hover:text-white">
                    <x-icon name="github" class="h-4 w-4" />
                </a>
                <a href="{{ $profile->linkedin }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" class="rounded-lg p-2 text-[#A3A3A3] hover:bg-white/5 hover:text-white">
                    <x-icon name="linkedin" class="h-4 w-4" />
                </a>
            </div>
        </div>
    </div>
</header>