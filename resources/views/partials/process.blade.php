<section id="process" class="relative border-t border-white/10 bg-transparent py-24 md:py-32" x-data="{ active: 0 }">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-transparent via-black/15 to-transparent"></div>
    <div class="relative mx-auto w-full max-w-[1400px] px-5 sm:px-7 lg:px-10" data-reveal>
        <div class="mb-12 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-xl">
                <p class="mb-3 text-xs font-medium uppercase tracking-[0.2em] text-[#A3A3A3]">Workflow</p>
                <h2 class="font-display text-3xl font-bold text-white md:text-4xl lg:text-5xl" style="text-wrap: balance;">How I Work</h2>
            </div>
            <p class="max-w-md text-sm text-[#A3A3A3] md:text-base">A structured six-stage development workflow designed for clarity, maintainable code, and dependable delivery.</p>
        </div>

        <div class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-6" role="tablist" aria-label="Development process">
            @foreach ($steps as $step)
                <button type="button" role="tab" @click="active = {{ $loop->index }}" :aria-selected="active === {{ $loop->index }}"
                    :class="active === {{ $loop->index }} ? 'border-white bg-white text-black shadow-[0_12px_36px_rgba(255,255,255,0.12)]' : 'border-white/15 bg-[#0A0A0A]/80 text-white hover:border-white/35 hover:bg-[#0F0F0F]'"
                    class="flex min-h-28 cursor-pointer flex-col justify-between gap-4 rounded-2xl border p-4 text-left transition-colors md:min-h-32 md:p-5">
                    <span class="font-mono text-xs opacity-70">{{ $step->step }}</span>
                    <span class="font-display text-base font-semibold md:text-lg">{{ $step->title }}</span>
                </button>
            @endforeach
        </div>

        <div class="mt-6 rounded-2xl border border-white/10 bg-[#0A0A0A]/90 p-6 backdrop-blur md:p-8">
            @foreach ($steps as $step)
                <div x-show="active === {{ $loop->index }}" x-cloak role="tabpanel">
                    <p class="mb-5 text-base leading-relaxed text-[#A3A3A3] md:text-lg">{{ $step->summary }}</p>
                    <p class="border-t border-white/10 pt-4 text-sm font-medium text-[#A3A3A3]">
                        Deliverable: <span class="text-white">{{ $step->deliverable }}</span>
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
