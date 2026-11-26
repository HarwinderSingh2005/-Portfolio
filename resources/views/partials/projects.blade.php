@php
    $projectModal = $projects->values()->map(fn ($project, $i) => [
        'index' => sprintf('%02d', $i + 1),
        'title' => $project->title,
        'category' => $project->category,
        'description' => $project->description,
        'features' => $project->features ?? [],
        'technologies' => $project->technologies ?? [],
        'repo_url' => $project->repo_url,
        'status_note' => $project->status_note,
    ])->values();
@endphp

<section id="projects" class="relative border-t border-white/10 bg-transparent py-24 md:py-32"
    x-data="{ selected: null, items: @js($projectModal) }" @keydown.escape.window="selected = null">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/20"></div>
    <div class="relative mx-auto w-full max-w-[1400px] px-5 sm:px-7 lg:px-10">
        <div class="mb-12 max-w-2xl" data-reveal>
            <p class="mb-3 text-xs font-medium uppercase tracking-[0.2em] text-[#A3A3A3]">Portfolio Showcase</p>
            <h2 class="mb-3 font-display text-3xl font-bold text-white md:text-4xl lg:text-5xl" style="text-wrap: balance;">Selected Work</h2>
            <p class="text-lg text-[#A3A3A3]">Projects That Bring Ideas to Life.</p>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            @foreach ($projects as $project)
                <article data-tilt="4" class="group flex w-full flex-col justify-between overflow-hidden rounded-2xl border border-white/10 bg-[#0A0A0A]/90 transition duration-300 hover:-translate-y-1 hover:border-white/25 hover:shadow-[0_24px_70px_rgba(255,255,255,0.07)]">
                    <div>
                        <div class="relative aspect-[4/3] overflow-hidden border-b border-white/10 bg-[#0F0F0F]">
                            @if ($project->image && is_file(public_path(ltrim($project->image, '/'))))
                                <img src="{{ $project->image }}" alt="{{ $project->title }}" loading="lazy"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.04]" />
                            @endif
                            <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#0A0A0A] via-transparent to-transparent opacity-75"></div>
                        </div>

                        <div class="p-6 pb-5">
                            <div class="mb-3 flex items-center gap-2 text-xs text-[#A3A3A3]">
                                <span class="font-mono text-[#737373]">{{ sprintf('%02d', $loop->iteration) }}</span>
                                <span aria-hidden="true">·</span>
                                <span>{{ $project->category }}</span>
                            </div>
                            <h3 class="mb-2.5 font-display text-xl font-semibold text-white transition-colors group-hover:text-[#E5E5E5]">{{ $project->title }}</h3>
                            <p class="mb-5 text-sm leading-relaxed text-[#A3A3A3]">{{ $project->summary }}</p>
                            <p class="border-t border-white/10 pt-4 text-xs leading-relaxed text-[#A3A3A3]">{{ implode(' · ', $project->technologies ?? []) }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-3 border-t border-white/10 bg-[#0F0F0F]/80 px-6 py-4">
                        <button type="button" @click="selected = items[{{ $loop->index }}]"
                            class="inline-flex shrink-0 cursor-pointer items-center gap-1.5 whitespace-nowrap text-sm font-medium text-white transition hover:text-[#D4D4D4]">
                            <span>View Details</span>
                            <x-icon name="arrow-up-right" class="h-4 w-4" />
                        </button>
                        @if ($project->repo_url)
                            <a href="{{ $project->repo_url }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex shrink-0 items-center gap-1.5 whitespace-nowrap text-xs font-medium text-[#A3A3A3] transition hover:text-white">
                                <x-icon name="github" class="h-4 w-4" />
                                <span>GitHub</span>
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>

    <div x-show="selected !== null" x-cloak role="dialog" aria-modal="true" @click.self="selected = null"
        class="fixed inset-0 z-[60] flex items-center justify-center bg-black/75 p-4 backdrop-blur-md sm:p-6">
        <div class="relative max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-2xl border border-white/10 bg-[#0A0A0A] p-6 shadow-[0_30px_100px_rgba(0,0,0,0.8)] md:p-8">
            <button type="button" @click="selected = null" aria-label="Close project details"
                class="absolute right-4 top-4 rounded-lg p-2 text-[#A3A3A3] transition hover:bg-white/5 hover:text-white">
                <x-icon name="x" class="h-5 w-5" />
            </button>
            <template x-if="selected">
                <div>
                    <p class="mb-2 text-xs text-[#A3A3A3]" x-text="selected.index + ' · ' + (selected.category || '')"></p>
                    <h3 class="mb-3 pr-10 font-display text-2xl font-bold text-white" x-text="selected.title"></h3>
                    <p class="mb-5 text-sm leading-relaxed text-[#A3A3A3]" x-text="selected.description"></p>
                    <ul class="mb-6 space-y-2">
                        <template x-for="feature in selected.features" :key="feature">
                            <li class="flex items-start gap-3 text-sm text-white/90">
                                <span aria-hidden="true" class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-white"></span>
                                <span x-text="feature"></span>
                            </li>
                        </template>
                    </ul>
                    <p class="mb-3 border-t border-white/10 pt-4 text-xs text-[#D4D4D4]" x-text="selected.technologies.join(' · ')"></p>
                    <p class="mb-4 text-xs text-[#737373]" x-text="selected.status_note"></p>
                    <a x-show="selected.repo_url" :href="selected.repo_url" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 text-sm font-medium text-white underline decoration-white/30 underline-offset-4 hover:decoration-white">
                        <span>View on GitHub</span>
                    </a>
                </div>
            </template>
        </div>
    </div>
</section>
