@php $education = $educations->first(); @endphp

<section id="experience" class="relative border-t border-white/10 bg-transparent py-24 md:py-32">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-transparent via-black/15 to-transparent"></div>
    <div class="relative mx-auto w-full max-w-[1400px] px-5 sm:px-7 lg:px-10">
        <div class="grid grid-cols-1 items-start gap-12 lg:grid-cols-12 lg:gap-14">
            <div class="lg:col-span-7" data-reveal>
                <div class="mb-10">
                    <p class="mb-3 text-xs font-medium uppercase tracking-[0.2em] text-[#A3A3A3]">Experience</p>
                    <h2 class="font-display text-3xl font-bold text-white md:text-4xl" style="text-wrap: balance;">My Professional Journey</h2>
                </div>

                <div class="relative pl-8 md:pl-10">
                    <div aria-hidden="true" class="absolute bottom-2 left-3 top-2 w-px bg-white/25"></div>
                    @foreach ($experiences as $experience)
                        <div class="relative mb-7 last:mb-0">
                            <div aria-hidden="true" class="absolute -left-[29px] top-1.5 h-4 w-4 rounded-full border-2 border-white bg-black shadow-[0_0_16px_rgba(255,255,255,0.28)] md:-left-[37px]"></div>
                            <div data-tilt="3" class="rounded-2xl border border-white/10 bg-[#0A0A0A]/90 p-6 transition duration-300 hover:border-white/20 md:p-8">
                                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5">
                                            <x-icon name="briefcase" class="h-5 w-5 text-white" />
                                        </div>
                                        <div>
                                            <h3 class="font-display text-xl font-semibold text-white">{{ $experience->title }}</h3>
                                            <p class="text-sm font-medium text-[#D4D4D4]">{{ $experience->subtitle }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-[#737373]">{{ $experience->period_label }}</span>
                                </div>
                                <ul class="space-y-3 border-t border-white/10 pt-4">
                                    @foreach ($experience->details ?? [] as $detail)
                                        <li class="flex items-start gap-3 text-sm leading-relaxed text-[#A3A3A3] md:text-[15px]">
                                            <span aria-hidden="true" class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-white"></span>
                                            <span>{{ $detail }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-5" data-reveal>
                <div class="mb-10">
                    <p class="mb-3 text-xs font-medium uppercase tracking-[0.2em] text-[#A3A3A3]">Academic Foundation</p>
                    <h2 class="font-display text-3xl font-bold text-white md:text-4xl" style="text-wrap: balance;">Education &amp; Background</h2>
                </div>

                @if ($education)
                    <div data-tilt="4">
                        <article class="rounded-2xl border border-white/10 bg-[#0A0A0A]/90 p-6 transition duration-300 hover:border-white/20 md:p-8">
                            <div class="mb-6 flex h-12 w-12 items-center justify-center rounded-xl border border-white/10 bg-white/5">
                                <x-icon name="graduation-cap" class="h-6 w-6 text-white" />
                            </div>
                            <p class="mb-2 text-xs text-[#737373]">{{ $education->period_label }}</p>
                            <h3 class="mb-2 font-display text-2xl font-semibold text-white">{{ $education->title }}</h3>
                            <p class="mb-5 text-base font-medium text-[#D4D4D4]">{{ $education->subtitle }}</p>
                            <p class="border-t border-white/10 pt-4 text-sm leading-relaxed text-[#A3A3A3]">{{ implode(' ', $education->details ?? []) }}</p>
                        </article>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
