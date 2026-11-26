@php
    $highlightIcons = ['graduation-cap', 'briefcase', 'code', 'database'];
    $paragraphs = $profile->about_paragraphs ?? [];
    $leadParagraph = $paragraphs[0] ?? null;
    $restParagraphs = array_slice($paragraphs, 1);
    $initials = collect(explode(' ', trim($profile->full_name ?? 'HS')))
        ->filter()
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->take(2)
        ->implode('');
@endphp

<style>
    .about-float {
        animation: about-float 6s ease-in-out infinite;
    }

    .about-float-delayed {
        animation: about-float 7s ease-in-out -3s infinite;
    }

    @keyframes about-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    @media (prefers-reduced-motion: reduce) {
        .about-float,
        .about-float-delayed {
            animation: none !important;
        }
    }
</style>

<section id="about" class="relative overflow-hidden border-t border-white/10 bg-transparent py-24 md:py-32">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/20"></div>
    <div class="relative mx-auto w-full max-w-[1400px] px-5 sm:px-7 lg:px-10" data-reveal>
        <div class="mb-14 max-w-3xl">
            <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/15 bg-black/50 px-4 py-1.5 text-xs font-medium uppercase tracking-wider text-[#D4D4D4] backdrop-blur">
                <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                About Me
            </p>
            <h2 class="font-display text-4xl font-bold leading-[1.08] tracking-tight text-white md:text-5xl lg:text-6xl" style="text-wrap: balance;">
                More Than Just <span class="about-code-accent">Code.</span>
            </h2>
            <p class="mt-4 text-lg text-[#A3A3A3] md:text-xl">Turning Ideas Into Digital Experiences.</p>
        </div>

        <div class="grid grid-cols-1 items-start gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-5">
                <div data-tilt="4" class="group relative mx-auto w-full max-w-md transition-transform duration-200 ease-out will-change-transform">
                    <div class="absolute -inset-px rounded-[1.6rem] border border-white/65 transition duration-300 group-hover:shadow-[0_0_34px_rgba(255,255,255,0.12)]"></div>
                    <div class="relative aspect-[4/5] overflow-hidden rounded-3xl bg-[#0A0A0A]">
                        @if ($profile->portrait_image && is_file(public_path(ltrim($profile->portrait_image, '/'))))
                            <img src="{{ $profile->portrait_image }}" alt="{{ $profile->full_name }} – {{ $profile->primary_title }}" loading="lazy"
                                class="h-full w-full object-cover object-top transition-transform duration-700 group-hover:scale-[1.03]" />
                        @else
                            <div class="flex h-full w-full flex-col items-center justify-center bg-[#0A0A0A]">
                                <span class="font-display text-7xl font-bold text-white/90">{{ $initials }}</span>
                                <span class="mt-3 text-sm text-[#A3A3A3]">{{ $profile->primary_title }}</span>
                            </div>
                        @endif
                        <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-black via-black/55 to-transparent"></div>
                        <div class="absolute inset-x-6 bottom-6">
                            <p class="font-display text-xl font-semibold text-white">{{ $profile->full_name }}</p>
                            <p class="text-sm text-[#A3A3A3]">{{ $profile->primary_title }}</p>
                        </div>
                    </div>

                    @if ($profile->location)
                        <div class="about-float absolute -left-2 top-10 hidden items-center gap-2 rounded-xl border border-white/10 bg-[#0A0A0A]/95 px-4 py-2.5 text-sm text-white shadow-xl backdrop-blur sm:flex md:-left-7">
                            <x-icon name="map-pin" class="h-4 w-4 text-white" />
                            <span>{{ $profile->location }}</span>
                        </div>
                    @endif

                    @if ($profile->email)
                        <div class="about-float-delayed absolute -right-2 bottom-24 hidden items-center gap-2 rounded-xl border border-white/10 bg-[#0A0A0A]/95 px-4 py-2.5 text-sm text-white shadow-xl backdrop-blur sm:flex md:-right-7">
                            <x-icon name="mail" class="h-4 w-4 text-white" />
                            <span class="max-w-[180px] truncate">{{ $profile->email }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex flex-col gap-9 lg:col-span-7">
                @if ($leadParagraph)
                    <p class="text-xl leading-[1.7] text-white/90 md:text-2xl md:leading-[1.6]">{{ $leadParagraph }}</p>
                @endif

                @if (count($restParagraphs))
                    <div class="space-y-5 text-base leading-[1.8] text-[#A3A3A3] md:text-[17px]">
                        @foreach ($restParagraphs as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-1 gap-4 pt-2 sm:grid-cols-2">
                    @foreach ($highlights as $item)
                        <div data-tilt="4" class="transition-transform duration-200 ease-out will-change-transform">
                            <div class="group relative h-full overflow-hidden rounded-2xl border border-white/10 bg-[#0A0A0A]/85 p-6 backdrop-blur transition duration-300 hover:-translate-y-1 hover:border-white/25 hover:shadow-[0_20px_50px_rgba(255,255,255,0.08)]">
                                <div class="mb-5 flex items-center justify-between">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/10 bg-white/5">
                                        <x-icon :name="$highlightIcons[$loop->index % count($highlightIcons)]" class="h-5 w-5 text-white" />
                                    </div>
                                    <span class="font-mono text-xs text-[#737373]">{{ sprintf('%02d', $loop->iteration) }}</span>
                                </div>
                                <h3 class="mb-1.5 font-display text-lg font-semibold text-white">{{ $item->label }}</h3>
                                <p class="text-sm leading-relaxed text-[#A3A3A3]">{{ $item->detail }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
