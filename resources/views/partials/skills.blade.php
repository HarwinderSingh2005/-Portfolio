@php
    $categories = config('portfolio.skill_categories');
    $categoryDescriptions = config('portfolio.skill_category_descriptions');
    $categoryIcons = ['backend' => 'server', 'frontend' => 'code', 'database' => 'database', 'api' => 'webhook', 'tools' => 'terminal'];
@endphp

<section id="skills" class="relative border-t border-white/10 bg-transparent py-24 md:py-32" x-data="{ active: 'all' }">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-transparent via-black/15 to-transparent"></div>
    <div class="relative mx-auto w-full max-w-[1400px] px-5 sm:px-7 lg:px-10" data-reveal>
        <div class="mb-12 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-xl">
                <p class="mb-3 text-xs font-medium uppercase tracking-[0.2em] text-[#A3A3A3]">Capabilities &amp; Stack</p>
                <h2 class="font-display text-3xl font-bold text-white md:text-4xl lg:text-5xl" style="text-wrap: balance;">My Technical Arsenal</h2>
            </div>

            <div role="tablist" aria-label="Filter technical skills by category" class="flex flex-wrap items-center gap-1.5 rounded-xl border border-white/10 bg-[#0A0A0A]/85 p-1.5 backdrop-blur">
                <button type="button" role="tab" @click="active = 'all'" :aria-selected="active === 'all'"
                    :class="active === 'all' ? 'bg-white text-black' : 'text-[#A3A3A3] hover:bg-white/5 hover:text-white'"
                    class="shrink-0 cursor-pointer whitespace-nowrap rounded-lg px-3.5 py-2 text-xs font-medium transition-colors md:text-sm">All Areas</button>
                @foreach ($categories as $key => $label)
                    <button type="button" role="tab" @click="active = '{{ $key }}'" :aria-selected="active === '{{ $key }}'"
                        :class="active === '{{ $key }}' ? 'bg-white text-black' : 'text-[#A3A3A3] hover:bg-white/5 hover:text-white'"
                        class="shrink-0 cursor-pointer whitespace-nowrap rounded-lg px-3.5 py-2 text-xs font-medium transition-colors md:text-sm">{{ str_replace(' Development', '', $label) }}</button>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($categories as $key => $label)
                @php $items = $skillGroups[$key] ?? collect(); @endphp
                @if ($items->isNotEmpty())
                    <article x-show="active === 'all' || active === '{{ $key }}'" data-tilt="4"
                        class="flex h-full flex-col justify-between gap-6 rounded-2xl border border-white/10 bg-[#0A0A0A]/90 p-6 backdrop-blur transition duration-300 hover:border-white/20 md:p-7">
                        <div>
                            <div class="mb-4 flex items-center justify-between gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5">
                                    <x-icon :name="$categoryIcons[$key] ?? 'layers'" class="h-5 w-5 text-white" />
                                </div>
                                <span class="font-mono text-xs text-[#737373]">{{ sprintf('%02d', $loop->iteration) }}</span>
                            </div>
                            <h3 class="mb-2 font-display text-xl font-semibold text-white">{{ $label }}</h3>
                            <p class="mb-6 text-sm leading-relaxed text-[#A3A3A3]">{{ $categoryDescriptions[$key] ?? '' }}</p>
                        </div>

                        <ul class="divide-y divide-white/10 border-t border-white/10">
                            @foreach ($items as $skill)
                                <li class="flex items-start justify-between gap-4 py-3">
                                    <span class="text-sm font-medium text-white">{{ $skill->name }}</span>
                                    <span class="text-right text-xs text-[#A3A3A3]">{{ $skill->detail }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </article>
                @endif
            @endforeach
        </div>
    </div>
</section>
