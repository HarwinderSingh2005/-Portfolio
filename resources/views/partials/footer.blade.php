{{-- Footer: call-to-action card, brand block, contact details, social links and back-to-top.
     Black-and-white look to match the contact form. No navigation links here. Uses $profile and x-icon. --}}
@php
    $nameParts = collect(explode(' ', trim($profile->full_name ?? 'Portfolio')))->filter();
    $initials = strtoupper(
        $nameParts->count() > 1
            ? substr($nameParts->first(), 0, 1).substr($nameParts->last(), 0, 1)
            : substr($nameParts->first() ?? 'P', 0, 2)
    );
@endphp

<style>
    /* Subtle grey gradient border around the CTA card */
    .footer-cta-ring {
        background: linear-gradient(120deg, rgba(255,255,255,.22), rgba(255,255,255,.04) 45%, rgba(255,255,255,.18));
    }

    /* Dark glass card with a soft white light in the corners */
    .footer-cta-glow {
        background: radial-gradient(ellipse at 15% 0%, rgba(255,255,255,.07), transparent 55%),
                    radial-gradient(ellipse at 90% 100%, rgba(255,255,255,.05), transparent 55%),
                    rgba(10,10,10,.9);
    }

    /* Monogram ring that slowly rotates, in grey and white */
    .footer-logo-ring {
        background: conic-gradient(from 0deg, #FFFFFF, #737373, #D4D4D4, #404040, #FFFFFF);
        animation: footer-logo-spin 8s linear infinite;
    }

    @keyframes footer-logo-spin {
        to { transform: rotate(360deg); }
    }

    .footer-link {
        transition: color 0.3s ease, border-color 0.3s ease, background-color 0.3s ease, transform 0.3s ease;
    }

    .footer-link:hover {
        transform: translateY(-2px);
    }

    @media (prefers-reduced-motion: reduce) {
        .footer-logo-ring {
            animation: none !important;
        }

        .footer-link {
            transition: none !important;
            transform: none !important;
        }
    }
</style>

<footer class="relative overflow-hidden border-t border-white/10 bg-transparent pb-10 pt-16 md:pt-20">

    <div class="relative mx-auto w-full max-w-[1400px] px-5 sm:px-7 lg:px-10">

        {{-- Call to action card --}}
        <div class="mb-14 md:mb-16">
            <div class="footer-cta-ring rounded-[1.75rem] p-px">
                <div class="footer-cta-glow flex flex-col gap-8 rounded-[1.75rem] px-7 py-9 md:flex-row md:items-center md:justify-between md:px-12 md:py-12">
                    <div class="max-w-xl">
                        <p class="mb-3 text-xs font-medium uppercase tracking-[0.2em] text-[#A3A3A3]">Let's work together</p>
                        <h2 class="font-display text-3xl font-bold leading-tight tracking-tight text-white md:text-4xl" style="text-wrap: balance;">
                            Have a project in mind?
                        </h2>
                        <p class="mt-3 text-base leading-relaxed text-[#A3A3A3]">
                            Have an idea, opportunity, or project in mind? Let's connect and build something meaningful together.
                        </p>
                    </div>

                    <div class="flex shrink-0 flex-col gap-3 sm:flex-row md:flex-col">
                        <a href="#contact"
                            class="footer-link group inline-flex items-center justify-center gap-2.5 rounded-lg bg-white px-6 py-3.5 text-sm font-semibold text-black shadow-[0_0_24px_rgba(255,255,255,0.12)] hover:bg-[#E5E5E5] hover:shadow-[0_0_32px_rgba(255,255,255,0.2)]">
                            <span>Start a conversation</span>
                            <x-icon name="arrow-right" class="h-4 w-4 text-black transition-transform group-hover:translate-x-1" hover="none" />
                        </a>
                        @if ($profile->email)
                            <a href="mailto:{{ $profile->email }}"
                                class="footer-link inline-flex items-center justify-center gap-2 rounded-lg border border-white/20 bg-black/40 px-6 py-3.5 text-sm font-medium text-white hover:border-white/40 hover:bg-white/5">
                                <x-icon name="mail" class="h-4 w-4 text-white" hover="none" />
                                <span>Send an email</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Brand, contact and connect columns --}}
        <div class="grid grid-cols-1 gap-12 md:grid-cols-12 md:gap-10">

            {{-- Brand --}}
            <div class="md:col-span-5">
                <div class="flex items-center gap-4">
                    <span class="relative flex h-14 w-14 items-center justify-center">
                        <span class="footer-logo-ring absolute inset-0 rounded-2xl"></span>
                        <span class="absolute inset-[2px] flex items-center justify-center rounded-[14px] bg-black">
                            <span class="font-display text-lg font-bold tracking-wide text-white">{{ $initials }}</span>
                        </span>
                    </span>
                    <div class="leading-tight">
                        <p class="font-display text-2xl font-bold tracking-tight text-white">{{ $profile->full_name }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-[0.18em] text-[#737373]">{{ $profile->primary_title }}</p>
                    </div>
                </div>
                <p class="mt-6 max-w-sm text-sm leading-relaxed text-[#A3A3A3]">
                    Designed and developed with creativity and code.
                </p>
            </div>

            {{-- Contact --}}
            <div class="md:col-span-4">
                <p class="mb-5 text-xs font-medium uppercase tracking-[0.2em] text-[#737373]">Contact</p>
                <ul class="space-y-4">
                    @if ($profile->email)
                        <li>
                            <a href="mailto:{{ $profile->email }}" class="footer-link group flex items-center gap-3 text-sm text-white hover:text-[#D4D4D4]">
                                <span class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 bg-black/50 transition group-hover:border-white/40">
                                    <x-icon name="mail" class="h-4 w-4 text-white" hover="none" />
                                </span>
                                <span class="truncate">{{ $profile->email }}</span>
                            </a>
                        </li>
                    @endif
                    @if ($profile->phone)
                        <li>
                            <a href="tel:{{ preg_replace('/\s+/', '', $profile->phone) }}" class="footer-link group flex items-center gap-3 text-sm text-white hover:text-[#D4D4D4]">
                                <span class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 bg-black/50 transition group-hover:border-white/40">
                                    <x-icon name="phone" class="h-4 w-4 text-white" hover="none" />
                                </span>
                                <span>{{ $profile->phone }}</span>
                            </a>
                        </li>
                    @endif
                    @if ($profile->location)
                        <li class="flex items-center gap-3 text-sm text-[#D4D4D4]">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 bg-black/50">
                                <x-icon name="map-pin" class="h-4 w-4 text-white" hover="none" />
                            </span>
                            <span>{{ $profile->location }}</span>
                        </li>
                    @endif
                </ul>
            </div>

            {{-- Connect --}}
            <div class="md:col-span-3">
                <p class="mb-5 text-xs font-medium uppercase tracking-[0.2em] text-[#737373]">Connect</p>
                <div class="flex flex-col gap-3">
                    @if ($profile->linkedin)
                        <a href="{{ $profile->linkedin }}" target="_blank" rel="noopener noreferrer"
                            class="footer-link group flex items-center justify-between rounded-xl border border-white/10 bg-black/45 px-4 py-3 text-sm text-[#D4D4D4] hover:border-white/40 hover:text-white">
                            <span class="flex items-center gap-3">
                                <x-icon name="linkedin" class="h-4 w-4 text-white" hover="none" />
                                <span>LinkedIn</span>
                            </span>
                            <x-icon name="arrow-up-right" class="h-3.5 w-3.5 text-white opacity-40 transition group-hover:opacity-100" hover="none" />
                        </a>
                    @endif
                    @if ($profile->github)
                        <a href="{{ $profile->github }}" target="_blank" rel="noopener noreferrer"
                            class="footer-link group flex items-center justify-between rounded-xl border border-white/10 bg-black/45 px-4 py-3 text-sm text-[#D4D4D4] hover:border-white/40 hover:text-white">
                            <span class="flex items-center gap-3">
                                <x-icon name="github" class="h-4 w-4 text-white" hover="none" />
                                <span>GitHub</span>
                            </span>
                            <x-icon name="arrow-up-right" class="h-3.5 w-3.5 text-white opacity-40 transition group-hover:opacity-100" hover="none" />
                        </a>
                    @endif
                    <a href="{{ route('resume.download') }}"
                        class="footer-link group flex items-center justify-between rounded-xl border border-white/10 bg-black/45 px-4 py-3 text-sm text-[#D4D4D4] hover:border-white/40 hover:text-white">
                        <span class="flex items-center gap-3">
                            <x-icon name="download" class="h-4 w-4 text-white" hover="none" />
                            <span>Download resume</span>
                        </span>
                        <x-icon name="arrow-up-right" class="h-3.5 w-3.5 text-white opacity-40 transition group-hover:opacity-100" hover="none" />
                    </a>
                </div>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="mt-14 flex flex-col gap-5 border-t border-white/10 pt-7 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-xs text-[#737373]">
                &copy; {{ now()->year }} {{ $profile->full_name }}. All rights reserved.
            </p>

            <a href="#home"
                class="footer-link group inline-flex items-center gap-2 self-start rounded-full border border-white/15 bg-black/50 px-4 py-2 text-xs font-medium uppercase tracking-wider text-[#D4D4D4] hover:border-white/35 hover:text-white sm:self-auto">
                <span>Back to top</span>
                <x-icon name="arrow-up" class="h-3.5 w-3.5 text-white transition-transform group-hover:-translate-y-0.5" hover="none" />
            </a>
        </div>
    </div>
</footer>