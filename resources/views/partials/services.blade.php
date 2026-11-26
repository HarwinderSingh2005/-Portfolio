<section id="services" class="relative border-t border-white/10 bg-transparent py-24 md:py-32">
    <div class="mx-auto w-full max-w-[1400px] px-5 sm:px-7 lg:px-10" data-reveal>
        <div class="mb-12 max-w-2xl">
            <p class="mb-3 text-xs font-medium uppercase tracking-[0.2em] text-[#A3A3A3]">Services</p>
            <h2 class="mb-3 font-display text-3xl font-bold text-white md:text-4xl lg:text-5xl" style="text-wrap: balance;">What I Can Build For You</h2>
            <p class="text-base text-[#A3A3A3] md:text-lg">End-to-end web development spanning clean interfaces, structured backends, and relational databases.</p>
        </div>

        <div class="grid grid-cols-2 gap-3 sm:gap-5 md:grid-cols-3 lg:grid-cols-5">
            @foreach ($services as $service)
                <div data-tilt="5" class="transition-transform duration-200 ease-out will-change-transform">
                    <article class="flex h-full flex-col justify-between gap-4 rounded-2xl border border-white/10 bg-[#0A0A0A]/90 p-4 transition duration-300 hover:-translate-y-1 hover:border-white/25 hover:shadow-[0_20px_50px_rgba(255,255,255,0.06)] md:p-6">
                        <div>
                            <div class="mb-5 flex items-center justify-between gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5">
                                    <x-icon :name="$service->icon" class="h-5 w-5 text-white" />
                                </div>
                                <span class="font-mono text-xs text-[#737373]">{{ sprintf('%02d', $loop->iteration) }}</span>
                            </div>
                            <h3 class="mb-2 font-display text-sm font-semibold leading-snug text-white md:text-base">{{ $service->title }}</h3>
                            <p class="text-xs leading-relaxed text-[#A3A3A3] md:text-sm">{{ $service->description }}</p>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
